<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'  => fake()->userName(),
            'price' => fake()->numberBetween(100, 500),
            'image' => fake()->imageUrl(),
            'desc'  => fake()->paragraph(),
        ];
    }
}
