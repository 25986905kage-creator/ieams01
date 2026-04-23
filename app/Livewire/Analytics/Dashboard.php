<?php

namespace App\Livewire\Analytics;

use App\Models\Graduate;
use App\Models\Employment;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Services\Analytics\EmploymentAnalyticsService;
use App\Services\Analytics\SatisfactionAnalyticsService;

#[Title('Institutional Effectiveness Dashboard')]
class Dashboard extends Component
{
    public function render(
        EmploymentAnalyticsService $analyticsService,
        SatisfactionAnalyticsService $satisfactionService
        )
    {
        // 1. Total Graduates in the system
        $totalGraduates = Graduate::count();

        // 2. Overall Employment Rate
        $employedCount = Employment::where('employment_status', 'Employed')->distinct('graduate_id')->count();
        $employmentRate = $totalGraduates > 0 ? round(($employedCount / $totalGraduates) * 100, 1) : 0;

        // 3. First Generation University Students (Family or Village)
        $firstGenCount = Graduate::firstGeneration()->count();
        $firstGenRate = $totalGraduates > 0 ? round(($firstGenCount / $totalGraduates) * 100, 1) : 0;

        // 4. Alumni Ready to be Onboarded
        $pendingAlumni = Graduate::whereHas('alumniEngagement', function ($query) {
            $query->pendingMembers();
        })->count();

        // ----------------------------------------------------
        // NEW: Fetch Chart Data
        // ----------------------------------------------------
        $employmentTrendData = $analyticsService->getEmploymentTrends();
        $satisfactionData = $satisfactionService->getSatisfactionAverages();

        return view('livewire.analytics.dashboard', [
            'totalGraduates' => $totalGraduates,
            'employmentRate' => $employmentRate,
            'firstGenRate' => $firstGenRate,
            'pendingAlumni' => $pendingAlumni,
            'employmentTrendData' => $employmentTrendData, // Pass to view
            'satisfactionData' => $satisfactionData
        ]);
    }
}
