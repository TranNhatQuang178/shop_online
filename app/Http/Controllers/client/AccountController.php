<?php

namespace App\Http\Controllers\client;

use App\Component\Customers;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    private $customer;
    function __construct(Customers $customer)
    {
        $this->customer = $customer;
    }
    function register()
    {
        return view('client.account.register');
    }


    function registerStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:4|max:255',
                'email' => 'required|email|unique:customers',
                'phone' => 'required|',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]
        );
        if ($validator->passes()) {
            $remember_token = Hash::make(time() . $request->email);
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'remember_token' => $remember_token,
                'password' => Hash::make($request->confirm_password),
            ]);
            Mail::send('client.mail.mail_verify', compact('customer'), function ($message) use ($customer) {
                $message->to($customer->email, $customer->name);
                $message->subject('Xác nhận đăng ký tài khoản tại - ' . env('APP_NAME'));
            });
            return response()->json([
                'status' => 200,
                'location' => route('login'),
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'errors' => $validator->errors()
            ]);
        }
    }

    function verify(Request $request, $rememberToken)
    {
        if ($rememberToken) {
            $customer = Customer::where('remember_token', $rememberToken)->first();
            if ($customer) {
                if ($customer->remember_token == $rememberToken) {
                    $customer->update([
                        'active' => 1,
                        'remember_token' => null
                    ]);
                    return redirect()->route('verify.successfully');
                }
            } else {
                return redirect()->route('verify.fail');
            }
        } else {
            return abort(404);
        }
    }

    function verifySuccessfully()
    {
        return view('client.account.verify.verify_successfully');
    }

    function verifyFail()
    {
        return view('client.account.verify.verify_fail');
    }

    function login()
    {
        return view('client.account.login');
    }

    function checkLogin(Request $request)
    {
        $check =  $this->customer->checkLogin($request->email, $request->password);
        if ($check) {
            Session::put(['email' => $request->email, 'is_login' => true]);
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('errorLogin', 'Invalid email address or password. Please try again');
        }
    }

    function account()
    {
        $email = session('email');
        $customer = Customer::where('email', $email)->first();
        return view('client.account.view', compact('customer'));
    }

    function update(Customer $customer, Request $request)
    {
        if ($customer) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|min:4|max:255',
                    'phone' => 'required|',
                ]
            );
            if ($validator->passes()) {
                $customer->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address
                ]);
                return response()->json([
                    'status' => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'errors' => $validator->errors()
                ]);
            }
        }
    }

    function changePassword()
    {
        return view('client.account.change_password');
    }

    function changePasswordStore(Customer $customer, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:4|max:255',
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validator->passes()) {
            if (Hash::check($request->old_password, $customer->password)) {
                $customer->update([
                    'password' => Hash::make($request->confirm_password),
                ]);
                return response()->json([
                    'status' => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'error' => 'The old password is incorrect'
                ]);
            }
        } else {
            return response()->json([
                'status' => 500,
                'errors' => $validator->errors()
            ]);
        }
    }

    function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }

    function wishlist()
    {
        if (isLogin()) {
            $customerId = infoUser(session('email'), 'id');
            $wishList = WishList::select('wish_lists.*', 'products.name', 'products.price', 'products.slug')->where('customer_id', $customerId)->leftJoin('products', 'products.id', 'wish_lists.product_id')->get();
        }
        return view('client.account.wishlist', ['wishList' => $wishList]);
    }

    function addWishList(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        if ($product != null) {
            if (isLogin()) {
                $customerId = infoUser(session('email'), 'id');
                $wishList = WishList::where('customer_id', $customerId)->get();
                foreach ($wishList as $item) {
                    if ($product->id == $item->product_id) {
                        return response()->json([
                            'status' => false,
                            'mess' => $product->name . " already added in cart"
                        ]);
                    }
                }
                WishList::create([
                    'product_id' => $request->id,
                    'customer_id' => $customerId
                ]);
                return response()->json([
                    'status' => true,
                    'mess' => $product->name . " add in wishlist successful"
                ]);
            }
            return response()->json([
                'status' => 500,
                'mess' => 'Please log in to be added to your wish list!'
            ], 401);
        }
        return response()->json([
            'status' => false,
            'mess' => 'Product not found!'
        ]);
    }

    function wishlistRemove($id)
    {
        $wishList = WishList::where('id', $id)->first();
        if($id == "" && $wishList == null){
            return response()->json([
                'status' => false,
                'mess' => 'Not found!'
            ]);
        }
        $customerId = infoUser(session('email'), 'id');
        WishList::where([['customer_id', $customerId], ['id', $id]])->delete();
        return response()->json([
            'status' => true,
            'mess' => 'Remove success!'
        ]);
    }

    function myOrder()
    {
        if (isLogin()) {
            $customerId = infoUser(session('email'), 'id');
            $orders = Order::where('customer_id', $customerId)->get();
        }
        return view('client.account.my_order', compact('orders'));
    }

    function orderDetail($id)
    {
        $customerId = infoUser(session('email'), 'id');
        $order = Order::where([['customer_id', $customerId], ['id', $id]])->first();
        $orderItems = OrderDetail::where('order_id', $id)->get();
        return view('client.account.order_detail', compact('orderItems', 'order'));
    }
}
