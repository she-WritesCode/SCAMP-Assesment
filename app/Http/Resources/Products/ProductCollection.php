<?php

namespace App\Http\Resources\Products;

use App\Category;
use App\Http\Resources\Categories\CategoryResource;
use App\Http\Resources\Orders\OrderResource;
use App\Http\Resources\Users\UserResource;
use App\Order;
use App\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => ProductResource::collection($this->collection),
        ];
    }

    public function with($request)
    {
        $orders = $this->collection->flatMap(
            function ($product) {
                return $product->orders;
            }
        );
        $users  = $this->collection->map(
            function ($product) {
                return $product->user;
            }
        );

        $included = $users->merge($orders)->unique('id');

        return [
            'links'    => [
                'self' => route('products.index'),
            ],
            'included' => $this->withIncluded($included),
        ];
    }

    private function withIncluded(Collection $included)
    {
        return $included->map(
            function ($include) {
                if ($include instanceof User) {
                    return new UserResource($include);
                }
                if ($include instanceof Order) {
                    return new OrderResource($include);
                }
            }
        );
    }
}
