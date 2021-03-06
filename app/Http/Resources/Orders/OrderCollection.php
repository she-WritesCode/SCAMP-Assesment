<?php

namespace App\Http\Resources\Orders;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return OrderResource::collection($this->collection);
    }

    public function with($request)
    {

        return [
            'links'    => [
                'self' => route('orders.index'),
            ],
        ];
    }
}
