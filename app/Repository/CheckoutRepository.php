<?php

namespace App\Repository;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CheckoutRepository {
    public static function checkout($request) {
        try {
            $params    = $request->all();
            $validator = \Validator::make($params, [
                "province"  => "required",
                "city"      => "required",
                "district"  => "required",
                "address"   => "required",
                "post_code" => "required",
                "phone"     => "required"
            ]);

            if($validator->fails()) return responseCustom(
                collect($validator->messages()->all())->implode(" - ")
            );

            DB::beginTransaction();

                $carts = Cart::with(['user', 'product', 'product.productPhotos'])
                    ->where("user_id", Auth::user()->id)
                    ->get();


                if(!$carts) return responseCustom(
                    "carts data not found!"
                );


                $order = new Order();
                $order->user_id = Auth::user()->id;
                $order->invoice_no = self::generateInvoiceNumber();
                $order->province = $params["province"];
                $order->city = $params["city"];
                $order->district = $params["district"];
                $order->post_code = $params["post_code"];
                $order->address = $params["address"];
                $order->total_amount = $carts->sum('total_price');
                $order->save();



            foreach($carts as $cart) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $cart->product_id;
                $orderDetail->qty = $cart->quantity;
                $orderDetail->price_per_product = $cart->product->price;
                $orderDetail->total_price = $cart->total_price;
                $orderDetail->save();

                $cart->delete();
            }

            DB::commit();

            return responseCustom("success to checkout!", ["invoice_no" => $order->invoice_no], true, 200);
        } catch (\Exception $e) {
            DB::rollback();
            return responseCustom($e->getMessage());
        }
    }

    private static function generateInvoiceNumber()
    {
        $prefix = 'INV';
        $dateComponent = now()->format('Ymd');
        $uniqueIdentifier = strtoupper(Str::random(5));

        return $prefix . $dateComponent . $uniqueIdentifier;
    }
}
