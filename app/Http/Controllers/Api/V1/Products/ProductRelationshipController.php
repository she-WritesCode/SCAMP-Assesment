<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Categories\CategoryResource;
use App\Http\Resources\Users\UserResource;
use App\Product;
use Illuminate\Http\Request;

class ProductRelationshipController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function user(Product $product)
    {
        return new UserResource($product->author);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function category(Product $product)
    {
        return new CategoryResource($product->comments);
    }
}
