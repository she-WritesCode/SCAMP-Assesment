<?php

use App\Http\Controllers\Api\V1\Orders\OrderController;
use App\Http\Controllers\Api\V1\Products\ProductRelationshipController;
use App\Http\Controllers\Api\V1\Products\ProductUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'Api\V1'], function () {

    Route::group(['namespace' => 'Products'], function () {

        Route::apiResource('products', 'ProductController');
    });

    Route::group(['namespace' => 'Users'], function () {

        Route::apiResource('users', 'UserController');
    });

    Route::namespace('Orders')->group(function () {

        Route::apiResource('orders', 'OrderController');
    });
});
