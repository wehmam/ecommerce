<?php

use App\Services\MidtransService;
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
    return (new MidtransService())->getSnapToken('INV-123456789', 100000);
});
