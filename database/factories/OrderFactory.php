<?php

namespace Database\Factories;

use App\Models\AdminAccount;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id'       => Customer::factory(),
            'order_type'        => $this->faker->randomElement(['dine_in', 'delivery']),
            'order_number'      => $this->faker->unique()->numerify('DP-########'),
            'table_id'          => Table::inRandomOrder()->first()?->table_id ?? Table::factory(),
            'customer_address'  => $this->faker->optional()->address(),
            'total_price'       => $this->faker->numberBetween(10000, 500000),
            'payment_status'    => $this->faker->randomElement(['pending', 'paid', 'cancelled']),
            'payment_proof'     => $this->faker->imageUrl(),
            'validated_by'      => AdminAccount::factory(),
            'validated_at'      => $this->faker->date(),
        ];
    }
}
