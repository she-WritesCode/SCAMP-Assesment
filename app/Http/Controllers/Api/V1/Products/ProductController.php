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
        return $this->showAll(Product::all(), 200);
    }
}
