<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Orders\OrderIdentifierResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserOrdersCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $this->additional['user'];

        return [
            'data'  => OrderIdentifierResource::collection($this->collection),
            'links' => [
                'self'    => route('users.relationships.orders', ['user' => $user->id]),
                'related' => route('users.orders', ['user' => $user->id]),
            ],
        ];
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('users.index'),
            ],
        ];
    }
}
