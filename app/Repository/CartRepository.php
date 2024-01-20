<?php

namespace App\Repository;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartRepository {

    public static function listCarts() {
        // return Cart::with(['user', 'product', 'product.productPhotos'])
        return Cart::with([])
            ->where("user_id", 1)
            ->get();
    }

    public static function totalCarts() {
        return Cart::where("user_id", Auth::user()->id)
            ->count();
    }


}
