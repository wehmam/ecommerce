<?php

namespace App\Repository;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartRepository {

    public static function listCarts() {
        return Cart::with(['user', 'product', 'product.productPhotos'])
            ->get();
    }

    public static function totalCarts() {
        return Cart::where("user_id", Auth::user()->id)
            ->count();
    }

    public static function addToCarts($data) {
        try {
            if(!Auth::check()) {
                return responseCustom("Please Login before add to cart products!", code: 401);
            }

            $product = Product::find($data["productId"]);
            if(!$product) {
                return responseCustom("Products not found!", code: 404);
            }

            if($product->qty < $data["quantity"]) {
                return responseCustom("Quantity not enough!");
            }

            $cart = Cart::where("product_id", $product->id)
                ->first();

            if(!$cart) {
                $cart               = new Cart();
                $cart->quantity     = $data["quantity"];
            } else {
                $cart->quantity     = $data["quantity"] + $cart->quantity;
            }

            $cart->user_id      = Auth::user()->id;
            $cart->product_id   = $product->id;
            $cart->save();

            return responseCustom("Success Add Product!", status: true, code: 200);
        } catch (\Exception $e) {
            return responseCustom($e->getMessage());
        }
    }


}
