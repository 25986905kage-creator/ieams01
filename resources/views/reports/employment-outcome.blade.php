<?php

use App\Models\Graduate;
use App\Models\Employment;
use App\Livewire\Concerns\WithTableUtilities;
use Livewire\Component;

new class extends Component
{
    use WithTableUtilities;

    /**
     * Calculate core KPIs for the executive summary.
     */
    public function with(): array
    {
        // Example logic for intelligent business reporting
        $totalGrads = Graduate::count();
        $employedCount = Employment::where('employment_status', 'Employed').count();
        
        return [
            'employmentRate' => $totalGrads > 0 ? round(($employedCount / $totalGrads) * 100, 1) : 0,
            'firstGenPercentage' => $totalGrads > 0 ? round((Graduate::where('is_first_gen_family', true)->count() / $totalGrads) * 100, 1) : 0,
            'outcomes' => Employment::with('graduate')
                ->when($this->search, function ($query) {
                    $query->whereHas('graduate', function ($q) {
                        $q->where('first_name', 'like', '%'.$this->search.'%')
                          ->orWhere('last_name', 'like', '%'.$this->search.'%');
                    })->orWhere('job_title', 'like', '%'.$this->search.'%');
                })
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate(10),
        ];
    }
};
?>

<div class="p-8 space-y-8">
    <flux:heading size="xl">Executive Outcomes Report</flux:heading>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <flux:card class="flex flex-col items-center justify-center p-6 text-center">
            <flux:heading level="3" gray>Employment Rate</flux:heading>
            <div class="text-4xl font-bold text-primary">{{ $employmentRate }}%</div>
            <flux:text size="sm">Graduates currently in the workforce</flux:text>
        </flux:card>

        <flux:card class="flex flex-col items-center justify-center p-6 text-center">
            <flux:heading level="3" gray>First-Gen Impact</flux:heading>
            <div class="text-4xl font-bold text-accent">{{ $firstGenPercentage }}%</div>
            <flux:text size="sm">First in their family to complete university</flux:text>
        </flux:card>

        <flux:card class="flex flex-col items-center justify-center p-6 text-center">
            <flux:heading level="3" gray>Avg. Career Potential</flux:heading>
            <div class="text-4xl font-bold text-success">4.2 / 5</div>
            <flux:text size="sm">Based on graduate feedback ratings</flux:text>
        </flux:card>
    </div>

    <flux:card p="0">
        <div class="p-6 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
            <flux:heading level="2">Employment Trajectory</flux:heading>
            <div class="w-64">
                <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Search by graduate or job..." />
            </div>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Graduate</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'job_title'" :direction="$sortDirection" wire:click="sort('job_title')">
                    Job Title
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'industry_sector'" :direction="$sortDirection" wire:click="sort('industry_sector')">
                    Sector
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'job_securing_date'" :direction="$sortDirection" wire:click="sort('job_securing_date')">
                    Secured On
                </flux:table.column>
                <flux:table.column>Status</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($outcomes as $outcome)
                    <flux:table.row :key="$outcome->id">
                        <flux:table.cell>{{ $outcome->graduate->first_name }} {{ $outcome->graduate->last_name }}</flux:table.cell>
                        <flux:table.cell>{{ $outcome->job_title }}</flux:table.cell>
                        <flux:table.cell>{{ $outcome->industry_sector }}</flux:table.cell>
                        <flux:table.cell>{{ $outcome->job_securing_date ?? 'N/A' }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" :inset="false" color="{{ $outcome->employment_status === 'Employed' ? 'green' : 'zinc' }}">
                                {{ $outcome->employment_status }}
                            </flux:badge>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
        
        <div class="p-4">
            {{ $outcomes->links() }}
        </div>
    </flux:card>
</div>