<?php

namespace Database\Factories;

use App\Models\Employment;
use App\Models\Graduate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employment>
 */
class EmploymentFactory extends Factory
{
    protected $model = Employment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'graduate_id' => Graduate::factory(),
            'employment_status' => $this->faker->randomElement(['Employed Full-Time', 'Employed Part-Time', 'Unemployed', 'Studying']),
            'job_title' => $this->faker->jobTitle(),
            'job_location_type' => $this->faker->randomElement(['Remote', 'On-site', 'Hybrid']),
            'industry_sector' => $this->faker->randomElement(['Technology', 'Finance', 'Healthcare', 'Education', 'Engineering']),
            'entrepreneurial_intent' => $this->faker->randomElement(['High', 'Medium', 'Low', 'None']),
            'job_securing_year' => $this->faker->date('-6 years', 'now')->format('Y-m-d'),
        ];
    }
}
