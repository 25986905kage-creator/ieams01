<?php

namespace App\Livewire\Graduates;

use Livewire\Component;
use App\Livewire\Concerns\WithTableUtilities;
use App\Models\Graduate;
use Livewire\Attributes\On;

class ListGraduate extends Component
{
    use WithTableUtilities;

    // Add this listener to refresh the table without a page reload
    #[On('graduate-updated')]
    public function refreshTable()
    {
        // This empty method triggers a re-render of the table
    }

    // Delete method for the Flux modal
    public function delete($id)
    {
        $graduate = Graduate::findOrFail($id);
        $graduate->delete();
    }

    public function render()
    {
        return view('livewire.graduates.list-graduate', [
            'graduates' => Graduate::query()
                ->when($this->search, function ($query) {
                    $query->where('first_name', 'like', '%'.$this->search.'%')
                          ->orWhere('last_name', 'like', '%'.$this->search.'%')
                          ->orWhere('student_number', 'like', '%'.$this->search.'%')
                          ->orWhere('previous_school_name', 'like', '%' . $this->search . '%')
                          ->orWhere('nationality', 'like', '%' . $this->search . '%')
                          ->orWhere('home_province', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate(50),
            ]
        );
    }
}
