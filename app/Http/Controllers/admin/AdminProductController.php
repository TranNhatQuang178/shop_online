<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ImageTemp;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class AdminProductController extends Controller
{
    function index(Request $request)
    {
        if (isset($_GET['keyword'])) {
            $products = Product::where('name', 'like', "%{$_GET['keyword']}%")->orderBy('id', 'ASC')->paginate(25);
        } else {
            $products = Product::orderBy('id', 'ASC')->paginate(25);
        }
        return view('admin.product.index', compact('products'));
    }

    function create()
    {
        $categories = Category::where('status', 1)->where('parent_id', 0)->get();
        $brands = Brand::all();
        return view('admin.product.create', compact('categories', 'brands'));
    }

    function getSubCategory(Request $request)
    {
        if ($request->category_id) {
            $category_id = $request->category_id;
            $category = Category::find($category_id);
            return response()->json([
                'status' => 200,
                'subCategory' => $category->children,
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'null' => null
            ]);
        }
    }

    function store(Request $request)
    {
        $rules = [
            'title' => 'required|unique:products,name',
            'slug' => 'required|unique:products,slug',
            'description' => 'required',
            'price' => 'required|integer',
            'qty' => 'required|integer',
            'sku' => 'required',
            'status' => 'required|in:0,1',
            'category' => 'required',
            'sub_category' => 'required',
            'brand' => 'required',
        ];
        $request->validate($rules);
        try {
            $product = Product::create([
                'name' => $request->title,
                'slug' => $request->slug,
                'description' => $request->description,
                'price' => $request->price,
                'track_qty' => $request->qty,
                'cat_id' => $request->category,
                'is_featured' => $request->featured,
                'brand_id' => $request->brand,
                'status' => $request->status,
                'sku' => $request->sku,
                'compare_price' => $request->compare_price,
                'barcode' => $request->barcode,
                'subcat_id' => $request->sub_category,
                'short_description' => $request->short_description,
                'shipping_returns' => $request->shipping_returns,
                'related_products' => (!empty($request->related_products)) ? implode(',', $request->related_products) : null,
            ]);
            if (!empty($request->image_array)) {
                foreach ($request->image_array as $image_id) {
                    $productImage = ImageTemp::find($image_id);
                    $imageName = $productImage->image;
                    $sourcePath = public_path() . '/temp/' . $imageName;
                    $desPath = public_path() . '/images/thumbnail/' . $imageName;
                    $image =  Image::make($sourcePath);
                    $image->save($desPath);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $productImage->image,
                    ]);
                }
            }
            Alert::success('Notification', 'Product Created Successfully !', 5000);
            return redirect()->route('product.index');
        } catch (\Throwable $th) {
            Alert::error('Notification', 'Failed to create product. Please try again later');
            return redirect()->route('product.create');
        }
    }

    function destroy(Product $product)
    {
        if (!empty($product)) {
            $product->delete();
            return response()->json([
                'status' => 200
            ]);
        } else {
            return response()->json([
                'status' => 302,
                'mess' => 'Product not found',
            ]);
        }
    }
    function action(Request $request)
    {
        if (!empty($request->idsArray)) {
            $idsArray = $request->idsArray;
            Product::whereIn('id', $idsArray)->delete();
            return response()->json([
                'status' => 200,
                'mess' => 'Product Remove Successfully !',
                'ids' => $idsArray
            ]);
        } else {
            return response()->json([
                'status' => 302,
                'mess' => 'Product Remove Fail. Please select element !'
            ]);
        }
    }
    function edit(Product $product)
    {
        $categories = Category::where('status', 1)->where('parent_id', 0)->get();
        $brands = Brand::all();
        $relatedArray = [];
        // if ($product->related_products != '') {
            
        // }
        $relatedArray = explode(',', $product->related_products);
            $relatedProducts = Product::whereIn('id', $relatedArray)->get();
        return view('admin.product.edit', compact('categories', 'brands', 'product', 'relatedProducts'));
    }
    function update(Request $request, Product $product)
    {
        $rules = [
            'title' => 'required|unique:products,name,' . $product->id,
            'slug' => 'required|unique:products,slug,' . $product->id,
            'description' => 'required',
            'price' => 'required|integer',
            'qty' => 'required|integer',
            'sku' => 'required',
            'status' => 'required|in:0,1',
            'category' => 'required',
            'sub_category' => 'required',
            'brand' => 'required',
        ];
        $request->validate($rules);
        try {
            $product->update([
                'name' => $request->title,
                'slug' => $request->slug,
                'description' => $request->description,
                'price' => $request->price,
                'track_qty' => $request->qty,
                'cat_id' => $request->category,
                'is_featured' => $request->featured,
                'brand_id' => $request->brand,
                'status' => $request->status,
                'sku' => $request->sku,
                'compare_price' => $request->compare_price,
                'barcode' => $request->barcode,
                'subcat_id' => $request->sub_category,
                'short_description' => $request->short_description,
                'shipping_returns' => $request->shipping_returns,
                'related_products' => (!empty($request->related_products)) ? implode(',', $request->related_products) : null,
            ]);
            if (!empty($request->image_array)) {
                foreach ($request->image_array as $image_id) {
                    $productImage = ImageTemp::find($image_id);
                    $imageName = $productImage->image;
                    $sourcePath = public_path() . '/temp/' . $imageName;
                    $desPath = public_path() . '/images/thumbnail/' . $imageName;
                    $image =  Image::make($sourcePath);
                    $image->save($desPath);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $productImage->image
                    ]);
                }
            }
            Alert::success('Notification', 'Product Updated Successfully !', 5000);
            return redirect()->route('product.index');
        } catch (\Throwable $th) {
            // Alert::error('Notification', );
            // return redirect()->route('product.create');
            // return redirect()->route('product.edit', $product->id);
            // return redirect()->back();
        }
    }

    public function getProducts(Request $request)
    {
        $tempArray = [];
        if ($request->term != '') {
            $key = $request->term;
            $products = Product::where('name', 'like', "%{$key}%")->get();
            if ($products != null) {
                foreach ($products as $product) {
                    $tempArray[] = array('id' => $product->id, 'text' => $product->name);
                }
            }
        }

        return response()->json([
            'tags' => $tempArray,
            'status' => true,
        ]);
    }
}
