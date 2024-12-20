<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductType;

class ProductTypeFactory extends Factory
{
    protected $model = ProductType::class;

    public function definition()
    {
        return [
            'prt_name' => $this->faker->word
        ];
    }
}

