<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use App\Models\Product;
use App\Component\DiscountHandler;
use App\Models\CartCustomer;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $shipping = 0;
        $coupon = 0;
        $cartTotal = 0;
        if (session()->has('email')) {
            $customer = Customer::where('email', session('email'))->first();
            $cartTotal = CartCustomer::getTotalPriceByCustomerId($customer->id);
        }
        return view('client.cart.index', compact('shipping', 'coupon', 'cartTotal'));
    }

    public function add(Request $request)
    {
        $product = Product::find($request->id);
        if (Cart::count() > 0) {
            foreach (Cart::content() as $item) {
                if ($item->id == $product->id) {
                    return response()->json([
                        'status' => false,
                        'mess' => $product->name . " already added in cart"
                    ]);
                }
            }
        }
        if ($product != null) {
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->price,
                'options' => ['image' => !empty($product->productImage) ? $product->productImage->first() : '']
            ]);
            $subTotal = Cart::subtotal(2, '.', '');
            if (session()->has('code')) {
                $code = session()->get('code');
                $result = DiscountHandler::applyDiscount($subTotal, $code);
            }
            if (session()->has('email')) {
                $email = session()->get('email');
                $customer = Customer::where('email', $email)->first();
                $cartItems = CartCustomer::where('customer_id', $customer->id)->get();
                foreach ($cartItems as $cartItem) {
                    if ($cartItem->product_id == $product->id) {
                        return response()->json([
                            'status' => false,
                            'mess' => $product->name . " already added in cart"
                        ]);
                    }
                }
                CartCustomer::create([
                    'product_id' => $product->id,
                    'customer_id' => $customer->id,
                    'coupon' => session()->get('coupon') ? session()->get('coupon') : null,
                    'sub_total' => $product->price,
                    'total' => session()->get('grandTotal') ? session()->get('grandTotal') : Cart::subtotal(2, '.', ','),
                    'item_total' => $product->price,
                    'qty' => 1,
                ]);
            }
            return response()->json([
                'status' => true,
                'mess' => $product->name . " add in cart successful"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'mess' => "Product not found",
            ]);
        }
    }

    public function destroy()
    {
        Cart::destroy();
    }

    public function remove($rowId)
    {
        if (session()->has('email')) {
            $customer = Customer::where('email', session('email'))->first();
            CartCustomer::where([['customer_id', $customer->id], ['id', $rowId]])->delete();
            $cartTotal = CartCustomer::getTotalPriceByCustomerId($customer->id);
            if (session()->has('code')) {
                $code = session('code');
                $result = DiscountHandler::applyDiscount($cartTotal, $code);
                return response()->json($result);
            }
            return response()->json([
                'status' => true,
                'mess' => "Remove product in cart successful",
                "total" => number_format($cartTotal, 2, '.', ','),
                "subTotal" => number_format($cartTotal, 2, '.', ','),
                // 'subTotal' => Cart::subTotal(2, '.', ','),
            ]);
        }
        $item = Cart::get($rowId);
        if (!empty($item)) {
            Cart::remove($rowId);
            $subTotal = Cart::subtotal(2, '.', '');
            if (session()->has('code')) {
                $code = session()->get('code');
                $result = DiscountHandler::applyDiscount($subTotal, $code);
                return response()->json($result);
            }
            return response()->json([
                'status' => true,
                'mess' => "Remove product in cart successful",
                "total" => Cart::total(2, '.', ','),
                'subTotal' => Cart::subTotal(2, '.', ','),
            ]);
        }
        return response()->json([
            'status' => false,
            'mess' => "Product not found",
        ]);
    }
    public function update(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;
        if (session()->has('email')) {
            $email = session('email');
            $customer = Customer::where('email', $email)->first();
            $cartItem = CartCustomer::find($rowId);
            $itemTotal = $cartItem->item_total * $qty;
            CartCustomer::where([['customer_id', $customer->id], ['id', $cartItem->id]])->update([
                'qty' => $qty,
                'sub_total' => $itemTotal,
            ]);
            $total = CartCustomer::getTotalPriceByCustomerId($customer->id);
            if (session()->has('code')) {
                $code = session('code');
                $result = DiscountHandler::applyDiscount($total, $code, $itemTotal);
                return response()->json($result);
            }
            return response()->json([
                'status' => true,
                'rowId' => $rowId,
                'itemTotal' => number_format($itemTotal, 2, '.', ','),
                'subTotal' =>  number_format($total, 2, '.', ','),
                'total' => $total ? number_format($total, 2, '.', ',') : '',
            ]);
        } else {
            $item = Cart::get($rowId);
            if (!empty($item)) {
                Cart::update($rowId, $qty);
                $subTotal = Cart::subtotal(2, '.', '');
            }
            if (session()->has('code')) {
                $code = session('code');
                $result = DiscountHandler::applyDiscount($subTotal, $code,  $item->subtotal);
                return response()->json($result);
            }
            return response()->json([
                'status' => true,
                'subTotal' => $item ? number_format($item->subtotal, 2, '.', ',') : '',
                'total' => $subTotal ? number_format($subTotal, 2, '.', ',') : '',
                'rowId' => $request->rowId,
                'itemTotal' => $item->subtotal,
            ]);
        }
    }

    public function applyCoupon(Request $request)
    {
        if (!empty($request->code)) {
            $code = $request->code;
            $subTotal = Cart::subtotal(2, '.', '');
            if(session()->has('email')){
                $customer = Customer::getCustomerByEmail(session('email'));
                $total = CartCustomer::getTotalPriceByCustomerId($customer->id);
            }
            $discount = DiscountCode::where('code', $code)->first();
            if (!empty($discount)) {
                if (!empty($discount->starts_at) && !empty($discount->expires_at)) {
                    $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
                    $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $discount->starts_at);
                    if ($now < $startAt) {
                        return response()->json([
                            'status' => false,
                            'mess' => 'Coupon not invalid',
                            'subTotal' =>  session()->has('email') ? number_format($total, 2,'.',',') : number_format($subTotal, 2, '.', ','),
                        ]);
                    }
                    $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s', $discount->expires_at);
                    if ($now > $expiresAt) {
                        return response()->json([
                            'status' => false,
                            'mess' => 'Coupon has expired',
                            'subTotal' =>  session()->has('email') ? number_format($total, 2,'.',',') : number_format($subTotal, 2, '.', ','),
                        ]);
                    }
                }
                if(session()->has('email')){
                    $customer = Customer::getCustomerByEmail(session('email'));
                    $total = CartCustomer::getTotalPriceByCustomerId($customer->id);
                    $result = DiscountHandler::applyDiscount($total, $code);
                }else{
                    $result = DiscountHandler::applyDiscount($subTotal, $code);
                }
                return response()->json($result);
            } else {
                $sessions = ['coupon', 'code', 'grandTotal'];
                foreach ($sessions as $session) {
                    session()->forget($session);
                }
                return response()->json([
                    'status' => false,
                    'mess' => 'Coupon not invalid',
                    'subTotal' =>session()->has('email') ? number_format($total, 2,'.',',') : number_format($subTotal, 2, '.', ','),
                ]);
            }
        } else {
            if (session()->has('coupon') && session('grandTotal')) {
                $result = DiscountHandler::deleteSessionDiscount();
                return response()->json($result);
            }
        }
    }

    public function couponDelete()
    {
        if (session()->has('coupon') && session('grandTotal')) {
            $result = DiscountHandler::deleteSessionDiscount();
            return response()->json($result);
        }
    }
}
