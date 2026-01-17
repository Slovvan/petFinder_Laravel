<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'name' => fake()->firstName(),
            'species' => fake()->randomElement(['dog', 'cat', 'bird']),
            'status' => fake()->randomElement(['Lost', 'In Adoption']),
            'city' => fake()->city(),
            'description' => fake()->paragraph(),
            'latitude' => fake()->latitude(43, 49),
            'longitude' => fake()->longitude(-1, 6),
            'user_id' => User::factory(),
        ];
    }
}
