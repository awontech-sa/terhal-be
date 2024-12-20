<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EventType;

class EventTypeFactory extends Factory
{
    protected $model = EventType::class;

    public function definition()
    {
        return [
            'et_name' => $this->faker->word,
        ];
    }
}

