<?php

namespace App\Http\Resources\Products;

use App\Http\Resources\Categories\CategoryIdentifierResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCategoryResource extends ResourceCollection
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
            'data'  => CategoryIdentifierResource::collection($this->collection),
            'links' => [
                'self'    => route('products.relationships.categories', ['product' => $product->id]),
                'related' => route('products.categories', ['product' => $product->id]),
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
