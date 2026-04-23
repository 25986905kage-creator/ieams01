<?php

namespace App\Livewire\Graduates;

use App\Livewire\Forms\Graduate\GraduateCreateForm;
use Livewire\Component;

class CreateGraduate extends Component
{
    public GraduateCreateForm $form;

    public function mount()
    {
        $this->form = new GraduateCreateForm($this, 'form');
    }

    public function save()
    {
        $this->form->store();
        
        $this->dispatch('toast', variant: 'success', heading: 'Success', text: 'Graduate added successfully.');

        // Redirect back to the graduate list using Livewire's SPA navigation
        return $this->redirect(route('graduate.list-graduate'), navigate: true);
    }

    public function render()
    {
        return view('livewire.graduates.create-graduate');
    }
}
