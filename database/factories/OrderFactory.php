<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Order::class;
    public function definition(): array
    {
        return [
            'number' => $this->faker->unique()->numerify('ORD-#####'),
            'email' => $this->faker->safeEmail(),
            'amount' => $this->faker->randomFloat(2, 10, 100), // Random amount between 10 and 100
            'status' => $this->faker->randomElement([
                Status::ARCHIVED->value,
                Status::PAID->value,
                Status::REFUNDED->value,
                Status::FAILED->value,
                Status::UNPAID->value,
            ]),//Use enum values in Status Enum
            'ordered_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'product_id' => Product::factory(), //Associate with existing Products
            'store_id' => Store::factory(), //Associate with existing Stores
        ];
    }
}
