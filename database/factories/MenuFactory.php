<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Stall;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Menu>
 */
class MenuFactory extends Factory
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
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'image_path'       => $this->faker->imageUrl(),
            'price'       => $this->faker->numberBetween(5000, 50000),
            'is_available'=> $this->faker->boolean(),
            'category'    => $this->faker->randomElement(['nasi', 'sate', 'lauk', 'minuman']),
        ];
    }
}
