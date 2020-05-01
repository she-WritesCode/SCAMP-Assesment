<?php

namespace App\Http\Resources\Products;

use App\Http\Resources\Categories\CategoryIdentifierResource;
use App\Http\Resources\Users\UserIdentifierResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductRelationshipResource extends JsonResource
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
                    'self' => route('products.relationships.user', $this->id),
                    'related' => route('products.user', $this->id),
                ],
                'data' => new UserIdentifierResource($this->user),
            ],
            'category' => [
                'links' => [
                    'self' => route('products.relationships.category', $this->id),
                    'related' => route('products.category', $this->id),
                ],
                'data' => new CategoryIdentifierResource($this->category),
            ],
        ];
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('products.index'),
            ],
        ];
    }
}
