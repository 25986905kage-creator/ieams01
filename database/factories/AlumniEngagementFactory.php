<?php

namespace Database\Factories;

use App\Models\AlumniEngagement;
use App\Models\Graduate;   
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AlumniEngagement>
 */
class AlumniEngagementFactory extends Factory
{
     protected $model = AlumniEngagement::class;
     
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'graduate_id' => Graduate::factory(),
            'aware_of_alumni_assoc' => $this->faker->boolean(70),
            'wants_to_join_alumni' => $this->faker->boolean(60),
            'personal_email' => $this->faker->unique()->safeEmail(),
            'work_email' => $this->faker->optional()->companyEmail(),
            'postal_address' => $this->faker->address(),
            'primary_mobile_number' => $this->faker->phoneNumber(),
            'secondary_mobile_number' => $this->faker->optional()->phoneNumber(),
            'landline_number' => $this->faker->optional()->phoneNumber(),
            'primary_social_media' => $this->faker->url(),
            'secondary_social_media' => $this->faker->optional()->url(),
            'tertiary_social_media' => $this->faker->optional()->url(),
        ];
    }
}
