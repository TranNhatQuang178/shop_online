<?php

namespace App\Http\Controllers\admin;

use App\Component\CategoryRecursive;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ImageTemp;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AdminCategoryController extends Controller
{
    private $categoryRecursive;
    function __construct(CategoryRecursive $categoryRecursive)
    {
        $this->categoryRecursive = $categoryRecursive;
    }
    function index()
    {
        $categories = Category::paginate(25);
        return view('admin.category.index', compact('categories'));
    }

    function create()
    {
        $htmlOption =  $this->categoryRecursive->categoryRecursive('');
        return view('admin.category.create', compact('htmlOption'));
    }

    function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:4|max:255|unique:categories,name,',
                'slug' => 'required',
            ]
        );

        if ($validator->passes()) {
            $thumbnail = null;
            if ($request->input('image_id')) {
                $imageId = $request->image_id;
                $temp = ImageTemp::find($imageId);
                $tempName = $temp->image;
                $pathTemp = public_path('/temp/' . $tempName);
                $desPath = public_path('/images/thumbnail_category/' . $tempName);
                Image::make($pathTemp)->save($desPath);
                $thumbnail = $tempName;
            }
            Category::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->category,
                'status' => $request->status,
                'featured_category' => $request->featured,
                'thumbnail' => $thumbnail
            ]);
            return response()->json([
                'status' => 200
            ]);
        } else {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 500,
            ]);
        }
    }
    function delete(Category $category)
    {
        if ($category) {
            $category->delete();
            return response()->json([
                'status' => 200
            ]);
        } else {
            return response()->json([
                'status' => 500
            ]);
        }
    }

    function edit(Category $category)
    {
        $htmlOption =  $this->categoryRecursive->categoryRecursive($category->parent_id);
        return view('admin.category.edit', compact('category', 'htmlOption'));
    }

    function update(Category $category, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:4|max:255|unique:categories,name,' . $category->id,
                'slug' => 'required',
            ]
        );

        if ($validator->passes()) {
            if ($request->category != 0) {
                $parentCategory = Category::find($request->category);
                if ($parentCategory->parent_id == $category->id || $request->category  == $category->id) {
                    return response()->json([
                        'mess' => "Cannot update parent category to be its own child or update it to be a child of itself",
                        'status' => 422,
                    ]);
                }
            }
            $thumbnail = $category->thumbnail ? $category->thumbnail : null;
            if ($request->input('image_id')) {
                $imageId = $request->image_id;
                $temp = ImageTemp::find($imageId);
                $tempName = $temp->image;
                $pathTemp = public_path('/temp/' . $tempName);
                $desPath = public_path('/images/thumbnail_category/' . $tempName);
                Image::make($pathTemp)->save($desPath);
                $thumbnail = $tempName;
            }
            $category->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->category,
                'status' => $request->status,
                'featured_category' => $request->featured,
                'thumbnail' => $thumbnail,
            ]);


                return response()->json([
                    'status' => 200
                ]);
            } else {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 500
            ]);
        }
    }

    public function action(Request $request)
    {
        $idArray =  $request->idArray;
        if (!empty($idArray) && $idArray[0] !== "") {
            Category::whereIn('id', $idArray)->delete();
            return response()->json([
                'status' => 200,
                'mess' => 'Deletion Successful',
                'ids' => $idArray
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'mess' => 'Category Remove Fail. Please select element !'
            ]);
        }
    }

    public function deleteImage(Request $request, Category $category)
    { 
            if (!empty($category) && $request->srcImage) {
                $category->update([
                    'thumbnail' => null
                ]);
                $pathName = basename($request->srcImage);
                $pathDelete = public_path('/images/thumbnail_category/' . $pathName);
                File::delete($pathDelete);
                return response()->json([
                    'status' => 200,
                    'mess' => 'Category remove image successful !',
                    'id' => $category->id,
                ]);
        }
    }
}
