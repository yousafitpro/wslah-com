<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::query()->firstOrCreate([
            'name'  => 'admin',
            'label' => 'Admin',
        ]);

        $restaurantRole = Role::query()->firstOrCreate([
            'name'  => 'restaurant',
            'label' => 'Restaurant',
        ]);

        // Define and create permissions
        $permissions = [
            'access specific feature',
            'access restaurant', // We will add restaurant ID dynamically when needed
        ];

        foreach ($permissions as $permissionName) {
            Permission::query()->firstOrCreate(['name' => $permissionName]);
        }

        // Assign permissions to roles
        $adminPermissions = Permission::all();
        $adminRole->syncPermissions($adminPermissions);

        // In this case, restaurant role has no additional permissions beyond default 'access restaurant' permission
        // But if you add more permissions for restaurants, you can assign them here.
    }
}
