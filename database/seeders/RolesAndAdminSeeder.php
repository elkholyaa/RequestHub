<?php
/**
 * Seeds the default roles plus one administrator user.
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolesAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'administrator',
            'maintenance_staff',
            'general_staff',
            'service_manager',
        ] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'              => 'System Admin',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('administrator');
    }
}
