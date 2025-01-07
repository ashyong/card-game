<?php

namespace Database\Factories;

use App\Models\JobCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobType>
 */
class JobTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['キャビンアテンダント', 'グランドスタッフ', 'ホテルスタッフ', 'ツアーガイド']),
            'job_category_id' => JobCategory::factory(),
            'sort_order' => fake()->numberBetween(1, 5),
            'created_by' => fake()->randomDigit(),
        ];
    }
}
