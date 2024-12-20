<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TourPlace;
use App\Models\Place;
use App\Models\Tour;

class TourPlaceFactory extends Factory
{
    protected $model = TourPlace::class;

    public function definition()
    {
        return [
            'place_id' => Place::factory(),
            'tour_id' => Tour::factory(),
        ];
    }
}
