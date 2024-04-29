<?php

namespace App\Http\Controllers\client;

use App\Component\Customers;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    function index(){
        $categoriesShow = Category::where('featured_category', 1)->where('status', 1)->get();
        $latestProducts = Product::orderBy('id', 'desc')->take(8)->get();
        $featuredProducts = Product::where('is_featured', 1)->take(8)->get();
        $sliders = Slider::where('status', 1)->orderBy('id', 'DESC')->take(5)->get();
        return view('client.index', compact('categoriesShow', 'latestProducts', 'featuredProducts', 'sliders'));
    }

    function page($pageSlug){
        if(!$pageSlug){
            return abort(404);
        }else{
            $page = Page::where('slug', $pageSlug)->first();
            if(!empty($page)){
                return view('client.detail_page', compact('page'));
            }else{
                return abort(404);
            }
        }
    }
}
