<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminCustomerController extends Controller
{
    public function index(Request $request)
    {   $customers =Customer::orderBy('id', 'desc'); 
        if($request->keyword){
            $keyword = $request->keyword;
            $customers = $customers->where('email', 'like', "%$keyword%");
        }
        $customers = $customers->paginate(25);
        return view('admin.customer.index', ['customers' => $customers]);
    }
    public function create()
    {
        return view('admin.customer.create');
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:users,name|min:4|max: 255',
            'email' => 'required|email|unique:customers',
            'address' => 'required',
            'password' => 'required|min:4|max:255',
            'passwordConfirmation' => 'required|same:password|min:4|max:255',
            'phone' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
            return response()->json([
                'status' => true,
                'mess' => 'Customer create successful!'
            ]);
        }
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', ['customer' => $customer]);
    }
    public function update(Customer $customer, Request $request)
    {
        $rules = [
            'name' => 'required|min:4|max: 255|unique:users,name,' . $customer->id,
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'address' => 'required',
            'phone' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
            if ($request->password != "" && $request->passwordConfirmation != "") {
                $validatePass = Validator::make($request->all(), [
                    'password' => 'required|min:4|max:255',
                    'passwordConfirmation' => 'required|same:password|min:4|max:255',
                ]);
                if ($validatePass->passes()) {
                    $customer->update([
                        'password' => Hash::make($request->password),
                    ]);
                    return response()->json([
                        'status' => true,
                        'mess' => 'Customer update successful!'
                    ]);
                }
                return response()->json([
                    'status' => false,
                    'errors' => $validatePass->errors()
                ]);
            }
            return response()->json([
                'status' => true,
                'mess' => 'Customer update successful!'
            ]);
        }
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }

    public function delete(Customer $customer)
    {
        if (!empty($customer)) {
            $customer->delete();
            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    }
}
