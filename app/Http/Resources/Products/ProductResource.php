<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductResource extends JsonResource
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
            'type' => 'products',
            'id' => (string) $this->id,
            'attributes' => [
                'name' => Str::ucfirst($this->name),
                'quantity' => $this->quantity,
                'description' => $this->description,
                'price' => $this->price,
            ],
            'relationships' => new ProductRelationshipResource($this),
            'links' => [
                'self' => route('products.show', $this->id),
            ]
        ];
    }
}
