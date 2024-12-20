<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
        $roles = [
            'زائر',        // Visitor
            'مدير',        // Admin
            'سائح',        // Tourist
            'متجر',        // Store
            'مرشد سياحي'  // tour-guide
        ];

        // Create roles
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Define permissions for each role
        $permissions = [
            'زائر' => [ // Visitor

            ],

            'مدير' => [ // Admin
                'log out',
            ],

            'سائح' => [ // Tourist
                'log out',
            ],

            'متجر' => [ // Store
                'log out',
            ],

            'مرشد سياحي' => [ // tour-guide
                'log out',
            ],
        ];

        // Create permissions
        foreach ($permissions as $permissionList) {
            foreach ($permissionList as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }
        }

        // Assign permissions to roles
        foreach ($permissions as $role => $permission) {
            $role = Role::findByName($role);
            $role->givePermissionTo($permission);
        }
    }
}
