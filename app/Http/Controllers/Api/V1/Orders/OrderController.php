<?php

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\Orders\OrderCollection;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Order::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(Order::all(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return $this->showOne($order, 200);
    }
}
