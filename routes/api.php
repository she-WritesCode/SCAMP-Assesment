<?php

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

        Route::get(
            'products/{product}/relationships/user',
            [
                'uses' => 'ProductRelationshipController@user',
                'as' => 'products.relationships.user',
            ]
        );
        Route::get(
            'products/{product}/user',
            [
                'uses' => 'ProductRelationshipController@user',
                'as' => 'products.user',
            ]
        );
        Route::get(
            'products/{product}/relationships/category',
            [
                'uses' => 'ProductRelationshipController@category',
                'as' => 'products.relationships.category',
            ]
        );
        Route::get(
            'products/{product}/category',
            [
                'uses' => 'ProductRelationshipController@category',
                'as' => 'products.category',
            ]
        );
    });
    // Route::get(
    //     'articles/{article}/author',
    //     [
    //         'uses' => \App\Http\Controllers\ArticleRelationshipController::class . '@author',
    //         'as' => 'articles.author',
    //     ]
    // );
    // Route::get(
    //     'articles/{article}/relationships/comments',
    //     [
    //         'uses' => \App\Http\Controllers\ArticleRelationshipController::class . '@comments',
    //         'as' => 'articles.relationships.comments',
    //     ]
    // );
    // Route::get(
    //     'articles/{article}/comments',
    //     [
    //         'uses' => \App\Http\Controllers\ArticleRelationshipController::class . '@comments',
    //         'as' => 'articles.comments',
    //     ]
    // );
});
