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
        Route::apiResource('products', 'ProductController', ['only' => ['index', 'show']]);
        Route::apiResource('products.users', 'ProductUserController', ['only' => ['index']]);
        Route::apiResource('products.orders', 'ProductOrderController', ['only' => ['index']]);
        Route::apiResource('products.categories', 'ProductCategoryController', ['only' => ['index']]);
    });

    Route::group(['namespace' => 'Users'], function () {
        Route::apiResource('users', 'UserController');
        Route::apiResource('users.products', 'UserProductController', ['except' => ['show']]);
        Route::apiResource('users.orders', 'UserOrderController', ['except' => ['show']]);
        Route::apiResource('users.roles', 'UserRoleController', ['only' => ['index']]);
        Route::apiResource('users.permissions', 'UserPermissionController', ['only' => ['index']]);
    });

    Route::namespace('Orders')->group(function () {
        Route::apiResource('orders', 'OrderController');
        Route::apiResource('orders.products', 'OrderProductController', ['only' => ['index']]);
        Route::apiResource('orders.users', 'OrderUserController', ['only' => ['index']]);
    });

    Route::namespace('Categories')->group(function () {
        Route::apiResource('categories', 'CategoryController');
        Route::apiResource('categories.products', 'CategoryProductController', ['only' => ['index']]);
    });

    Route::namespace('Permissions')->group(function () {
        Route::apiResource('permissions', 'PermissionController');
        Route::apiResource('permissions.users', 'PermissionUserController', ['except' => ['show', 'store']]);
        Route::apiResource('permissions.roles', 'PermissionRoleController', ['except' => ['show', 'store']]);
    });

    Route::namespace('Roles')->group(function () {
        Route::apiResource('roles', 'RoleController');
        Route::apiResource('roles.user', 'RoleUserController', ['except' => ['show', 'store']]);
        Route::apiResource('roles.permissions', 'RolePermissionsController', ['except' => ['show', 'store']]);
    });
});
