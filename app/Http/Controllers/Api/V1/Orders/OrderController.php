<?php

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\Orders\OrderCollection;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(Order::all(), 200);
    }
}
