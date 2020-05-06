<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Orders\OrderIdentifierResource;
use App\Http\Resources\Products\ProductIdentifierResource;
use App\Http\Resources\Roles\RoleIdentifierResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRelationshipResource extends JsonResource
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
            'roles' => [
                'data' => RoleIdentifierResource::collection($this->roles, 'roles'),
                'links' => [
                    'self' => route('users.relationships.roles', $this->id),
                    'related' => route('users.roles', $this->id),
                ],
            ],
            'products' =>[
                'data' =>ProductIdentifierResource::collection($this->products, 'products'),
                'links' => [
                    'self' => route('users.relationships.products', $this->id),
                    'related' => route('users.products', $this->id),
                ],
            ],
            'orders' => [
                'data' => OrderIdentifierResource::collection($this->orders ?? collect([]), 'orders'),
                'links' => [
                    'self' => route('users.relationships.orders', $this->id),
                    'related' => route('users.orders', $this->id),
                ],
            ],
        ];
    }
}
