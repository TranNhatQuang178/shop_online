<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index($categoryPostSlug = null){
        $posts = Post::orderBy("created_at","desc");
        if($categoryPostSlug != null){
            $category = CategoryPost::where('slug', $categoryPostSlug)->first();
            $posts = $posts->where("cat_id", $category->id);
        }
        $posts = $posts->where('status', 1)->paginate(25);
        $categoriesPost = CategoryPost::where('status', 1)->orderBy('created_at', 'desc')->get(); 
        return view('client.post.index', compact('categoriesPost','posts'));
    }
    public function detail($categoryPostSlug, $postSlug){
        if(!empty($categoryPostSlug) && !empty($postSlug)){
            $category = CategoryPost::where('slug', $categoryPostSlug)->first();
            if(empty($category)){
                return abort(404);
            }
            $post = Post::where([['cat_id', $category->id], ['slug', $postSlug]])->first();
            return view('client.post.detail', compact('post'));
        }else{
            return abort(404);
        }
    } 
}
