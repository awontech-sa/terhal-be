<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'product_type_id' => ProductType::factory(),
            'user_id' => User::factory(),
            'pr_name' => $this->faker->word,
            'pr_images' => json_encode([$this->faker->imageUrl(), $this->faker->imageUrl()]),
            'pr_videos' => json_encode([$this->faker->url]),
            'pr_price' => $this->faker->randomFloat(2, 50, 1000),
            'pr_rates' => $this->faker->randomFloat(1, 1, 5),
            'pr_description' => $this->faker->paragraph,
        ];
    }
}

