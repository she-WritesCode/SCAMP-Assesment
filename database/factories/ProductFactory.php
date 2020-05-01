<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Product;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Builder;

$factory->define(Product::class, function (Faker $faker) {
    $category = Category::all()->random();
    $user = User::whereHas('roles', function (Builder $query) {
        $query->where('slug', 'admin');
    })->get()->random();
    return [
        'name' => $faker->words(rand(1, 3), true),
        'quantity' => $faker->numberBetween(20, 800),
        'price' => $faker->numberBetween(100, 9999),
        'description' => $faker->sentence(),
        'category_id' => $category->id,
        'user_id' => $user->id,
    ];
});
