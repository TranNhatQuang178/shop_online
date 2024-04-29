<?php

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Customer;

function getProductImage($productId)
{
    return ProductImage::where('product_id', $productId)->first();
}

function isLogin()
{
    if (session()->has('is_login')) {
        return true;
    }
    return false;
}

function infoUser($email, $field = 'id')
{
    $customers = Customer::all();
    if (session()->has('is_login')) {
        foreach ($customers as $customer) {
            if ($email == $customer->email) {
                if (!empty($customer[$field])) {
                    return $customer[$field];
                }
            }
        }
    }
    return false;
}
