<?php

namespace App\Services\Analytics;

use App\Models\Graduate;
use Illuminate\Support\Facades\Cache;

class EmploymentAnalyticsService
{
    public function getEmploymentTrends(): array
    {
        // Cache the query for 24 hours for extreme dashboard speed
        return Cache::remember('bi_employment_trends', now()->addDay(), function () {
            
            $graduates = Graduate::with(['employments', 'academicRecords'])->get();

            $trends = $graduates->groupBy(function ($graduate) {
                // Group by the year they graduated
                return $graduate->academicRecords->first()?->graduation_year ?? 'Unknown';
            })->filter(function ($group, $year) {
                return $year !== 'Unknown'; // Filter out unknown years
            })->map(function ($group) {
                $total = $group->count();
                $employed = $group->filter(function ($grad) {
                    $latestJob = $grad->employments->sortByDesc('created_at')->first();
                    return $latestJob && $latestJob->employment_status === 'Employed';
                })->count();

                // Return the percentage of employed graduates for that year
                return $total > 0 ? round(($employed / $total) * 100, 2) : 0;
            })->sortKeys();

            // We return two arrays: one for the X-axis (Years), one for the Y-axis (Data)
            return [
                'categories' => $trends->keys()->toArray(),
                'data' => $trends->values()->toArray(),
            ];
        });
    }
}