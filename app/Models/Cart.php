<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public static function addNew($product, $amount)
    {
        $cart = new Cart();
        $cart->product = $product;
        $cart->amount = $amount;
        return $cart;
    }
}
