<?php

namespace App\Http\Controllers;

use App\Facades\MailSender;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Traits\CartTrait;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Coupon\app\Services\CouponService;
use Modules\Order\app\Http\Enums\OrderStatus;
use Modules\Order\app\Http\Enums\PaymentStatus;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderBillingAddress;
use Modules\Order\app\Models\OrderPaymentDetails;
use Modules\Order\app\Models\OrderShippingAddress;
use Modules\Order\app\Models\TransactionHistory;
use Modules\Product\app\Models\Product;
use Modules\Product\app\Services\ProductService;
use Modules\Shipping\app\Models\ShippingRule;
use Modules\Shipping\app\Models\ShippingSetting;
use Throwable;

class MarketingOrderProcessController extends Controller
{
    use CartTrait;


    public function __construct(
        protected ProductService $productService,
        protected CouponService $couponService
    ) {}


    public function productMarketingDetails($slug)
    {
        $product = Product::with([
            'marketingDetails',
            'variants',
            'variantImage' => [
                'attribute',
                'attributeValue',
            ],
            'categories'   => function ($q) {
                $q->with('translation');
            },
            'brand'        => function ($q) {
                $q->with('translation');
            },
            'translation',
            'vendor'       => function ($q) {
                $q->withCount('reviews')->withAvg('reviews', 'rating');
            },
            'variants'     => [
                'options' => [
                    'attribute',
                    'attributeValue.translation',
                ],
            ],
            'reviews'      => function ($q) {
                $q->where('status', 1)
                    ->with('user')
                    ->latest()
                    ->take(10);
            },
        ])
            ->where('slug', $slug)->published()->firstOrFail();

        $product->increment('viewed');

        $marketing = $product->marketingDetails;

        pushToGTM([
            'event'        => 'page_view',
            'page_type'    => 'product_detail',
            'product_id'   => $product->id,
            'product_name' => $product->name,
            'user_id'      => auth()->id() ?? 0,
            'user_role'    => auth()->check() ? auth()->user()->name : 'guest',
            'language'     => getSessionLanguage(),
        ]);

        $pixelData = [
            'content_ids'  => [$product->id],
            'content_name' => $product->name,
            'content_type' => 'product',
            'value'        => (float) $product->price,
            'currency'     => 'USD',
        ];

        session()->flash('pixel_payload', [
            'event' => 'ViewContent',
            'data'  => $pixelData,
        ]);

        $countries = Country::all();


        $shippingSetting = ShippingSetting::first();

        $direction = $shippingSetting->sort_shipping_direction;

        $shippingRules = ShippingRule::whereStatus(1)->orderBy('from', $direction)->get();

        $shippingRuleFirstId = $shippingRules->first()->id;

        $sku = $product->sku;

        if ($product->has_variant) {
            $variantData = $product->variants->where('is_default', 1)->first();
            $sku = $variantData->sku ?? $product->sku;
        }

        $gData = $this->generatePriceData($product, 1, $sku, $shippingRuleFirstId);

        $data = $this->getReadyCartData($gData);

        return view('website.product-marketing-details', compact('product', 'marketing', 'countries', 'shippingRules', 'data'));
    }

    public function getMarketingPrice(Request $request)
    {
        try {
            $product = Product::find($request->product_id);

            $data = $this->generatePriceData($product, $request->qty, $request->sku, $request->shipping_id);


            return array_merge(
                [
                    'status' => 'true',
                ],
                $this->getReadyCartData($data)
            );

            return response()->json(array_merge([
                'status' => 'true',
            ], $this->getReadyCartData($data)));
        } catch (Exception $th) {
            return response()->json([
                'status' => 'false',
                'message' => $th->getMessage()
            ]);
        }
    }

    private function getReadyCartData($data)
    {
        return [
            'data' => $data,
            'qty' => $data['generatedData']['qty'],
            'price' => $data['generatedData']['sub_total'],
            'price_with_currency' => currency($data['generatedData']['sub_total']),
            'total_tax' => $data['generatedData']['tax_amount'],
            'total_tax_with_currency' => currency($data['generatedData']['tax_amount']),
            'subtotal_price' => $data['generatedData']['total'],
            'subtotal_price_with_currency' => currency($data['generatedData']['total']),
            'delivery_charge' => $data['deliveryCharge'],
            'delivery_charge_with_currency' => currency($data['deliveryCharge']),
            'total_price' => $data['total_price'],
            'total_price_with_currency' => currency($data['total_price'])
        ];
    }

    private function generatePriceData($product, $qty, $sku, $shippingId)
    {
        $shippingRules = ShippingRule::find($shippingId);

        $deliveryCharge = $shippingRules->price;

        $data = $this->generateCartItemData($product, $qty, $sku);

        $totalPrice = bcadd($data['total'], $deliveryCharge, 2);

        return [
            'generatedData' => $data,
            'deliveryCharge' => $deliveryCharge,
            'total_price' => $totalPrice,
        ];
    }

    /**
     * @param Request $request
     */
    public function placeMarketingOrder(Request $request)
    {
        try {
            $product = Product::find($request->product_id);

            $genData = $this->generatePriceData($product, $request->quantity, $request->sku, $request->shipping);

            $data = $this->getReadyCartData($genData);

            DB::beginTransaction();

            $orderDetails                              = new OrderPaymentDetails();
            $orderDetails->coupon_code                 = null;
            $orderDetails->total_discount              = 0;
            $orderDetails->payable_amount              = $data['total_price'];
            $orderDetails->payable_amount_without_rate = $data['total_price'];
            $orderDetails->payable_currency            = 'BDT';
            $orderDetails->paid_amount                 = 0;
            $orderDetails->transaction_id              = null;
            $orderDetails->payment_details             = null;
            $orderDetails->payment_method              = $request->payment_method;
            $orderDetails->payment_status              = PaymentStatus::PENDING->value;
            $orderDetails->save();

            $orderPaymentDetails = $orderDetails;

            $vendor = $product->vendor;

            $order                           = new Order();
            $order->order_id                 = generateInvoiceNumber();
            $order->user_id                  = 0;
            $order->vendor_id                = $vendor->id;
            $order->note                     = $request->note;
            $order->tax                      = $data['total_tax'];
            $order->shipping                 = $data['delivery_charge'];
            $order->sub_total                = $data['subtotal_price'];
            $order->gateway_fee              = 0;
            $order->total_amount             = $data['total_price'];
            $order->order_payment_details_id = $orderPaymentDetails->id;
            $order->coupon_code              = null;
            $order->discount                 = 0;
            $order->order_status             = OrderStatus::PENDING->value;
            $order->is_guest_order           = 1;
            $order->save();

            if ($order && $order->paymentDetails->payment_method == 'free') {
                $this->storeTransactionHistory($order, $orderPaymentDetails->transaction_id);
            }

            $shippingAddress = $this->makeGuestShippingAddressObject($request);

            $shippingAddress = $this->storeShippingAddress($order, $shippingAddress);

            $address           = new OrderBillingAddress();
            $address->order_id = $order->id;
            $address->user_id  = $order->user_id;
            $address->name     = $shippingAddress->name;
            $address->email    = $shippingAddress->email;
            $address->phone    = $shippingAddress->phone;
            $address->country  = $shippingAddress->country;
            $address->state    = $shippingAddress->state;
            $address->city     = $shippingAddress->city;
            $address->zip_code = $shippingAddress->zip_code;
            $address->address  = $shippingAddress->address;
            $address->save();

            $this->addProductToOrder($order, $genData['generatedData']);

            $this->generateGTMData($order);

            session()->flash('pixel_payload', [
                'event' => 'Purchase',
                'data'  => $this->generateFacebookPixelData($order),
            ]);

            $this->sendEmailToCustomer($order);
            $this->sendEmailToVendor($order, $vendor);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            logError("Unable to create order", $e);

            return back()->with([
                'alert-type' => 'error',
                'message'    => __('Something went wrong while processing order'),
            ]);
        }

        return to_route('website.invoice', ['uuid' => $order->uuid])->with([
            'alert-type' => 'success',
            'message'    => __('Order placed successfully'),
        ]);
    }


    private function storePaymentDetails($data, $isFreePurchase = false): OrderPaymentDetails
    {
        try {
            $orderDetails                              = new OrderPaymentDetails();
            $orderDetails->coupon_code                 = $data['couponCode'];
            $orderDetails->total_discount              = $data['discount'];
            $orderDetails->payable_amount              = $data['totalPayable'];
            $orderDetails->payable_amount_without_rate = $data['payableAmountWithoutRate'];
            $orderDetails->payable_currency            = $data['payableCurrency'];
            $orderDetails->paid_amount                 = 0;
            $orderDetails->transaction_id              = $isFreePurchase ? uniqid('free_') : null;
            $orderDetails->payment_details             = null;
            $orderDetails->payment_method              = $isFreePurchase ? 'free' : $data['requestData']->payment_method;
            $orderDetails->payment_status              = $isFreePurchase ? PaymentStatus::COMPLETED->value : PaymentStatus::PENDING->value;
            $orderDetails->save();

            return $orderDetails;
        } catch (Throwable $th) {
            logError('Order Payment Details Error', $th);

            throw new HttpResponseException(back()->with([
                'alert-type' => 'error',
                'message'    => __('Something went wrong while processing payment details'),
            ]));
        }
    }

    /**
     * @param  $order
     * @param  $trxId
     * @return mixed
     */
    private function storeTransactionHistory($order, $trxId)
    {
        $newTH                  = new TransactionHistory();
        $newTH->order_id        = $order->id;
        $newTH->user_id         = $order->user_id;
        $newTH->vendor_id       = $order->vendor_id;
        $newTH->payment_method  = $order->paymentDetails->payment_method;
        $newTH->transaction_id  = $trxId;
        $newTH->payment_details = $order->paymentDetails->payment_details;
        $newTH->amount          = $order->paymentDetails->paid_amount;
        $newTH->currency        = $order->paymentDetails->payable_currency;
        $newTH->status          = $order->paymentDetails->payment_status->value;
        $newTH->save();

        return $newTH;
    }

    /**
     * @param  $order
     * @param  $shippingAddress
     * @return mixed
     */
    private function storeShippingAddress($order, $shippingAddress)
    {
        $address                   = new OrderShippingAddress();
        $address->order_id         = $order->id;
        $address->user_id          = $order->user_id;
        $address->name             = $shippingAddress->name;
        $address->email            = $shippingAddress->email;
        $address->phone            = $shippingAddress->phone;
        $address->country          = $shippingAddress->country->name;
        $address->state            = $shippingAddress->state->name;
        $address->city             = $shippingAddress->city->name;
        $address->zip_code         = $shippingAddress->zip_code;
        $address->address          = $shippingAddress->address;
        $address->walk_in_customer = $shippingAddress->walk_in_customer;
        $address->type             = $shippingAddress->type;
        $address->save();

        return $address->refresh();
    }

    /**
     * @param  $request
     * @return mixed
     */
    private function makeGuestShippingAddressObject($request)
    {
        $obj                   = new \stdClass();
        $obj->name             = $request->name;
        $obj->email            = $request->email;
        $obj->phone            = $request->phone;
        $obj->zip_code         = $request->post_code;
        $obj->address          = $request->address;
        $obj->walk_in_customer = 0;
        $obj->type             = 'home';

        $obj->country = Country::find($request->country_id);
        $obj->state   = State::find($request->state_id);
        $obj->city    = City::find($request->city_id);

        return $obj;
    }

    /**
     * @param $order
     * @param $cartContents
     */
    public function addProductToOrder($order, $value = null): void
    {
        $orderDetails = [
            'user_id'           => $order->user_id,
            'product_id'        => data_get($value, 'id'),
            'vendor_id'         => data_get($value, 'vendor_id'),
            'qty'               => data_get($value, 'qty'),
            'price'             => data_get($value, 'price'),
            'tax_amount'        => data_get($value, 'tax_amount'),
            'total_price'       => data_get($value, 'total'),
            'options'           => data_get($value, 'has_variant') ? data_get($value, 'variant.attribute') : null,
            'product_name'      => data_get($value, 'name'),
            'product_thumbnail' => data_get($value, 'image'),
            'product_sku'       => data_get($value, 'sku'),
            'is_variant'        => data_get($value, 'has_variant'),
            'measurement'       => data_get($value, 'measure_unit'),
            'weight'            => data_get($value, 'weight'),
            'commission_rate'   => getSettings('product_commission_rate'),
            'is_flash_deal'     => data_get($value, 'is_flash_deal'),
        ];

        $order->items()->create($orderDetails);

        $getItem = $order->items()->where(
            [
                'user_id'     => $order->user_id,
                'product_id'  => data_get($value, 'id'),
                'product_sku' => data_get($value, 'sku'),
                'vendor_id'   => data_get($value, 'vendor_id'),
                'qty'         => data_get($value, 'qty'),
            ]
        )->first() ?? $order->items()->latest()->first();

        $this->calculateStoreCommission($getItem->total_price, $getItem, $order);
    }


    private function calculateStoreCommission($itemPrice, $newOrder, $order)
    {
        $qty  = (string) $newOrder->qty;
        $rate = (string) $newOrder->commission_rate;

        // Commission logic
        $rateFraction     = bcdiv($rate, '100', 6);
        $commissionAmount = bcmul($itemPrice, $rateFraction, 6);
        $amountAfterCut   = bcsub($itemPrice, $commissionAmount, 6);
        $amountAfterCut   = bcround($amountAfterCut, 2);

        $totalCommission = bcmul($amountAfterCut, $qty, 2);

        $newOrder->commission = $totalCommission;

        if ($newOrder->save() && $order->paymentDetails->payment_status == PaymentStatus::COMPLETED && $newOrder?->vendor) {
            saveWalletHistory($newOrder, $order);
        }
    }

    /**
     * @param $order
     */
    private function sendEmailToCustomer($order)
    {
        try {
            $order->refresh();

            [$subject, $message] = MailSender::fetchEmailTemplate('order_placed', [
                'user_name'        => $order->shippingAddress->name ?? $order->user->name ?? 'Name Missing!',
                'order_id'         => $order->order_id,
                'order_status'     => $order->order_status->getLabel(),
                'amount'           => $order->paymentDetails->payable_amount,
                'amount_currency'  => $order->paymentDetails->payable_currency,
                'payment_method'   => $order->paymentDetails->payment_method,
                'payment_status'   => $order->paymentDetails->payment_status->getLabel(),
                'shipping_address' => $order->shippingAddress->full_address ?? '',
            ]);

            $link = [
                __('INVOICE') . ' #' . ($order->order_id) => route('website.invoice', ['uuid' => $order->uuid]),
                __('COMPLETE PAYMENT')                    => route('website.complete.payment', ['uuid' => $order->uuid]),
            ];

            MailSender::sendMail($order->billingAddress->email, $subject, $message, $link);
        } catch (Exception $e) {
            logError("Unable to send order placed email to {$order?->billingAddress?->email} for #{$order->order_id}", $e);
        }
    }

    /**
     * @param $order
     * @param $vendorIds
     */
    private function sendEmailToVendor($order, $vendor)
    {
        try {
            $order->refresh();

            [$subject, $message] = MailSender::fetchEmailTemplate('order_placed_vendor', [
                'user_name'        => $vendor->shop_name ?? 'Name Missing!',
                'shop_name'        => $vendor->shop_name ?? 'Name Missing!',
                'order_id'         => $order->order_id,
                'order_status'     => $order->order_status->getLabel(),
                'amount'           => $order->paymentDetails->payable_amount,
                'amount_currency'  => $order->paymentDetails->payable_currency,
                'payment_method'   => $order->paymentDetails->payment_method,
                'payment_status'   => $order->paymentDetails->payment_status->getLabel(),
                'shipping_address' => $order->shippingAddress->full_address ?? '',
            ]);

            $link = [
                __('ORDER DETAILS') . ' #' . ($order->order_id) => route('seller.orders.show', ['id' => $order->order_id]),
            ];

            MailSender::sendMail($vendor->email, $subject, $message, $link);
        } catch (Exception $e) {
            logError('Unable to send order placed email to vendors for #{$order->order_id}', $e);
        }
    }

    /**
     * @param $order
     */
    private function generateGTMData($order)
    {
        $items = [];

        foreach ($order->items as $item) {
            $name = $item->is_variant == 1 ? $item->product_name . ' | ' . $item->product_sku . ' | ' . $item->options : $item->product_name . ' | ' . $item->product_sku;

            $items[] = [
                'item_id'   => $item->product_id,
                'item_name' => $name,
                'price'     => (float) number_format($item->price, 2, '.', ''),
                'quantity'  => (int) $item->qty,
            ];
        }

        pushToGTM([
            'event'     => 'purchase',
            'user_id'   => auth()->id() ?? 0,
            'user_role' => auth()->check() ? auth()->user()->name : 'guest',
            'language'  => getSessionLanguage(),
            'ecommerce' => [
                'transaction_id' => $order->order_number ?? $order->id,
                'value'          => (float) number_format($order->payable_amount, 2, '.', ''),
                'currency'       => $order->payable_currency ?? 'USD',
                'items'          => $items,
            ],
        ]);
    }

    /**
     * @param  $order
     * @return mixed
     */
    private function generateFacebookPixelData($order)
    {
        $contents = [];

        foreach ($order->items as $item) {
            $contents[] = [
                'id'         => $item->product_sku,
                'quantity'   => (int) $item->qty,
                'item_price' => (float) number_format($item->price, 2, '.', ''),
            ];
        }

        return [
            'contents'     => $contents,
            'content_type' => 'product',
            'value'        => (float) number_format($order->payable_amount, 2, '.', ''),
            'currency'     => $order->payable_currency ?? 'USD',
        ];
    }
}
