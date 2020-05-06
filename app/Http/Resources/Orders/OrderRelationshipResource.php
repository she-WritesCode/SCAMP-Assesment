<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\Products\ProductIdentifierResource;
use App\Http\Resources\Users\UserIdentifierResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderRelationshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => [
                'links' => [
                    'self' => route('orders.relationships.user', $this->id),
                    'related' => route('orders.user', $this->id),
                ],
                'data' => new UserIdentifierResource($this->user),
            ],
            'product' => [
                'links' => [
                    'self' => route('orders.relationships.product', $this->id),
                    'related' => route('orders.product', $this->id),
                ],
                'data' => new ProductIdentifierResource($this->product),
            ],
        ];
    }
}
