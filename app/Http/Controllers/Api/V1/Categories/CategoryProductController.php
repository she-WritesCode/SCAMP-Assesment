<?php

namespace App\Http\Controllers\Api\V1\Categories;

use App\Category;
use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Http\Request;

class CategoryProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Category::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $products = $category->products;

        return $this->showAll($products, 200);
    }
}
