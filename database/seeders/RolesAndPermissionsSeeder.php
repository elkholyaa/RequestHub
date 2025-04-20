<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * The RolesAndPermissionsSeeder defines the application's security roles.
 * 
 * This seeder creates the administrator and user roles required by the application
 * and assigns relevant permissions to them.
 */
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Create permissions
        $permissions = [
            'create requests',
            'edit requests',
            'view all requests',
            'delete requests',
            'manage users',
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        // Create roles and assign permissions
        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo([
            'create requests',
            'edit requests', // Users can edit their own requests
        ]);
        
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo(Permission::all());
    }
}
