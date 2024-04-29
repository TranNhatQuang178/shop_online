<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CartCustomer;
use App\Models\CustomerAddress;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Validator;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;
use App\Component\DiscountHandler;

class CheckoutController extends Controller
{
    public function index()
    {
        $shipping = 0;
        $coupon = 0;
        $cartTotal = 0;
        $grandTotal = 0;
        if (session()->has('email')) {
            $customer = Customer::where('email', session('email'))->first();
            $cartTotal = CartCustomer::getTotalPriceByCustomerId($customer->id);
        }
        $countries = Country::all();
        return view('client.checkout', compact('countries', 'shipping', 'coupon', 'cartTotal'));
    }

    public function processCheckout(Request $request)
    {
        //Step 1 : Validate Form
        $rules = [
            'full_name' => 'required',
            'email' => 'required',
            'country' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'phone' => 'required',
            'payment' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $customer_id = null;
            $total = Cart::subtotal();
            $coupon = 0;
            $discount = 0;
            $grandTotal = Cart::subtotal();
            //Step 2: Store table customer_address
            if (session()->has('is_login')) {
                $customer = Customer::where('email', session('email'))->first();
                $customer_id = $customer->id;
                $total = CartCustomer::getTotalPriceByCustomerId($customer->id);
            }
            //Step 3: Store table orders
            if (session()->has('code')) {
                $code = session('code');
                $discount_amount = DiscountCode::where('code', $code)->first();
                $discount = $discount_amount->discount_amount;
                $coupon = session('coupon');
                $grandTotal = session('grandTotal');
            }
            $order = Order::create([
                'order_code' => "#" . Str::slug(preg_replace("/( | )/", "", env("APP_NAME"))) . time(),
                'customer_id' => $customer_id,
                'fullname' => $request->full_name,
                'email' => $request->email,
                'country_id' => $request->country,
                'address' => $request->address,
                'apart_ment' => $request->appartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'mobile' => $request->phone,
                'notes' => $request->order_notes,
                'status' => 1,
                'coupon' => $coupon,
                'discount' => $discount,
                'total' => $total,
                'grand_total' => $grandTotal
            ]);

            CustomerAddress::create(
                [
                    'order_id' => $order->id,
                    'fullname' => $request->full_name,
                    'customer_id' => $customer_id,
                    'country_id' => $request->country,
                    'apartment' => $request->appartment,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->zip,
                    'order_notes' => $request->order_notes,
                ]
            );

            if (session()->has('is_login')) {
                if ($customer->cart->count() > 0) {
                    foreach ($customer->cart as $item) {
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'customer_id' => $customer_id,
                            'name' => $item->product->name,
                            'product_id' => $item->product_id,
                            'price' => $item->item_total,
                            'qty' => $item->qty,
                            'total_item' => $item->sub_total,
                            'total' => $total,
                        ]);
                    }
                    CartCustomer::where('customer_id', $customer_id)->delete();
                    DiscountHandler::deleteSessionDiscount();
                }
            } else {
                if (Cart::count() > 0) {
                    foreach (Cart::content() as $item) {
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'customer_id' => $customer_id,
                            'name' => $item->name,
                            'product_id' => $item->id,
                            'price' => $item->price,
                            'qty' => $item->qty,
                            'total_item' => $item->subtotal,
                            'total' => Cart::total(),
                        ]);
                    }
                }
            }
            Cart::destroy();

            return response()->json([
                'status' => true,
                'orderId' => $order->id
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function checkoutSuccess($orderId)
    {
        $order = Order::find($orderId);
        $orderItems = OrderDetail::select('order_details.*', 'products.name as productName')
            ->where('order_id', $order->id)
            ->leftJoin('products', 'products.id', 'order_details.product_id')
            ->get();
            // return $orderItems;
        return view('client.checkout_success', compact('order', 'orderItems'));
    }
}
