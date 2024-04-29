<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartCustomer extends Model
{
    use HasFactory;
    protected $fillable =['customer_id', 'product_id', 'coupon','sub_total', 'total', 'item_total' ,'qty'];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public static function getTotalPriceByCustomerId($customerId)
    {
        return self::where('customer_id', $customerId)->sum('sub_total');
    }
}
