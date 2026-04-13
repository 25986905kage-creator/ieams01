<?php

namespace Database\Factories;

use App\Models\UniversityExperience;
use App\Models\Graduate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UniversityExperience>
 */
class UniversityExperienceFactory extends Factory
{
     protected $model = UniversityExperience::class;
     
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hasLeadership = $this->faker->boolean(30); // 30% chance of true

        return [
            'graduate_id' => Graduate::factory(),
            'has_leadership_experience' => $hasLeadership,
            'leadership_role_description' => $hasLeadership ? $this->faker->sentence() : null,
            'is_student_volunteer' => $this->faker->boolean(),
            'is_education_adequate' => $this->faker->boolean(80), // 80% chance of true
            'rating_employment_potential' => $this->faker->randomElement(['Excellent', 'Good', 'Average', 'Poor']),
        ];
    }
}
