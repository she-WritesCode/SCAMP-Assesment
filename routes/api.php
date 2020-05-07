<?php

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

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->middleware('auth:api');

Route::group(['namespace' => 'Api\V1', 'middleware' => 'auth:api'], function () {

    Route::group(['namespace' => 'Products'], function () {
        Route::apiResource('products', 'ProductController', ['only' => ['index', 'show']]);

        Route::apiResource('products.users', 'ProductUserController', ['only' => ['index']]);
        // Route::get('products/{product}/relationships/user', 'ProductUserController@index')->name('products.relationships.users');

        Route::apiResource('products.orders', 'ProductOrderController', ['only' => ['index']]);
        // Route::apiResource('products.categories', 'ProductCategoryController', ['only' => ['index', 'update']]);
    });

    Route::group(['namespace' => 'Users'], function () {
        Route::apiResource('users', 'UserController');

        Route::apiResource('users.products', 'UserProductController', ['except' => ['show']]);
        // Route::get('users/{user}/relationships/products', 'UserProductController@index')->name('users.relationships.products');

        Route::apiResource('users.orders', 'UserOrderController', ['except' => ['show']]);
        // Route::get('users/{user}/relationships/orders', 'UserOrderController@index')->name('users.relationships.orders');

        Route::apiResource('users.roles', 'UserRoleController', ['only' => ['index']]);
        // Route::get('users/{user}/relationships/roles', 'UserRoleController@index')->name('users.relationships.roles');

        Route::apiResource('users.permissions', 'UserPermissionController', ['only' => ['index']]);
        // Route::get('users/{user}/relationships/permissions', 'UserPersmissionController@index')->name('users.relationships.permissions');
    });

    Route::namespace('Orders')->group(function () {
        Route::apiResource('orders', 'OrderController', ['only'=>['index', 'show']]);
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
        Route::apiResource('permissions.roles', 'PermissionRoleController', ['except' => ['show']]);
    });

    Route::namespace('Roles')->group(function () {
        Route::apiResource('roles', 'RoleController');
        Route::apiResource('roles.users', 'RoleUserController', ['except' => ['show', 'store']]);
        Route::apiResource('roles.permissions', 'RolePermissionController', ['except' => ['show', 'store']]);
    });
});
