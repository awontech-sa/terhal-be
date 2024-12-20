<?php
namespace Database\Factories;

use App\Models\PlaceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceTypeFactory extends Factory
{
    protected $model = PlaceType::class;
    public function definition()
    {
        return [
            'pt_name' => $this->faker->word,
        ];
    }
}
