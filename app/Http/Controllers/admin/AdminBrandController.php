<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;

class AdminBrandController extends Controller
{
    public function index(Request $request){
        if(!empty($request->get('keyword'))){
            $keyword = $request->keyword;
            $brands = Brand::where('name', 'like', "%{$keyword}%")->paginate(25);
        }else{
            $brands = Brand::paginate(25);
        }
        return view('admin.brand.index', compact('brands'));
    }

    public function create(){
        return view('admin.brand.create');
    }

    public function store(Request $request){
        $rules = [
            'title' => 'required|min:4|max:255|unique:brands,name',
            'slug' => 'required|min:4|max:255|unique:brands,slug'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->passes()){
            Brand::create([
                'name' => $request->title,
                'slug' => $request->slug,
                'status' => $request->status
            ]);
            return response()->json([
                'status'=> 200,
                'mess' => 'Brand Created Successfully !'
            ]);
        }else{
            return response()->json([
                'status'=> 500,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit(Brand $brand){
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand){
        $rules = [
            'title' => 'required|min:4|max:255|unique:brands,name,'.$brand->id,
            'slug' => 'required|min:4|max:255|unique:brands,slug,'.$brand->id
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->passes()){
           $brand->update([
                'name' => $request->title,
                'slug' => $request->slug,
                'status' => $request->status
            ]);
            return response()->json([
                'status'=> 200,
                'mess' => 'Brand Edit Successfully !'
            ]);
        }else{
            return response()->json([
                'status'=> 500,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function destroy(Brand $brand){
        if($brand){
            $brand->delete();
            return response()->json([
                'status'=> 200,
            ]);
        }else{
            return response()->json([
                'status'=> 302,
                'mess' => 'Brand not found !'
            ]);
        }
    }
}
