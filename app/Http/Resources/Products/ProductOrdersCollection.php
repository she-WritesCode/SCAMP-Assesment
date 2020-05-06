<?php

namespace App\Http\Resources\Products;

use App\Http\Resources\Orders\OrderIdentifierResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductOrdersCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = $this->additional['product'];

        return [
            'data'  => OrderIdentifierResource::collection($this->collection),
            'links' => [
                'self'    => route('products.relationships.orders', ['product' => $product->id ?? $product]),
                'related' => route('products.orders', ['product' => $product->id??$product]),
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
