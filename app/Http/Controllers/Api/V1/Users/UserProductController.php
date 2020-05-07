<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Api\V1\ApiController as Controller;
use App\Product;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $products = $user->products;

        return $this->showAll($products, 200);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $rules = [
            'name' => 'string|required',
            'quantity' => 'required|integer',
            'price' => 'required',
            'description' => 'required|string',
            'category_id' => 'required|int',
        ];

        $request->validate($rules);

        $data = $request->all();
        $data['user_id'] = $user->id;

        $product = Product::create($data);

        return $this->showOne($product, 200);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Product $product)
    {
        $this->isUserAdmin($user, $product);

        $rules = [
            'name' => 'string|nullable',
            'quantity' => 'nullable|integer',
            'price' => 'nullable',
            'description' => 'nullable|string',
            'category_id' => 'nullable|int',
        ];

        $request->validate($rules);

        $product->fill([
            'name' => $request->name ?: $product->name,
            'quantity' => $request->quantity ?: $product->quantity,
            'price' => $request->price ?: $product->price,
            'description' => $request->description ?: $product->description,
            'category_id' => $request->category_id ?: $product->category_id,
        ]);

        if ($product->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $product->save();

        return $this->showOne($product, 200);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Product $product)
    {
        $this->isUserAdmin($user, $product);

        $product->delete();

        return $this->successResponse(null, 204);
    }
}
