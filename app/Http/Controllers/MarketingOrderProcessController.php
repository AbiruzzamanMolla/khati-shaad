<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarketingOrderProcessController extends Controller
{
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

        return $request;


        if ($order->paymentDetails->payment_method == 'hand_cash') {
            return to_route('website.invoice', ['uuid' => $order->uuid])->with([
                'alert-type' => 'success',
                'message'    => __('Order placed successfully'),
            ]);
        }
    }
}
