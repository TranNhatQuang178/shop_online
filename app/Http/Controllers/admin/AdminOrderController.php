<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class AdminOrderController extends Controller
{
    public function index(Request $request)
    {

        $order = Order::latest('id');
        if ($request->keyword != "") {
            $keyword =  $request->keyword;
            $order = $order->where('fullname', 'like', "%$keyword%");
            $order = $order->Orwhere('order_code', 'like', '%' . $keyword . '%');
            $order = $order->Orwhere('email', 'like', "%$keyword");
            $order = $order->Orwhere('mobile', 'like', "%$keyword");
        }
        $orders = $order->paginate(25);
        return view('admin.order.index', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        $country = Country::select('name')->where('id', $order->country_id)->first();
        $orderItems = OrderDetail::select('order_details.*', 'products.name as productName')
            ->where('order_details.order_id', $order->id)
            ->leftJoin('products', 'products.id', 'order_details.product_id')
            ->get();
        return view('admin.order.detail', compact('order', 'country', 'orderItems'));
    }

    public function updateStatus($id, Request $request)
    {
        $status = $request->status;
        if ($status) {
            Order::where('id', $id)->update([
                'status' => $status
            ]);
            return response()->json([
                'status' => true,
                'mess' => 'Update status successful !'
            ]);
        }
    }

    public function sendMail(Order $order, Request $request)
    {
        if (!empty($order)) {
            $country = Country::select('name')->where('id', $order->country_id)->first();
            $orderItems = OrderDetail::select('order_details.*', 'products.name as productName')
                ->where('order_details.order_id', $order->id)
                ->leftJoin('products', 'products.id', 'order_details.product_id')
                ->get();
            if ($request->status === 'customer') {
                Mail::send('admin.mail.order_customer', compact('order', 'orderItems', 'country'), function ($message) use ($order) {
                    $message->to($order->email, $order->fullname);
                    $message->subject('Confirm Order - ' . env('APP_NAME'));
                });
            }

            return response()->json([
                'status' => true,
                'mess' => 'Send mail customer successful !'
            ]);
        }
    }
}
