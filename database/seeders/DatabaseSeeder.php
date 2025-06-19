<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserTypeSeeder::class,
            // UserSeeder::class,
            // EventTypesSeeder::class,
            // EventsSeeder::class,
            SettingSeeder::class,
            RolePermissionSeeder::class,
        ]);
    }
}
