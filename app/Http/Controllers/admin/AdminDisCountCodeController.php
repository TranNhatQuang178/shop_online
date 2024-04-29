<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminDisCountCodeController extends Controller
{
    public function index(Request $request)
    {
        $listDiscountCode = DiscountCode::orderBy('id', 'DESC');
        if(!empty($request->get('keyword'))){
            $keyword = $request->get('keyword');
            $listDiscountCode = $listDiscountCode->where('name', 'like', "%{$keyword}%")->orWhere('code', 'like', "%{$keyword}%");
        }
       $listDiscountCode =  $listDiscountCode->paginate(25);
        return view('admin.discount.index', compact('listDiscountCode'));
    }
    public function create()
    {
        return view('admin.discount.create');
    }
    public function store(Request $request)
    {
        $rules = [
            'code' => 'required|unique:discount_codes,code',
            'name' => 'required',
            'description' => 'required',
            'max_uses' => 'required|numeric',
            'max_uses_user' => 'required|numeric',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required',
            'start_at' => 'required',
            'expires_at' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->passes()) {
            if(!empty($request->start_at)){
                $now = Carbon::now();
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_at);
                if($startAt->lte($now) == true){
                    return response()->json([
                        'status' => false,
                        'errors' => ['start_at' => 'The start date can not be less than the current time']
                    ]);
                }
            }
            if(!empty($request->start_at) && !empty($request->expires_at)){
                $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_at);
                if($expiresAt->gt($startAt) == false){
                    return response()->json([
                        'status' => false,
                        'errors' => ['expires_at' => 'The expiry date must be greater than the start date']
                    ]);
                }
            }
            DiscountCode::create([
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'max_uses' => $request->max_uses,
                'max_uses_user' => $request->max_uses_user,
                'type' => $request->type,
                'discount_amount' => $request->discount_amount,
                'min_amount' => $request->min_amount,
                'starts_at'=> $request->start_at,
                'expires_at'=> $request->expires_at,
                'status' => $request->status,
                
            ]);
            return response()->json([
                'status' => true,
                'mess' => 'Discount Created Successfully !'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'mess' => 'Discount Created Error !',
                'errors'=> $validator->errors()
            ]);
        }
    }
    public function edit(DiscountCode $discountCode)
    {
        if($discountCode != null){
            return view('admin.discount.edit', compact('discountCode'));
        }
        return abort(404);
    }
    public function update(Request $request, DiscountCode $discountCode)
    {
        $rules = [
            'code' => 'required|unique:discount_codes,code,' . $discountCode->id,
            'name' => 'required',
            'description' => 'required',
            'max_uses' => 'required|numeric',
            'max_uses_user' => 'required|numeric',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required',
            'start_at' => 'required',
            'expires_at' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->passes()){
            if(!empty($request->start_at)){
                $now = Carbon::now();
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_at);
                if($startAt->lte($now) == true){
                    return response()->json([
                        'status' => false,
                        'errors' => ['start_at' => 'The start date can not be less than the current time']
                    ]);
                }
            }
            if(!empty($request->start_at) && !empty($request->expires_at)){
                $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_at);
                if($expiresAt->gt($startAt) == false){
                    return response()->json([
                        'status' => false,
                        'errors' => ['expires_at' => 'The expiry date must be greater than the start date']
                    ]);
                }
            }
            $discountCode->update([
                'name' => $request->name,
                'code' => $request->code,
                'max_uses' => $request->max_uses,
                'max_uses_user' => $request->max_uses_user,
                'type' => $request->type,
                'discount_amount' => $request->discount_amount,
                'min_amount' => $request->min_amount,
                'status' => $request->status,
                'starts_at' => $request->start_at,
                'expires_at' => $request->expires_at,
                'description' => $request->description,
            ]);
            return response()->json([
                'status' => true,
                'mess' => 'Discount Updated Successfully !'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function delete(DiscountCode $discountCode)
    {
        if($discountCode != null){
            $discountCode->delete();
            return response()->json([
                'status' => true,
            ]); 
        }else{
            return response()->json([
                'status' => false,
                'mess' => "Discount not found"
            ]);
        }
    }

    public function action(Request $request){
        if(!empty($request->idArray)){
            $idArray = $request->idArray;
            DiscountCode::whereIn('id', $idArray)->delete();
            return response()->json([
                'status' => true,
                'ids' => $idArray,
            ]); 
        }else{
            return response()->json([
                'status' => false,
            ]);
        }
    }
}
