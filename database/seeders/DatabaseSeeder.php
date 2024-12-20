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
            SettingSeeder::class,
            RolePermissionSeeder::class,
            EventsTypeSeeder::class,
            UsersSeeder::class
        ]);
    }
}