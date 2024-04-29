<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'fullname', 'country_id', 'address', 'state', 'zip','city','notes', 'apartment', 'order_id'];

    protected $table = 'customers_address';
}
