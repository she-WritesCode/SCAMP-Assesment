<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Category;
use App\Http\Controllers\Api\V1\ApiController as Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return $this->showOne($product->category, 200);
    }

    public function update(Request $request, Product $product, Category $category)
    {
        $product->category_id = (int) $category->id;
        $product->save();

        return $this->showOne($product->category, 200);
    }
}
