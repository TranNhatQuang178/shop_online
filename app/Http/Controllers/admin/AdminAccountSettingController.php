<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class AdminAccountSettingController extends Controller
{
    public function index(){
        return view('admin.account.setting');
    }

    public function updateAccount(User $user, Request $request){
        $rules = [
            'name' => 'required|min:4|max: 255|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'required',
            'phone' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->passes()){
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
            return response()->json([
                'status' => true,
            ]);
        }
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }

    public function changePassword(User $user){
        return view('admin.account.change_password', ['user' => $user]);
    }

    public function updatePassword(User $user, Request $request){
        
        $validator = Validator::make($request->all(),
        [
            'current_password' => 'required',
            'new_password'=> 'required',
            'confirm_password'=> 'required|same:new_password'
        ]);

        if($validator->passes()){
            $now = Carbon::now()->toDateTimeString();
            if(Hash::check($request->current_password, $user->password)){
                $user->update([
                    'password' => Hash::make($request->new_password),
                    'updated_at' => $now,
                ]);
                return response()->json([
                    'status' => true,
                    'mess' => 'Change password successful!'
                ]);
            }
            return response()->json([
                'status' => false,
                'errors' => ['current_password' => 'Invalid current password. Please try again.'],
            ]);
        }
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }
}
