<?php

namespace Database\Factories;

use App\Models\AcademicRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AcademicRecord>
 */
class AcademicRecordFactory extends Factory
{
    protected $model = AcademicRecord::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'degree_type' => fake()->randomElement(['Bachelor of Science', 'Bachelor of Arts', 'Master of Engineering']),
            'award_type' => fake()->randomElement(['First Class Honours', 'Merit', 'Pass']),
            'graduated_in_year' => fake()->numberBetween(2020, 2026), // Optimized for trend reporting
        ];
    }
}
