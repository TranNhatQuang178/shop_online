<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'fullname', 'email', 'country_id', 'address', 'apart_ment', 'city', 'state', 'zip', 'mobile', 'notes', 'coupon', 'discount', 'total', 'status', 'order_code', 'grand_total'];

    // public function country(){
    //     return $this->belongsTo(Country::class, 'country_id', 'id');
    // }
}
