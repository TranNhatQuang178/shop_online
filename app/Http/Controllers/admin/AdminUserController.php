<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{

    function login()
    {
        return view('admin/account/login');
    }

    function loginProcess(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        } else {
            session(['error' => 'error']);
            return redirect()->route('admin.login')->with('session', session('error'));
        }
    }

    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    function index(Request $request)
    {
        if($request->keyword){
            $keyword = $request->keyword;
            $users = User::where('name', 'like', "%{$keyword}%")->orWhere('email', 'like', "%{$keyword}%")->paginate(25);
        }else{
            $users = User::paginate(25);
        }
        return view('admin/users/index', compact('users'));
    }

    function create()
    {
        return view('admin/users/create');
    }

    function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:users,name|min:4|max: 255',
                'email' => 'required|email|unique:users',
                'address' => 'required',
                'password' => 'required|min:4|max:255',
                'passwordConfirmation' => 'required|same:password|min:4|max:255',
                'phone' => 'required'
            ],
        );
        if ($validator->passes()) {
            User::create([
                'name' => $request->name,
                'email'=> $request->email,
                'password' => Hash::make($request->passwordConfirmation),
                'phone' => $request->phone,
                'address' => $request->address,
            ]);            
            return response()->json(
                [
                    'status' => 200,
                ]
            );
        } else {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 500
            ]);
        }
    }

    function delete(User $user){
        if($user){
            $user->delete();
            return response()->json([
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'status' => 500,
            ]);
        }
    }

    function edit(User $user){
        return view('admin.users.edit', compact('user'));
    }

    function update(User $user, Request $request){
        $validator = Validator::make($request->all(), 
        [
            'name' => 'required|min:4|max: 255|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'required',
            'phone' => 'required',
        ]);
        if($validator->passes()){
            if($user){
            $user->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address'=> $request->address,
                ]);
                return response()->json([
                    'status' => 200
                ]);
            }
        }else{
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 500,
            ]);
        }
    }
}
