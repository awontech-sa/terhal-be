<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserEvent;
use App\Models\User;
use App\Models\Event;

class UserEventFactory extends Factory
{
    protected $model = UserEvent::class;

    public function definition()
    {
        return [
            'event_id' => Event::factory(),
            'user_id' => User::factory(),
            'ue_comment' => $this->faker->sentence,
            'ue_rate' => $this->faker->randomFloat(1, 1, 5),
            'is_favorite' => $this->faker->boolean,
        ];
    }
}
