<?php

use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\IndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('')->group(function() {
    Route::get('login', [AuthController::class, 'index']);
    Route::post('login', [AuthController::class, 'login']);

    Route::get('/', [IndexController::class, 'index']);
    Route::get('/products', [IndexController::class, 'listProducts']);
    Route::get('/products/{slug}', [IndexController::class, 'listProductSlug']);
    Route::get('/product/detail/{id?}', [IndexController::class, 'detailProduct']);

    // Route::middleware(['auth'])->group(function () {
        Route::prefix("cart")->group(function () {
            Route::get('/', [IndexController::class, 'listCarts']);
            Route::post('/order', [IndexController::class, 'addToCarts']);
        });
        Route::get('/checkout', [IndexController::class, 'checkout']);
        Route::post('/checkout', [IndexController::class, 'checkoutPost']);
        Route::post('logout', [AuthController::class, 'logout']);
    // });
});
