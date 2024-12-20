<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserTour;
use App\Models\User;
use App\Models\Tour;

class UserTourFactory extends Factory
{
    protected $model = UserTour::class;

    public function definition()
    {
        return [
            'tour_id' => Tour::factory(),
            'user_id' => User::factory(),
            'ut_comment' => $this->faker->sentence,
            'ut_rate' => $this->faker->randomFloat(1, 1, 5),
            'is_favorite' => $this->faker->boolean,
            'is_added' => $this->faker->boolean,
            'ut_status' => $this->faker->randomElement(['تم الحجز', 'ملغية', 'استعد لرحلتك', 'اليوم رحلتك', 'انتهت رحلتك']),
        ];
    }
}
