<?php

namespace App\Http\Controllers;

use App\Facades\MailSender;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Order\app\Http\Enums\OrderStatus;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderBillingAddress;
use Modules\Order\app\Models\OrderShippingAddress;
use Modules\Order\app\Models\TransactionHistory;

class MarketingOrderProcessController extends Controller
{
    /**
     * @param Request $request
     */
    public function placeMarketingOrder(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'phone' => 'required',
        //     'address' => 'required',
        //     'country' => 'required',
        //     'city' => 'required',
        //     'post_code' => 'required',
        //     'note' => 'required',
        // ]);

        // return $request;

        try {
            DB::beginTransaction();

            $order                           = new Order();
            $order->order_id                 = generateInvoiceNumber();
            $order->user_id                  = $data['userId'];
            $order->vendor_id                = $vendor->id;
            $order->note                     = $data['requestData']->note;
            $order->tax                      = $cartTotalTax;
            $order->shipping                 = $singleShippingCost;
            $order->sub_total                = $cartTotal;
            $order->gateway_fee              = $gatewayCharge;
            $order->total_amount             = $totalAmount;
            $order->order_payment_details_id = $orderPaymentDetails->id;
            $order->coupon_code              = $data['couponCode'];
            $order->discount                 = $cartCouponDiscount;
            $order->order_status             = $data['isFreePurchase'] ? OrderStatus::APPROVED->value : OrderStatus::PENDING->value;
            $order->is_guest_order           = $data['isGuestCheckout'] ? 1 : 0;
            $order->save();

            if ($order && $order->paymentDetails->payment_method == 'free') {
                $this->storeTransactionHistory($order, $orderPaymentDetails->transaction_id);
            }

            $storedShippingAddress = $this->storeShippingAddress($order, $shippingAddress);

            $this->storeBillingAddress($order, $data['requestData'], $storedShippingAddress);

            $this->addProductsToOrder($order, $cartItems);

            $this->generateGTMData($order);

            session()->flash('pixel_payload', [
                'event' => 'Purchase',
                'data'  => $this->generateFacebookPixelData($order),
            ]);

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
     * @param $order
     * @param $billingAddress
     * @param bool|OrderShippingAddress $shippingAddress
     */
    private function storeBillingAddress($order, $billingAddress, bool | OrderShippingAddress $shippingAddress = false)
    {
        $address           = new OrderBillingAddress();
        $address->order_id = $order->id;
        $address->user_id  = $order->user_id;
        $address->name     = $billingAddress->name;
        $address->email    = $billingAddress->email;
        $address->phone    = $billingAddress->phone;

        if ($billingAddress->same_as_shipping == 1 && $shippingAddress) {
            $address->country  = $shippingAddress->country;
            $address->state    = $shippingAddress->state;
            $address->city     = $shippingAddress->city;
            $address->zip_code = $shippingAddress->zip_code;
            $address->address  = $shippingAddress->address;
        } else {
            $address->country  = $billingAddress->country;
            $address->state    = $billingAddress->state;
            $address->city     = $billingAddress->city;
            $address->zip_code = $billingAddress->zip;
            $address->address  = $billingAddress->address;
        }

        $address->save();
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
        $obj->zip_code         = $request->zip;
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
    public function addProductsToOrder($order, $cartContents = null): void
    {
        if ($cartContents == null) {
            $cartContents = $this->getSessionCart();
        }

        foreach ($cartContents as $value) {
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
