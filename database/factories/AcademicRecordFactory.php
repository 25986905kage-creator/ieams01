<?php

namespace Database\Factories;

use App\Models\AcademicRecord;
use App\Models\Graduate;
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
            'graduate_id' => Graduate::factory(),
            'degree_type' => $this->faker->randomElement(['Diploma', 'Postgraduate Diploma', 'Bachelors', 'Masters', 'PhD']),
            'award_type' => $this->faker->randomElement(['Bachelor of Science', 'Bachelor of Arts', 'Master of Science']),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'graduate_year' => $this->faker->year(),
        ];
    }
}
