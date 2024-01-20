<?php

use App\Http\Controllers\Backend\AuthBackendController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ProductController;
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
    Route::get('register', [AuthController::class, 'indexRegister']);
    Route::post('register', [AuthController::class, 'register']);

    Route::get('/', [IndexController::class, 'index']);
    Route::get('/products', [IndexController::class, 'listProducts']);
    Route::get('/products/{slug}', [IndexController::class, 'listProductSlug']);
    Route::get('/product/detail/{id?}', [IndexController::class, 'detailProduct']);

    Route::middleware(['auth'])->group(function () {
        Route::prefix("cart")->group(function () {
            Route::get('/', [IndexController::class, 'listCarts']);
            Route::post('/order', [IndexController::class, 'addToCarts']);
        });
        Route::get('/checkout', [IndexController::class, 'checkout']);
        Route::post('/checkout', [IndexController::class, 'checkoutPost']);
        Route::get('/payment/{invoice}', [IndexController::class, 'payment']);

        Route::post('logout', [AuthController::class, 'logout']);
    });
});


Route::prefix('backend')->group(function () {
    Route::get("/login", [AuthBackendController::class, 'index'])->middleware('guestAdmin');
    Route::post("/login", [AuthBackendController::class, 'loginPost']);
    Route::middleware(['authAdmin'])->group(function() {
        Route::get("/", [DashboardController::class, 'index']);
        Route::post("/logout", [AuthBackendController::class, 'logout']);
        Route::resource('product', ProductController::class);
        Route::delete('/product/delete-photo/{id}', [ProductController::class, 'deletePhotoById']);
        Route::resource('category', CategoryController::class);

        // Route::prefix("orders")->group(function () {
        //     Route::get("/", [OrdersController::class, 'index']);
        //     Route::get("/detail/{id?}", [OrdersController::class, "detail"]);
        // });


        // Route::get("activity-logs", [DashboardController::class, 'activityLogs']);
        // Route::prefix("export-csv")->group(function() {
        //     Route::get("/activity-logs", function() {
        //         return Excel::download(new LogsExport, 'logs-'. date("Y-m-d").'.csv');
        //     });
        // });
    });
});
