<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'parent_id', 'status', 'featured_category', 'thumbnail'];

    function children(){
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    function products(){
        return $this->hasMany(Product::class, 'cat_id');
    }
}
