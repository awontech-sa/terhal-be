<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notification;
use App\Models\User;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'n_title' => $this->faker->sentence,
            'n_message' => $this->faker->paragraph,
            'n_type' => $this->faker->randomElement(['عام', 'جولة', 'متجر','حدث']),
            'is_read' => $this->faker->boolean,
            'role_target' => $this->faker->randomElement(['الكل', 'مرشد', 'سائح','متجر']),
            'created_at' => now(),
            'sent_at' => now(),
            'updated_at' => now(),
        ];
    }
}
