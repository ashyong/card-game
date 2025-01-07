<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobCategory>
 */
class JobCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['航空業界', 'ホテル業界', '旅行業界']),
            'sort_order' => fake()->numberBetween(1, 3),
            'created_by' => fake()->randomDigit(),
        ];
    }
}
