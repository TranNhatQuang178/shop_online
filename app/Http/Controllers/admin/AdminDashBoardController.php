<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashBoardController extends Controller
{
    function index(){
        $totalOrders = Order::count();
        $totalCustomers = Customer::count();
        $totalProducts = Product::count();
        $totalSale = Order::where('status',3)->sum('grand_total');
        $totalUserAdmin = User::count();
        return view('admin/dashboard', compact('totalOrders', 'totalCustomers', 'totalProducts','totalSale','totalUserAdmin'));
    }
}
