<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'password', 'email_verified_at', 'phone', 'address', 'remember_token', 'active'];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function cart(){
       return $this->hasMany(CartCustomer::class);
    }

    public static function getCustomerByEmail($email){
        return self::where('email',$email)->first();
    }
}
