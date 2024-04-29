<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'order_id', 'product_id', 'name', 'price', 'total_item', 'qty', 'total'];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
