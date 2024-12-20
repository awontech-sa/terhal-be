<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            ['user_type' => 'visitor'],    // Visitor
            ['user_type' => 'admin'],    // Admin
            ['user_type' => 'tourist'],    // Tourist
            ['user_type' => 'store'],    // Store
            ['user_type' => 'tour-guide'] // tour-guide
        ];

        foreach ($userTypes as $type) {
            UserType::create($type);
        }
    }
}
