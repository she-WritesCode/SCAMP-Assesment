<?php

use App\Category;
use App\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Category::truncate();
        // Product::truncate();

        factory(Category::class, 10)->create();
        factory(Product::class, 500)->create();
    }
}
