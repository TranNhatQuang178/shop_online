<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null){
        $brandArray = [];
        $priceArray = [];
        $selectedCategory = ''; 
        $selectedSubCategory = ''; 
        $products = Product::where('status', 1);
        if(!empty($categorySlug)){
            $category = Category::where('slug', $categorySlug)->first();
            if($category == null){
                abort(404);
            }
            $products = Product::where('cat_id', $category->id);
            $selectedCategory = $category->id;
        }
        if(!empty($subCategorySlug)){ 
            $subCategory = Category::where('slug', $subCategorySlug)->first();
            if($subCategory == null){
                abort(404);
            }
            $products = Product::where('subcat_id', $subCategory->id);
            $selectedSubCategory = $subCategory->id;
        }
        if(!empty($request->get('brand'))){
            $brandArray = explode(',', $request->get('brand'));
            $products = Product::whereIn('brand_id', $brandArray);
        }
        if(!empty($request->get('sort'))){
            $sort = $request->get('sort');
            if(!empty($sort)){
                if($sort === 'latest'){
                    $products = $products->orderBy('id', 'DESC');
                }else if($sort === 'price_hight'){
                    $products = $products->orderBy('price', 'ASC');
                }else{
                    $products = $products->orderBy('price', 'DESC');
                }
            }
        }
        if(!empty($request->get('price'))){
            $priceArray = explode('-', $request->get('price'));
            if(count($priceArray) == 2){
                $products = $products->whereBetween('price', [intval($priceArray[0]), intval($priceArray[1])]);
            }else{
                $products = $products->where('price', '>=', $request->get('price') );
            }
        }


        if(!empty($request->get('search_product'))){
            $keyword = $request->get('search_product');
            $products = $products->where('name', 'like', "%{$keyword}%");
        }
        $products = $products->paginate(25);
        $categories = Category::where([['status', 1], ['parent_id', 0]])->get();
        $brands = Brand::where('status', 1)->orderBy('name','ASC')->get();
        $priceArray = $request->get('price');
        return view('client.shop.index', compact('categories', 'brands', 'products', 'brandArray', 'priceArray', 'selectedCategory', 'selectedSubCategory'));
    }

    public function productDetail($productSlug){
        $product = Product::where('slug', $productSlug)->first();
        $category = $product->category;
        $relateshipProducts = $category->products;
        return view('client.product_detail', compact('product', 'relateshipProducts'));
    }
}
