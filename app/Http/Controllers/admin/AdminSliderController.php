<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ImageTemp;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;

class AdminSliderController extends Controller
{
    public function index(Request $request)
    {
        $sliders = Slider::orderBy('id', 'DESC');
        if ($request->keyword != '') {
            $keyword = $request->keyword;
            $sliders = Slider::where('title', 'like', "%$keyword%");
        }
        $sliders = $sliders->paginate(25);
        return view('admin.slider.index', compact('sliders'));
    }
    public function create()
    {
        return view('admin.slider.create');
    }
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:6|max:255|unique:sliders,title',
            'link' => 'required',
            'desc' => 'required',
            'status' => 'required',
            'image_id' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            if (!empty($request->image_id)) {
                $temp = ImageTemp::find($request->image_id);
                $imageName = $temp->image;
                $path = public_path() . '/temp/' . $imageName;
                $maxPath = public_path() . '/images/sliders/max/' . $imageName;
                $minPath = public_path() . '/images/sliders/min/' . $imageName;
                $rand = rand(800, 1000);
                Image::make($path)
                    ->resize(779, null)
                    ->save($maxPath);
                Image::make($path)
                    ->resize($rand, null)
                    ->save($minPath);
            }
            Slider::create([
                'title' => $request->title,
                'link' => $request->link,
                'desc' => $request->desc,
                'status' => $request->status,
                'image' => $imageName,
            ]);
            return response()->json([
                'status' => true,
                'mess' => 'Create slider successful!'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit(Slider $slider)
    {

        return view('admin.slider.edit', compact('slider'));
    }
    public function update(Slider $slider, Request $request)
    {
        $rules = [
            'title' => 'required|min:6|max:255',
            Rule::unique('sliders')->ignore($slider->id),
            'link' => 'required',
            'desc' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $imageName = $slider->image;
            if (!empty($request->image_id)) {
                $temp = ImageTemp::find($request->image_id);
                $imageName = $temp->image;
                $path = public_path() . '/temp/' . $imageName;
                $maxPath = public_path() . '/images/sliders/max/' . $imageName;
                $minPath = public_path() . '/images/sliders/min/' . $imageName;
                $rand = rand(800, 1000);
                Image::make($path)
                    ->resize(779, null)
                    ->save($maxPath);
                Image::make($path)
                    ->resize($rand, null)
                    ->save($minPath);
                $oldImage = $slider->image;
                // File::delete(public_path().'/images/sliders/'.$oldImage);
            }
            $slider->update([
                'title' => $request->title,
                'link' => $request->link,
                'desc' => $request->desc,
                'status' => $request->status,
                'image' => $imageName,
            ]);
            return response()->json([
                'status' => true,
                'mess' => 'Edit slider successful!'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function delete(Slider $slider)
    {
        if (!empty($slider)) {
            $slider->delete();
            return response()->json([
                'status' => true,
                'mess' => 'Slider delete successful!'
            ]);
        }
        return response()->json([
            'status' => false,
            'mess' => 'Slider not found!'
        ]);
    }

    public function deletes(Request $request){
        if($request->idArray){
            $idArray = $request->idArray;
            Slider::whereIn('id', $idArray)->delete();
            return response()->json([
                'status' => true,
                'ids' => $idArray
            ]);
        }
    }
}
