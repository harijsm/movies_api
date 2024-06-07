<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(3),
            'rating' => fake()->randomFloat(1, 0, 10),
            'age_restriction' => fake()->randomElement(\App\Models\Movie::$validAgeRestrictions),
            'description' => fake()->text,
            'premieres_at' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'running_time' => fake()->numberBetween(30, 240),
        ];
    }
}
