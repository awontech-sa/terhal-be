<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Place;
use App\Models\PlaceType;

class PlaceFactory extends Factory
{
    protected $model = Place::class;

    public function definition()
    {
        return [
            'place_type_id' => PlaceType::factory(),
            'p_name' => $this->faker->city,
            'p_lang' => $this->faker->longitude,
            'p_lat' => $this->faker->latitude,
        ];
    }
}

