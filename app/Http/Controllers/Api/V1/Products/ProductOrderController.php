<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Api\V1\ApiController as Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductOrderController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Product::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return $this->showAll($product->orders, 200);
    }
}
