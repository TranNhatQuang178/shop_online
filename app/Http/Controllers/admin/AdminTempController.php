<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ImageTemp;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
class AdminTempController extends Controller
{
    function create(Request $request){
        $image = $request->image;
        if(!empty($image)){
            $nameImg = $image->getClientOriginalName();
            $pathImg = public_path().'/temp/'. $nameImg;
            Image::make($image)->resize(300, 300)->save($pathImg);
            $imageTemp = ImageTemp::create([
                'image' => $nameImg,
            ]);
        }
        return response()->json([
            'status' => 200,
            'image_id'=> $imageTemp->id,
            'pathImg' => asset('/temp/'. $nameImg)
        ]);
    }

    function delete(ProductImage $image){
        $image->delete();
        return response()->json([
            'status' => 200,
            'id' => $image->id
        ]);
    }

    function deleteTemp(Request $request){
        if($request->id && $request->srcImage){
            ImageTemp::where('id', $request->id)->delete();
            $imageName  = basename($request->srcImage);
            $path = public_path('/temp/'.$imageName);
            File::delete($path);
            return response()->json([
                'status' => 200,
                'id' => $request->id,
                'srcImage'=> $request->srcImage,
            ]);
        }
    }
}
