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
        // $this->call(UserSeeder::class);

        $models = ['product', 'role', 'user', 'order', 'permission', 'category'];
        $bread = ['browse', 'read', 'edit', 'add', 'delete'];

        $permissions = [];

        foreach ($models as $model) {
            foreach ($bread as $action) {
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
        $salespersonPermission = Permission::where('slug', 'order.browse')->orWhere('slug', 'order.read')->orWhere('slug', 'order.add')->orWhere('slug', 'product.browse')->orWhere('slug', 'product.read')->orWhere('slug', 'category.browse')->orWhere('slug', 'category.read')->get();
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
    }
}
