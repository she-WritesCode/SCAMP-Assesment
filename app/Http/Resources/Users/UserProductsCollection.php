<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Products\ProductIdentifierResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserProductsCollection extends ResourceCollection
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
            'data'  => ProductIdentifierResource::collection($this->collection),
            'links' => [
                'self'    => route('users.relationships.products', ['user' => $user->id]),
                'related' => route('users.products', ['user' => $user->id]),
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
