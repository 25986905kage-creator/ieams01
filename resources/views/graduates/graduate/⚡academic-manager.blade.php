<?php

use Livewire\Component;
use App\Models\Graduate;
use App\Models\AcademicRecord;
use Flux\Flux;

new class extends Component
{
    public ?Graduate $graduate = null;
    public $records = [];
    
    // Form fields for adding a new record
    public $institution_name, $degree_level, $field_of_study, $gpa;

    protected $listeners = ['manage-academic-records' => 'loadRecords'];

    public function loadRecords(Graduate $graduate)
    {
        $this->graduate = $graduate;
        $this->records = $graduate->academicRecords()->latest()->get();
        $this->modal('academic-manager')->show();
    }

    public function addRecord()
    {
        $this->validate([
            'institution_name' => 'required',
            'degree_level' => 'required',
            'field_of_study' => 'required',
        ]);

        $this->graduate->academicRecords()->create([
            'institution_name' => $this->institution_name,
            'degree_level' => $this->degree_level,
            'field_of_study' => $this->field_of_study,
            'gpa' => $this->gpa,
            'start_date' => now(), // Placeholder or add inputs
        ]);

        $this->reset(['institution_name', 'degree_level', 'field_of_study', 'gpa']);
        $this->records = $this->graduate->academicRecords()->latest()->get();
        
        Flux::toast('Academic record added.', variant: 'success');
    }

    public function deleteRecord($id)
    {
        AcademicRecord::destroy($id);
        $this->records = $this->graduate->academicRecords()->latest()->get();
        Flux::toast('Record removed.', variant: 'danger');
    }
}; ?>

<div>
    <flux:modal name="academic-manager" variant="sidebar" class="space-y-6">
        <div>
            <flux:heading size="lg">Academic History</flux:heading>
            <flux:subheading>Managing records for {{ $graduate?->first_name }} {{ $graduate?->last_name }}</flux:subheading>
        </div>

        <flux:separator />

        <!-- Add New Record Form -->
        <form wire:submit.prevent="addRecord" class="space-y-4">
            <flux:input wire:model="institution_name" label="Institution" placeholder="e.g. Harvard University" />
            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="degree_level" label="Degree" placeholder="e.g. Bachelor" />
                <flux:input wire:model="gpa" label="GPA" placeholder="4.0" />
            </div>
            <flux:input wire:model="field_of_study" label="Field of Study" placeholder="e.g. Computer Science" />
            <flux:button type="submit" variant="primary" class="w-full">Add Education</flux:button>
        </form>

        <flux:separator />

        <!-- List of Records -->
        <div class="space-y-4">
            <flux:heading size="md">Past Education</flux:heading>
            @forelse($records as $record)
                <div class="p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg relative group">
                    <flux:button 
                        icon="trash" 
                        variant="ghost" 
                        size="sm" 
                        class="absolute top-2 right-2 text-zinc-400 hover:text-red-500" 
                        wire:click="deleteRecord({{ $record->id }})"
                    />
                    <div class="font-bold text-zinc-900 dark:text-white">{{ $record->degree_level }} in {{ $record->field_of_study }}</div>
                    <div class="text-sm text-zinc-500">{{ $record->institution_name }}</div>
                    @if($record->gpa)
                        <flux:badge size="sm" color="zinc" class="mt-2">GPA: {{ $record->gpa }}</flux:badge>
                    @endif
                </div>
            @empty
                <flux:text class="italic">No academic records found.</flux:text>
            @endforelse
        </div>
    </flux:modal>
</div>  