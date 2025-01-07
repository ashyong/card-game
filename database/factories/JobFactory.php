<?php

namespace Database\Factories;

use App\Models\JobCategory;
use App\Models\JobType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
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
            'job_type_id' => JobType::factory(),
            'description' => $this->faker->paragraph(),
            'detail' => $this->faker->paragraphs(3, true),
            'business_skill' => $this->faker->words(3, true),
            'knowledge' => $this->faker->words(5, true),
            'location' => $this->faker->city(),
            'activity' => $this->faker->sentence(),
            'salary_range_first_year' => $this->faker->numberBetween(300, 400) . '万円',
            'salary_range_average' => $this->faker->numberBetween(400, 600) . '万円',
            'salary_range_remarks' => $this->faker->sentence(),
            'sort_order' => $this->faker->randomDigit(),
            'publish_status' => 1,
        ];
    }
}
