<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id'            => Order::factory(),
            'menu_id'             => Menu::factory(),
            'quantity'            => $this->faker->numberBetween(1, 10),
            'price_each_at_transaction'=> $this->faker->numberBetween(5000, 50000),
            'total_price'         => function (array $attributes) {
                return $attributes['quantity'] * $attributes['price_each_at_transaction'];
            },
            'notes'               => $this->faker->optional()->sentence(),
            'status'              => $this->faker->randomElement(['preparing', 'served']),
        ];
    }
}
