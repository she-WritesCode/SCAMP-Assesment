<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Api\V1\ApiController as Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return $this->showOne($product->category, 200);
    }
}
