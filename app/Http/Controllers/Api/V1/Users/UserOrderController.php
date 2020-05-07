<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Api\V1\ApiController as Controller;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserOrderController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Order::class, 'order');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $orders = $user->orders;

        return $this->showAll($orders, 200);
    }

    /**
     * Store a newly created order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $rules = [
            'quantity' => 'required|integer',
            'product_id' => 'required|int',
            'status' => 'required|string|in:' . Order::STATUS_CANCELLED . ',' . Order::STATUS_COMPLETED . ',' . Order::STATUS_PENDING,
        ];

        $request->validate($rules);

        $data = $request->all();
        $data['user_id'] = $user->id;

        $order = Order::create($data);

        return $this->showOne($order, 200);
    }

    /**
     * Update the specified order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Order $order)
    {
        $this->isUserAdmin($user, $order);

        $rules = [
            'quantity' => 'nullable|integer',
            'product_id' => 'nullable|int',
            'status' => 'nullable|string|in:' . Order::STATUS_CANCELLED . ',' . Order::STATUS_COMPLETED . ',' . Order::STATUS_PENDING,
        ];

        $request->validate($rules);

        $order->fill([
            'quantity' => $request->quantity ?: $order->quantity,
            'description' => $request->description ?: $order->description,
            'status' => $request->status ?: $order->status,
        ]);

        if ($order->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $order->save();

        return $this->showOne($order, 200);
    }

    /**
     * Remove the specified order from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Order $order)
    {
        $this->isUserAdmin($user, $order);

        $order->delete();

        return $this->successResponse(null, 204);
    }
}
