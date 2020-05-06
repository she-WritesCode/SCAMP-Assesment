<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use App\Product;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Order::class, function (Faker $faker) {
    $product = Product::all()->random();
    return [
        'product_id'=> $product->id,
        'user_id'=> User::all()->random()->id,
        'quantity' => $faker->numberBetween(1, $product->quantity),
        'status'=> Arr::random([Order::STATUS_CANCELLED, Order::STATUS_COMPLETED, Order::STATUS_PENDING], 1)[0],
    ];
});
