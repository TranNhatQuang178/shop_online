<?php

namespace App\Component;

use App\Models\DiscountCode;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Customer;
use App\Models\CartCustomer;

class DiscountHandler
{
    public static function applyDiscount($subTotal, $code, $item = null)
    {
        $discount = DiscountCode::where('code', $code)->first();
        $coupon = 0;
        $grandTotal = 0;
        if (!empty($discount)) {
            if ($discount->type == "percent") {
                $discount_amount = $discount->discount_amount;
                $coupon = ($subTotal * $discount_amount) / 100;
            } else {
                $coupon = $discount->discount_amount;
            }
            $grandTotal = $subTotal - $coupon;
            session()->put(['coupon' => number_format($coupon, 2, '.', ','), 'grandTotal' => number_format($grandTotal, 2, '.', ','), 'code' => $code]);
        }
        return [
            'status' => true,
            'code' => $code,
            'coupon' => number_format($coupon, 2, '.', ','),
            'subTotal' => number_format($subTotal, 2, '.', ','),
            'grandTotal' => number_format($grandTotal, 2, '.', ','),
            'itemTotal' => !empty($item) ? number_format($item, 2, '.', ',') :'',
        ];
    }
    public static function deleteSessionDiscount()
    {
        $sessions = ['coupon', 'code', 'grandTotal'];
        foreach ($sessions as $session) {
            session()->forget($session);
        }
        if(session()->has('email')){
            $customer = Customer::getCustomerByEmail(session('email'));
            $total = CartCustomer::getTotalPriceByCustomerId($customer->id);
        }
        return [
            'status' => true,
            'mess' => 'Please enter coupon',
            'subTotal' => session()->has('email') ? number_format($total, 2,'.',',') : Cart::subtotal(2, '.', ','),
        ];
    }
}
