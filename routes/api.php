<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Faker\Factory as Faker;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', function() {
    // $faker = Faker::create();

    // $products = [
    //     [
    //         "category_id" => 1,
    //         "title" => "Iphone 15 Pro",
    //         "qty"   => 10,
    //         "description" => $faker->paragraph,
    //         "price" => 19999000
    //     ]
    // ];

    // dd($products);

});
