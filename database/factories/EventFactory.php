<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;
use App\Models\User;
use App\Models\EventType;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'event_type_id' => EventType::factory(),
            'e_name' => $this->faker->word,
            'e_images' => json_encode([$this->faker->imageUrl(), $this->faker->imageUrl()]),
            'e_location' => $this->faker->address,
            'e_price' => $this->faker->randomFloat(2, 10, 100),
            'e_description' => $this->faker->paragraph,
            'e_date' => $this->faker->dateTime,
            'e_rate' => $this->faker->randomFloat(1, 1, 5),
            'e_videos' => json_encode([$this->faker->url, $this->faker->url]),
        ];
    }
}
