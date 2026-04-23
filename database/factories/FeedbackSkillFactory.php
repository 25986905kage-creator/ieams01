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
            'sat_teaching_quality' => fake()->numberBetween(1, 5),
            'sat_faculty_interaction' => fake()->numberBetween(1, 5),
            'exp_oral_presentation' => fake()->numberBetween(1, 5),
            'impact_tech_knowledge' => fake()->numberBetween(1, 5),
            'exp_industry_networking' => fake()->numberBetween(1, 5),
            'sat_career_assistance' => fake()->numberBetween(1, 5),
            'sat_employment_assistance' => fake()->numberBetween(1, 5),
            'sat_faculty_mentorship' => fake()->numberBetween(1, 5),
            'exp_problem_solving'  => fake()->numberBetween(1, 5),
            'exp_practical_learning' => fake()->numberBetween(1, 5),
            'exp_innovation_modeling'  => fake()->numberBetween(1, 5),
            'impact_communication'  => fake()->numberBetween(1, 5),
            'impact_problem_solving' => fake()->numberBetween(1, 5),
            'impact_teamwork' => fake()->numberBetween(1, 5),
            'exp_alumni_networking'  => fake()->numberBetween(1, 5),
        ];
    }
}
