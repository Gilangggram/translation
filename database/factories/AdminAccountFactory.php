<?php

namespace Database\Factories;

use App\Models\AdminAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AdminAccount>
 */
class AdminAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => $this->faker->name(),
            'phone_number'  => '08' . $this->faker->unique()->numerify('##########'),
            'password'      => bcrypt('password'),
            'role'          => $this->faker->randomElement(['owner', 'cashier']),
        ];
    }
}
