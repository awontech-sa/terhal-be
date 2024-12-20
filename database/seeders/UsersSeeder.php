<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'user_type_id' => 5,
            'name' => 'مرشد سياحي',
            'email' => 'tour-guide@example.com',
            'phone' => '966555512345',
            'password' => encrypt(123),
            'status' => 'نشط',
            'age' => 25,
            'gender' => 'أنثى'
        ]);

        User::create([
            'user_type_id' => 2,
            'name' => 'آدمن',
            'email' => 'admin@example.com',
            'phone' => '966555554321',
            'password' => encrypt(123),
            'status' => 'نشط',
            'age' => 25,
            'gender' => 'ذكر'
        ]);

        User::create([
            'user_type_id' => 4,
            'name' => 'التاجر',
            'email' => 'store@example.com',
            'phone' => '966555511111',
            'password' => encrypt(123),
            'status' => 'نشط',
            'age' => 25,
            'gender' => 'ذكر'
        ]);
    }
}
