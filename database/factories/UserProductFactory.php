<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserProduct;
use App\Models\Product;
use App\Models\User;

class UserProductFactory extends Factory
{
    protected $model = UserProduct::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'up_comment' => $this->faker->sentence,
            'up_rate' => $this->faker->randomFloat(1, 1, 5),
            'is_favorite' => $this->faker->boolean,
            'is_buy' => $this->faker->boolean,
            'up_status' => $this->faker->randomElement(['مراجعة الطلب', 'ملغي', 'قيد التنفيذ', 'جاري التوصيل', 'تم التوصيل']),
        ];
    }
}
