<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'status', 'min_amount', 'description', 'max_uses', 'max_uses_user', 'type', 'starts_at', 'expires_at', 'discount_amount'];

    protected $table  = 'discount_codes';
}
