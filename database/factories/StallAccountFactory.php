<?php

namespace Database\Factories;

use App\Models\Stall;
use App\Models\StallAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StallAccount>
 */
class StallAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stall_id' => Stall::factory(),
            'phone_number' => '08' . $this->faker->unique()->numerify('##########'),
            'password' => bcrypt('password'),
        ];
    }
}
