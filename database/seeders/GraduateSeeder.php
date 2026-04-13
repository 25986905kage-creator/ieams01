<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Graduate;
use App\Models\AcademicRecord;
use App\Models\Employment;
use App\Models\UniversityExperience;
use App\Models\FeedbackSkill;
use App\Models\AlumniEngagement;

class GraduateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 graduates, each with corresponding record in the child tables
        Graduate::factory()
            ->count(50)
            ->has(AcademicRecord::factory()->count(2)) // Each graduate has 10 academic records
            ->has(Employment::factory()->count(2)) // Each graduate has 10 employment records
            ->has(UniversityExperience::factory()->count(2)) // Each graduate has 10 university experience records
            ->has(FeedbackSkill::factory()->count(2)) // Each graduate has 10 feedback skills
            ->has(AlumniEngagement::factory()->count(2)) // Each graduate has 10 alumni engagement records
            ->create();
    }
}
