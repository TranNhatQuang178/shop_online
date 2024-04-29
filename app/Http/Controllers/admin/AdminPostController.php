<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use App\Models\ImageTemp;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class AdminPostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::orderBy('created_at', 'DESC');
        $categories = CategoryPost::orderBy('created_at', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $posts = $posts->where('title', 'like', "%$keyword%");
        }

        $posts = $posts->paginate(25);
        $categories = $categories->paginate(25);
        return view('admin.post.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = CategoryPost::all();
        return view('admin.post.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|unique:posts,title',
                'slug' => 'required|unique:posts,slug',
                'short_description' => 'required',
                'detail_description' => 'required',
                'status' => 'required',
                'image' => 'required',
                'category' => 'required'
            ]
        );
        if ($request->image != null) {
            $temp = ImageTemp::find($request->image);
            $imageName = $temp->image;
            $pathTemp = public_path('/temp/' . $imageName);
            $dPath = public_path('/images/post/' . $imageName);
            Image::make($pathTemp)->save($dPath);
        }
        Post::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'slug' => $request->slug,
            'short_description' => $request->short_description,
            'detail_description' => $request->detail_description,
            'status' => $request->status,
            'image' => $imageName,
            'cat_id' => $request->category
        ]);
        Alert::success('Notification', 'Create Post successful!');
        return redirect()->route('post.index');
    }
    public function edit(Post $post)
    {
        $categories = CategoryPost::where('status',1)->get();
        return view('admin.post.edit', compact('post', 'categories'));
    }
    public function update(Post $post, Request $request)
    {
        $request->validate(
            [
                'title' => 'required|unique:posts,title,' . $post->id,
                'slug' => 'required|unique:posts,slug,' . $post->id,
                'short_description' => 'required',
                'detail_description' => 'required',
                'status' => 'required',
                'category' => 'required'
            ]
        );
        $imageName = $post->image;
        if ($request->image != null) {
            $temp = ImageTemp::find($request->image);
            $imageName = $temp->image;
            $pathTemp = public_path('/temp/' . $imageName);
            $dPath = public_path('/images/post/' . $imageName);
            Image::make($pathTemp)->save($dPath);
        }
        $post->update([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'slug' => $request->slug,
            'short_description' => $request->short_description,
            'detail_description' => $request->detail_description,
            'status' => $request->status,
            'image' => $imageName,
            'cat_id' => $request->category
        ]);
        Alert::success('Notification', 'Update post successful!');
        return redirect()->route('post.index');
    }

    public function postCategoryCreate()
    {
        return view('admin.post.category.create');
    }
    public function postCategoryStore(Request $request)
    {
        $rules = [
            'title' => 'required|unique:category_posts,name',
            'slug' => 'required|unique:category_posts,slug',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            CategoryPost::create([
                'name' => $request->title,
                'slug' => $request->slug,
                'status' => $request->status,
            ]);
            return response()->json([
                'status' => true,
                'mess' => 'Create a successful article portfolio!'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function postCategoryEdit(CategoryPost $postCategory, Request $request)
    {
        return view('admin.post.category.edit', compact('postCategory'));
    }
    public function postCategoryUpdate(CategoryPost $postCategory, Request $request)
    {
        $rules = [
            'title' => 'required|unique:category_posts,name,'. $postCategory->id,
            'slug' => 'required|unique:category_posts,slug,'. $postCategory->id,
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $postCategory->update([
                'name' => $request->title,
                'slug' => $request->slug,
                'status' => $request->status,
            ]);
            return response()->json([
                'status' => true,
                'mess' => 'Update a successful article portfolio!'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function searchCategoryPost(Request $request){

        if($request->keyword){
            $keyword = $request->keyword;
            $result = CategoryPost::where('name', 'like', "%$keyword%")->get();
            return response()->json([
                'status' => true,
                'result' => $result
            ]);
        }
    }
}
