<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\Products\ProductCollection;
use App\Http\Resources\Products\ProductResource;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    /**
     * Display a listing of products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => Product::all()], 200);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'string|required',
            'quantity' => 'required|int',
            'price' => 'required|decimal',
            'description' => 'required|string',
            'category_id' => 'required|int',
        ];

        $request->validate($rules);

        $user = User::find(auth()->user()->id);
        $user->products()->save(new Product($request->all()));
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response($product, 200);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
