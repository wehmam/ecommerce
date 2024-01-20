<?php

namespace App\Repository;

use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductRepository {
    public static function saveProduct($data) {
        try {
            DB::beginTransaction();

                $product                = new Product();
                $product->category_id   = $data["category_id"];
                $product->title         = $data["title"];
                $product->qty           = $data["qty"];
                $product->description   = $data["description"];
                $product->price         = $data["price"];
                $product->is_active     = $data["is_active"];
                $product->save();

                foreach($data["upload_image"] as $image) {
                    $pathFile = Storage::putFile("public/images/products", $image);
                    $productPhotos              = new ProductPhoto();
                    $productPhotos->product_id  = $product['id'];
                    $productPhotos->image       = $pathFile;
                    $productPhotos->save();
                }

            DB::commit();

            return responseCustom("Success Save Product", status: true, code:  200);
        } catch (\Exception $e) {
            DB::rollBack();
            return responseCustom($e->getMessage());
        }
    }

    public function updateProduct($data, $id) {
        try {
            DB::beginTransaction();

            $product                = Product::with(['productPhotos'])->find($id);
            if(!$product) {
                return responseCustom("Product Not Found", [], false, 404);
            }

            $product->category_id   = $data["category_id"];
            $product->title         = $data["title"];
            $product->qty           = $data["qty"];
            $product->description   = $data["description"];
            $product->price         = $data["price"];
            $product->is_active     = $data["is_active"];
            $product->save();

            if(isset($data["upload_image"])) {
                $bodyPhoto = collect([]);
                foreach($data["upload_image"] as $key => $image) {
                    $pathFile                      = Storage::putFile("public/images/products", $image);
                    $bodyPhoto->push([
                        'product_id'    => $product['id'],
                        'image' => $pathFile
                    ]);
                }

                if($bodyPhoto->isNotEmpty()) {
                    $product->productPhotos()->createMany($bodyPhoto->toArray());
                }
            }

            DB::commit();

            return responseCustom("Success Update Product", status: true, code: 200);
        } catch (\Exception $e) {
            DB::rollback();
            return responseCustom($e->getMessage());
        }
    }
}
