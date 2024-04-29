<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','track_qty', 'sku', 'brand_id', 'cat_id','price','description', 'status', 'is_featured', 'barcode', 'compare_price', 'subcat_id', 'short_description', 'shipping_returns', 'related_products'];

    function productImage(){
        return $this->hasMany(ProductImage::class);
    }

    function category(){
        return $this->belongsTo(Category::class, 'cat_id');
    }

    // function cartProduct(){
    //     return $this->belongsTo(Category::class, 'cat_id');
    // }
}
