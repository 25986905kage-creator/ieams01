<?php

namespace App\Services\Analytics;

use App\Models\FeedbackSkill;
use Illuminate\Support\Facades\Cache;

class SatisfactionAnalyticsService
{
    public function getSatisfactionAverages(): array
    {
        // Cache for 24 hours
        return Cache::remember('bi_satisfaction_averages', now()->addDay(), function () {
            
            // Let the database efficiently calculate the averages in a single query
            $averages = FeedbackSkill::selectRaw('
                AVG(sat_teaching_quality) as teaching,
                AVG(sat_faculty_interaction) as interaction,
                AVG(sat_career_assistance) as career,
                AVG(sat_employment_assistance) as employment,
                AVG(sat_faculty_mentorship) as mentorship
            ')->first();

            return [
                'categories' => [
                    'Teaching Quality', 
                    'Faculty Interaction', 
                    'Career Assistance', 
                    'Employment Assistance', 
                    'Mentorship'
                ],
                'data' => [
                    round($averages->teaching ?? 0, 1),
                    round($averages->interaction ?? 0, 1),
                    round($averages->career ?? 0, 1),
                    round($averages->employment ?? 0, 1),
                    round($averages->mentorship ?? 0, 1),
                ]
            ];
        });
    }
}