<?php

namespace App\Livewire\Graduates;

use App\Models\Graduate;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;

#[Title('Graduates Directory - IEAMS')]
class Index extends Component
{
    use WithPagination;

    // The #[Url] attribute magically updates the browser URL when these change!
    // Example: /graduates?sortBy=first_name&sortDir=desc
    #[Url(as: 'sort')]
    public string $sortBy = 'last_name';

    #[Url(as: 'dir')]
    public string $sortDir = 'asc';

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
        
        $this->resetPage(); // Always reset to page 1 when sorting changes
    }

    #[Computed]
    public function graduates()
    {
        return Graduate::query()
            ->with(['academicRecords', 'employments']) 
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(15);
    }

    public function render()
    {
        return view('livewire.graduates.index');
    }
}