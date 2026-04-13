<?php

namespace Database\Factories;

use App\Models\FeedbackSkill;
use App\Models\Graduate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FeedbackSkill>
 */
class FeedbackSkillFactory extends Factory
{
    protected $model = FeedbackSkill::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ratings = ['Excellent', 'Good', 'Average', 'Poor'];

        return [
            'graduate_id' => Graduate::factory(),
            'sat_teaching_quality' => $this->faker->randomElement($ratings),
            'sat_faculty_interaction' => $this->faker->randomElement($ratings),
            'sat_career_assistance' => $this->faker->randomElement($ratings),
            'sat_employment_assistance' => $this->faker->randomElement($ratings),
            'sat_faculty_mentorship' => $this->faker->randomElement($ratings),
            'exp_oral_presentation' => $this->faker->randomElement($ratings),
            'exp_problem_solving' => $this->faker->randomElement($ratings),
            'exp_practical_learning' => $this->faker->randomElement($ratings),
            'exp_innovation_modeling' => $this->faker->randomElement($ratings),
            'impact_communication' => $this->faker->randomElement($ratings),
            'impact_problem_solving' => $this->faker->randomElement($ratings),
            'impact_teamwork' => $this->faker->randomElement($ratings),
            'impact_tech_knowledge' => $this->faker->randomElement($ratings),
            'exp_industry_networking' => $this->faker->randomElement($ratings),
            'exp_alumni_networking' => $this->faker->randomElement($ratings),
        ];
    }
}
