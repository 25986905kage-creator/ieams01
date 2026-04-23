<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Graduate;
use App\Models\AcademicRecord;
use App\Models\Employment;
use App\Models\FeedbackSkill;
use App\Models\UniversityExperience;
use App\Models\AlumniEngagement;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Wrap the seeding process in a database transaction.
        // This is a best practice that drastically improves seeding speed 
        // by committing all inserts to the database at once instead of per-row.
        DB::transaction(function () {
            
            // Create 200 Graduates
            Graduate::factory(200)->create()->each(function ($graduate) {
                
                // ---------------------------------------------------------
                // 1. One-to-Many: Academic Records
                // We simulate some graduates having multiple degrees (e.g., Bachelors + Masters)
                // ---------------------------------------------------------
                $numberOfDegrees = fake()->boolean(20) ? 2 : 1; // 20% chance of multiple degrees
                AcademicRecord::factory()->count($numberOfDegrees)->create([
                    'graduate_id' => $graduate->id
                ]);

                // ---------------------------------------------------------
                // 2. One-to-Many: Employment Data
                // Establish core employment state to be reused across domains
                // ---------------------------------------------------------
                $isEmployed = fake()->boolean(75);
                $numberOfJobs = $isEmployed ? fake()->numberBetween(1, 3) : 1; // Career progression

                for ($i = 0; $i < $numberOfJobs; $i++) {
                    // If they are unemployed, only create one record to indicate current status
                    $status = $isEmployed ? 'Employed' : 'Unemployed';
                    
                    Employment::create([
                        'graduate_id' => $graduate->id, 
                        'employment_status' => $status, 
                        'job_title' => $isEmployed ? fake()->jobTitle() : 'NA', 
                        'industry_sector' => $isEmployed ? fake()->companySuffix() : null, 
                        'entrepreneurial_intent' => fake()->randomElement(['Yes', 'No', 'Maybe']), 
                        'job_securing_year' => fake()->dateTimeBetween('-6 years', 'now')->format('Y-m-d'),
                    ]);

                    if (!$isEmployed) break; // Exit loop if unemployed
                }

                // ---------------------------------------------------------
                // 3. One-to-One: Feedback Skills
                // ---------------------------------------------------------
                FeedbackSkill::factory()->create([
                    'graduate_id' => $graduate->id
                ]);

                // ---------------------------------------------------------
                // 4. One-to-One: Experience Metrics
                // Fixed the leadership boolean to accurately reflect the 30% distribution
                // ---------------------------------------------------------
                $hasLeadership = fake()->boolean(30);

                UniversityExperience::create([
                    'graduate_id' => $graduate->id,
                    'has_leadership_experience' => $hasLeadership,
                    'leadership_role_description' => $hasLeadership ? fake()->sentence() : null,
                    'is_student_volunteer' => fake()->boolean(40),
                    'is_education_adequate' => fake()->boolean(80),
                    'rating_employment_potential' => fake()->numberBetween(1, 5),
                ]);

                // ---------------------------------------------------------
                // 5. One-to-One: CRM / Alumni Engagement
                // Re-using the $isEmployed flag to logically assign work emails
                // ---------------------------------------------------------
                AlumniEngagement::create([
                    'graduate_id' => $graduate->id,
                    'aware_of_alumni_assoc' => fake()->boolean(70),
                    'wants_to_join_alumni' => fake()->boolean(60),
                    'personal_email' => fake()->unique()->safeEmail(),
                    // Only assign a work email if the graduate is actually employed
                    'work_email' => $isEmployed ? fake()->unique()->companyEmail() : null,
                    'postal_address' => fake()->address(),
                    'primary_mobile_number' => fake()->phoneNumber(),
                    // 'secondary_mobile_number' => fake()->optional()->phoneNumber(),
                    'landline_number' => fake()->optional()->phoneNumber(),
                    'primary_social_media' => fake()->url(),
                    // 'secondary_social_media' => fake()->optional()->url(),
                    // 'tertiary_social_media' => fake()->optional()->url(),
                    'reachable_social_media' => fake()->optional()->url()
                ]);
            });
            
        });
    }
}
