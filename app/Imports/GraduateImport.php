<?php

namespace App\Imports;

use App\Models\Graduate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class GraduateImport implements ToModel, WithHeadingRow, WithChunkReading
{
    public function model(array $row)
    {
        // dd($row);

        // 1. Data Dictionary Translation Layer
        $cleanData = [
            'student_number'            => $row['what_is_your_student_number'] ?? null,
            'first_name'                => $row['what_is_your_first_name'] ?? null,
            'last_name'                 => $row['what_is_your_last_name'] ?? null,
            'name_used_at_uni'          => $row['what_name_did_you_use_while_at_university'] ?? null,
            'gender'                    => $row['what_is_your_gender'] ?? null,
            'birth_date'                => $row['what_is_your_date_of_birth'] ?? null,
            'nationality'               => $row['what_is_your_nationality'] ?? null,
            'pob_country'               => $row['what_is_your_country_of_birth'] ?? null,
            'home_province'             => $row['which_province_do_you_come_from'] ?? null,
            'pre_uni_city'              => $row['select_major_city_you_lived_in_before_your_selection_to_university'] ?? null,
            'previous_school_name'      => $row['which_school_did_you_last_attend_before_entering_university'] ?? null,
            'father_education_level'    => $row['what_is_the_highest_level_of_school_your_father_completed'] ?? null,
            'mother_education_level'    => $row['what_is_the_highest_level_of_school_your_mother_completed'] ?? null,
            'is_first_gen_family'       => $row['are_you_the_first_member_of_your_immediate_family_to_complete_university'] ?? null,
            'is_first_gen_village'      => $row['are_you_the_first_person_from_your_village_to_complete_university'] ?? null,

            // Academic [Table: academic_records]
            'degree_type'               => $row['select_the_type_of_degree_you_will_be_accorded_upon_graduation_in_april_2021'] ?? null,
            'award_type'                => $row['select_the_award_you_will_be_accorded_upon_graduation_in_april_2021'] ?? null,
            'graduated_in_year'         => $row['what_is_you_expected_graduation_date'] ?? null,                  

            // Employment
            'employment_status'         => $row['please_indicate_your_present_employment_status'] ?? null,
            'job_title'                 => $row['what_is_your_job_title'] ?? null,
            'job_location_type'         => $row['is_your_job_based_in_the_city_or_outside_of_the_city'] ?? null,
            'industry_sector'           => $row['what_industry_are_you_working_for_please_specify_eg_agriculture_construction_health_care_business_engineering_education_mining_telecommunication_computer_and_technology_hospitality_media_and_news_energy_manufacturing'] ?? null,
            'entrepreneurial_intent'    => $row['do_you_plan_on_setting_up_your_own_business'] ?? null,
            'job_securing_year'         => $row['when_did_you_secure_your_job'] ?? null,

            // University Experience
            'has_leadership_experience'     => $row['have_you_take_any_leadership_roles_while_at_the_university'] ?? null,
            'leadership_role_description'   => $row['what_leadership_role_did_you_play'] ?? null,
            'is_student_volunteer'          => $row['were_you_a_student_volunteer_during_a_university_organized_event'] ?? null,
            'is_education_adequate'         => $row['do_you_feel_that_the_education_you_have_received_at_the_university_has_been_adequate'] ?? null,
            'rating_employment_potential'   => $row['how_would_you_rate_the_employment_potential_of_your_degree'] ?? null,

            // Feedback
            'sat_teaching_quality'      => $row['how_satisfied_are_you_with_the_quality_of_teaching_in_your_major_field'] ?? null,
            'sat_faculty_interaction'   => $row['how_satisfied_are_you_with_the_interaction_with_faculty_members_outside_the_classroom'] ?? null,
            'sat_career_assistance'     => $row['how_satisfied_are_you_with_the_assistance_by_faculty_members_in_pursuing_your_career'] ?? null,
            'sat_employment_assistance' => $row['how_satisfied_are_you_with_the_assistance_by_faculty_members_in_finding_employment'] ?? null,
            'sat_faculty_mentorship'    => $row['how_satisfied_are_you_with_the_assistance_by_faculty_in_providing_advice_and_involvement_in_other_student_activities'] ?? null,
            'exp_problem_solving'       => $row['how_frequent_were_you_exposed_to_opportunities_to_define_and_solve_problems_1never_2seldom_3occasionally_4frequently_5nearly_always'] ?? null,
            'exp_practical_learning'    => $row['how_frequent_were_you_exposed_to_learning_by_doing_activities_1never_2seldom_3occasionally_4frequently_5nearly_always'] ?? null,
            'exp_innovation_modeling'   => $row['to_what_extent_were_you_given_opportunities_to_develop_a_prototype_or_a_business_model_1never_2seldom_3occasionally_4frequently_5nearly_always'] ?? null,
            'impact_communication'      => $row['to_what_extent_has_the_university_experience_impacted_your_communication_skills_speaking_writing_listening_etc'] ?? null,
            'exp_oral_presentation'     => $rwo['how_frequent_were_you_exposed_to_opportunities_in_oral_presentations_1never_2seldom_3occasionally_4frequently_5nearly_always'] ?? null,
            'impact_problem_solving'    => $row['to_what_extent_has_the_university_experience_impacted_your_problem_solving_skills'] ?? null,
            'impact_teamwork'           => $row['to_what_extent_has_the_university_experience_impacted_your_ability_to_work_in_a_team_environment'] ?? null,
            'impact_tech_knowledge'     => $row['to_what_extent_has_the_university_experience_impacted_your_knowledge_of_modern_technology'] ?? null,
            'exp_industry_networking'   => $row['how_frequent_were_you_exposed_to_networking_opportunities_with_industry_1never_2seldom_3occasionally_4frequently_5nearly_always'] ?? null,
            'exp_alumni_networking'     => $row['how_frequent_were_you_exposed_to_networking_opportunities_with_alumni_1never_2seldom_3occasionally_4frequently_5nearly_always'] ?? null,

            // Alumni CRM
            'aware_of_alumni_assoc'     => $row['have_you_heard_of_the_pnguot_alumni_association'] ?? null,
            'wants_to_join_alumni'      => $row['would_you_like_to_register_as_a_member_of_the_pnguot_alumni_association'] ?? null,
            'personal_email'            => $row['what_is_your_personal_email_address'] ?? null,
            'work_email'                => $row['what_is_your_work_email_address'] ?? null,
            'postal_address'            => $row['what_is_your_postal_address'] ?? null,
            'primary_mobile_number'     => $row['what_is_your_mobile_number'] ?? null,
            'landline_number'           => $row['what_is_your_landline_number'] ?? null,
            'reachable_social_media'    => $row['which_social_media_platform_are_you_most_reachable'] ?? null,
        ];

        // 2. Skip rows that don't have the primary identifier
        if (empty($cleanData['student_number'])) {
            return null;
        }
        
        // 3. Database Transaction populating ALL 6 TABLES
        return DB::transaction(function () use ($cleanData) {
            
            // Table 1: Graduates
            $graduate = Graduate::updateOrCreate(
                ['student_number' => $cleanData['student_number']],
                $this->mapGraduateDemographics($cleanData)
            );

            // Table 2: Academic Records
            $graduate->academicRecords()->updateOrCreate(
                ['graduate_id' => $graduate->id],
                $this->mapAcademicData($cleanData)
            );

            // Table 3: Feedback Skills
            $graduate->feedbackSkills()->updateOrCreate(
                ['graduate_id' => $graduate->id],
                $this->mapFeedbackData($cleanData)
            );

            // Table 4: Employment (NEW)
            $graduate->employments()->updateOrCreate(
                ['graduate_id' => $graduate->id],
                $this->mapEmploymentData($cleanData)
            );

            // Table 5: University Experience (NEW)
            $graduate->universityExperience()->updateOrCreate(
                ['graduate_id' => $graduate->id],
                $this->mapUniversityExperienceData($cleanData)
            );

            // Table 6: Alumni Engagement (NEW)
            $graduate->alumniEngagement()->updateOrCreate(
                ['graduate_id' => $graduate->id],
                $this->mapAlumniEngagementData($cleanData)
            );

            // Clear BI Caches
            Cache::forget('bi_employment_trends');
            Cache::forget('bi_satisfaction_averages');

            return $graduate;
        });
    }
    
    // Process 500 rows at a time
    public function chunkSize(): int
    {
        return 500;
    }

    /*
    |--------------------------------------------------------------------------
    | Data Mapping Helpers (ALL 6 DOMAINS)
    |--------------------------------------------------------------------------
    */

    private function mapGraduateDemographics(array $cleanData): array
    {
        return [
            'first_name'                => $cleanData['first_name'] ?? 'Unknown',
            'last_name'                 => $cleanData['last_name'] ?? 'Unknown',
            'name_used_at_uni'          => $cleanData['name_used_at_uni'] ?? 'Unknown',
            'gender'                    => $cleanData['gender'] ?? null,
            'birth_date'                => $cleanData['birth_date'],
            'course'                    => $cleanData['course_enrolled'] ?? 'unknown',
            'nationality'               => $cleanData['nationality'] ?? 'unknown',
            'pob_country'               => $cleanData['pob_country'] ?? 'unknown',
            'home_province'             => $cleanData['home_province'] ?? 'unknown',
            'pre_uni_city'              => $cleanData['pre_uni_city'] ?? 'unknown',
            'previous_school_name'      => $cleanData['previous_school_name'] ?? 'unknown',
            'father_education_level'    => $cleanData['father_education_level'] ?? 'unknown',
            'mother_education_level'    => $cleanData['mother_education_level'] ?? 'unknown',
            'is_first_gen_family'       => strtolower(trim($cleanData['is_first_gen_family'] ?? '')) === 'yes',
            'is_first_gen_village'      => strtolower(trim($cleanData['is_first_gen_village'] ?? '')) === 'yes',
        ];
    }

    private function mapAcademicData(array $cleanData): array
    {
        return [
            'degree_type'     => $cleanData['degree_type'] ?? null,
            'award_type'      => $cleanData['award_type'] ?? null,
            'graduated_in_year' => $cleanData['graduated_in_year'] ?? null,  
        ];
    }

    private function mapFeedbackData(array $cleanData): array
    {
        return [
            'sat_teaching_quality'      => (int) ($cleanData['sat_teaching_quality'] ?? 0),
            'sat_faculty_interaction'   => (int) ($cleanData['sat_faculty_interaction'] ?? 0),
            'sat_career_assistance'     => (int) ($cleanData['sat_career_assistance'] ?? 0),
            'sat_employment_assistance' => (int) ($cleanData['sat_employment_assistance'] ?? 0),          
            'exp_problem_solving'       => (int) ($cleanData['exp_problem_solving'] ?? 0),
            'exp_practical_learning'    => (int) ($cleanData['exp_practical_learning'] ?? 0),
            'exp_innovation_modeling'   => (int) ($cleanData['exp_innovation_modeling'] ?? 0),
            'exp_oral_presentation'     => (int) ($cleanData['exp_oral_presentation'] ?? 0),
            'impact_communication'      => (int) ($cleanData['impact_communication'] ?? 0),
            'impact_problem_solving'    => (int) ($cleanData['impact_problem_solving'] ?? 0),          
            'impact_tech_knowledge'     => (int) ($cleanData['impact_tech_knowledge'] ?? 0),
            'exp_alumni_networking'     => (int) ($cleanData['exp_alumni_networking'] ?? 0)
        ];
    }

    private function mapEmploymentData(array $cleanData): array
    {
        return [
            'employment_status'      => $cleanData['employment_status'] ?? null,
            'job_title'              => $cleanData['job_title'] ?? null,
            'job_location_type'      => $cleanData['job_location_type'] ?? null,
            'industry_sector'        => $cleanData['industry_sector'] ?? null,
            'entrepreneurial_intent' => $cleanData['entrepreneurial_intent'] ?? null,
            // Only parse if it looks like a full date, otherwise store year or null
            'job_securing_year'      => $this->parseDate($cleanData['job_securing_year'] ?? null), 
        ];
    }

    private function mapUniversityExperienceData(array $cleanData): array
    {
        return [
            // Boolean conversions for MySQL
            'has_leadership_experience'   => strtolower(trim($cleanData['has_leadership_experience'] ?? '')) === 'yes',
            'leadership_role_description' => $cleanData['leadership_role_description'] ?? null,
            'is_student_volunteer'        => strtolower(trim($cleanData['is_student_volunteer'] ?? '')) === 'yes',
            'is_education_adequate'       => strtolower(trim($cleanData['is_education_adequate'] ?? '')) === 'yes',
            'rating_employment_potential' => $cleanData['rating_employment_potential'] ?? null,
        ];
    }

    private function mapAlumniEngagementData(array $cleanData): array
    {
        return [
            // Boolean conversions for MySQL
            'aware_of_alumni_assoc'   => strtolower(trim($cleanData['aware_of_alumni_assoc'] ?? '')) === 'yes',
            'wants_to_join_alumni'    => strtolower(trim($cleanData['wants_to_join_alumni'] ?? '')) === 'yes',
            'personal_email'          => $cleanData['personal_email'] ?? null,
            'work_email'              => $cleanData['work_email'] ?? null,
            'postal_address'          => $cleanData['postal_address'] ?? null,
            'primary_mobile_number'   => $cleanData['primary_mobile_number'] ?? null,
            'landline_number'         => $cleanData['landline_number'] ?? null,
            'reachable_social_media'  => $cleanData['reachable_social_media'] ?? null,
        ];
    }

    private function parseDate($date)
    {
        if (!$date) return null;
        
        // If the user just typed "2024", return that year appended with -01-01
        if (is_numeric($date) && strlen($date) == 4) {
            // return $date . '-01-01';
            return $date . 'd-M-Y';
        }

        return date('Y-m-d', strtotime($date)); 
    }
}