<?php

use App\Livewire\Forms\Graduate\GraduateCreateForm;
use App\Livewire\Concerns\WithTableUtilities;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Graduate;

new class extends Component
{
    use withTableUtilities;

    // This "listens" for the event and refreshes the component
    #[On('graduate-saved')]
    public function refreshList()
    {
        //
    }

    #[On('graduate-deleted')]
    public function delete(Graduate $graduate)
    {
        $graduate->delete();

        $this->dispatch('graduate-deleted');

        Flux::toast(
            text: 'Graduate record permanently removed.',
            variant: 'danger', // Red toast for deletions
        );
    }

    public function with(): array
    {
        return [
            // Fetch graduates from the DB records with pagination, ordered by latest
            'graduates' => Graduate::query()
            //  Filter by search term across multiple fields
            ->where(function($query) {
                $query->where('student_number', 'like', '%' . $this->search . '%')
                        ->orWhere('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('university_name', 'like', '%' . $this->search . '%')
                        ->orWhere('nationality', 'like', '%' . $this->search . '%')
                        ->orWhere('home_province', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortby, $this->sortdirection)
            ->paginate(10),
        ];
    }

    public function rendering($view)
    {
        return $view->view('livewire:graduates::graduate.create-graduate');
    }

}
?>