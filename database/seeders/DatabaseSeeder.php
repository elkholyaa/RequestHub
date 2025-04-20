<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * The DatabaseSeeder coordinates all database seeding operations.
 * 
 * This class calls the individual seeders in the appropriate order
 * to ensure proper data relationships.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Order is important - we need roles before users, and users before requests
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            RequestSeeder::class,
        ]);
    }
}
