<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserType;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'password' => bcrypt('password'),
            'status' => $this->faker->randomElement(['نشط', 'غير نشط','محظور']),
            'age' => $this->faker->numberBetween(18, 65),
            'gender' => $this->faker->randomElement(['ذكر', 'أنثى']),
            'user_type_id' => $this->faker->numberBetween(2, 5),
        ];
    }
}
