<?php

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Api\V1\ApiController as Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderUserController extends Controller
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
    public function index(Order $order)
    {
        return $this->showOne($order->user, 200);
    }
}
