<?php

namespace Database\Factories;

use App\Models\Graduate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Graduate>
 */
class GraduateFactory extends Factory
{
    protected $model = Graduate::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_number' => $this->faker->unique()->numerify('SN-########'),
            'sevispass_id' => $this->faker->unique()->uuid(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'previous_name_at_uni' => $this->faker->name(),
            'university_name' => $this->faker->company() . ' University',
            'course_enrolled' => $this->faker->randomElement(['Computer Science', 'Business Management', 'Accounting', 'Psychology', 
                'Engineering', 'Maths & Computer Science', 'Agricultural Science', 'Communication & Development Studies', 'Lands & Surveying']),
            'birth_date' => $this->faker->dateTimeBetween('-30 years', '-20 years')->format('Y-m-d'),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'nationality' => $this->faker->country(),
            'pob_country' => $this->faker->country(),
            'home_province' => $this->faker->state(),
            'pre_uni_city' => $this->faker->city(),
            'previous_school_name' => $this->faker->company() . ' High School',
            'is_first_gen_family' => $this->faker->boolean(30),
            'is_first_gen_village' => $this->faker->boolean(20),
            'father_education_level' => $this->faker->randomElement(['High School', 'Diploma', 'Bachelors', 'Masters', 'PhD', 'None']),
            'mother_education_level' => $this->faker->randomElement(['Diploma', 'Bachelors', 'Masters', 'PhD', 'None']),
        ];
    }
}
