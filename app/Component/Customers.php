<?php

namespace App\Component;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class Customers
{
    function checkLogin($email, $password)
    {
        $customers = Customer::all();
        foreach ($customers as $customer) {
            if ($customer->email == $email && Hash::check($password, $customer->password)) {
                return true;
            }
        }
        return false;
    }

    function isLogin()
    {
        if (session()->has('is_login')) {
            return true;
        }
        return false;
    }

    function getEmail()
    {
        if (session()->has('email')) {
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
                        return $customer[$field];
                }
            }
        }
        return false;
    }
}
