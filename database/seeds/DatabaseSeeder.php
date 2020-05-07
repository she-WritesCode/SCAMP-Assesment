<?php

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::truncate();
        // Role::truncate();
        // Permission::truncate();

        $models = ['product', 'role', 'user', 'order', 'permission', 'category'];
        $bview = ['viewAny', 'view', 'create', 'update', 'delete'];

        $permissions = [];

        foreach ($models as $model) {
            foreach ($bview as $action) {
                $permissions[$model][] = Permission::create([
                    'slug' => $model . '.' . $action,
                    'name' => Str::ucfirst($action) . ' ' . Str::ucfirst($model),
                ]);
            }
        }

        $allPermissions = Permission::all();

        $admin = Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
        ]);

        $admin->permissions()->attach($allPermissions);

        $salesperson = Role::create([
            'name' => 'Sales Person',
            'slug' => 'sales-person',
        ]);
        $salespersonPermission = Permission::where('slug', 'order.viewAny')->orWhere('slug', 'order.view')->orWhere('slug', 'order.update')->orWhere('slug', 'order.delete')->orWhere('slug', 'order.create')->orWhere('slug', 'product.viewAny')->orWhere('slug', 'product.view')->orWhere('slug', 'category.viewAny')->orWhere('slug', 'category.view')->get()->pluck('id');
        $salesperson->permissions()->attach($salespersonPermission);

        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $user->roles()->attach($admin);

        $user2 = User::create([
            'name' => 'Sales Person User',
            'email' => 'salesperson@example.com',
            'password' => bcrypt('password')
        ]);
        $user2->roles()->attach($salesperson);

        $this->call(ProductsSeeder::class);
        $this->call(OrderSeeder::class);
    }
}
