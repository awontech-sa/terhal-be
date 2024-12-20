<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tour;
use App\Models\User;

class TourFactory extends Factory
{
    protected $model = Tour::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            't_name' => $this->faker->word,
            't_image' => json_encode([$this->faker->imageUrl()]),
            't_rate' => $this->faker->randomFloat(1, 1, 5),
            't_date' => $this->faker->dateTime,
            't_description' => $this->faker->paragraph,
            't_price' => $this->faker->randomFloat(2, 100, 500),
        ];
    }
}
