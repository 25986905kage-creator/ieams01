<?php

use App\Models\Graduate;
use App\Livewire\Concerns\WithTableUtilities;
use Livewire\Component;

new class extends Component
{
    use WithTableUtilities;

    /**
     * Fetch the graduates list with search and sorting applied.
     */
    public function with(): array
    {
        return [
            'graduates' => Graduate::query()
                ->when($this->search, function ($query) {
                    $query->where('first_name', 'like', '%'.$this->search.'%')
                          ->orWhere('last_name', 'like', '%'.$this->search.'%')
                          ->orWhere('student_number', 'like', '%'.$this->search.'%')
                          ->orWhere('university_name', 'like', '%' . $this->search . '%')
                          ->orWhere('nationality', 'like', '%' . $this->search . '%')
                          ->orWhere('home_province', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate(10),
        ];
    }
};
?>

<div class="p-6">
    <header class="flex justify-between items-center mb-6">
        <flux:heading size="xl" level="1">Graduate Directory</flux:heading>
        
        <div class="w-1/3">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                icon="magnifying-glass" 
                placeholder="Search by name, ID, province or nationality ..." 
            />
        </div>
    </header>

    <flux:table>
        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'student_number'" :direction="$sortDirection" wire:click="sort('student_number')">
                Student ID
            </flux:table.column>
            
            <flux:table.column sortable :sorted="$sortBy === 'last_name'" :direction="$sortDirection" wire:click="sort('last_name')">
                Full Name
            </flux:table.column>

            <flux:table.column>Nationality</flux:table.column>

            <flux:table.column sortable :sorted="$sortBy === 'graduation_date'" :direction="$sortDirection" wire:click="sort('graduation_date')">
                Date Graduated
            </flux:table.column>

            <flux:table.column>Province</flux:table.column>
            <flux:table.column>Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($graduates as $graduate)
                <flux:table.row :key="$graduate->id">
                    <flux:table.cell class="font-medium">
                        <flux:text class="text-zinc-800 dark:text-zinc-600">{{ $graduate->student_number }}</flux:text> 
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:text class="text-zinc-800 dark:text-zinc-600">{{ $graduate->first_name }} {{ $graduate->last_name }}</flux:text>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:text class="text-zinc-800 dark:text-zinc-600">{{ $graduate->nationality }}</flux:text>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:text class="text-zinc-800 dark:text-zinc-600"></flux:text> 
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:text class="text-zinc-800 dark:text-zinc-600">{{ $graduate->home_province }} </flux:text>
                    </flux:table.cell>
                    
                    <flux:table.cell>

                           {{-- Graduant's Records Modal Button --}}
                            <flux:modal.trigger name="create-graduate" class="flex-none">  
                                <flux:button 
                                    icon="academic-cap" 
                                    variant="ghost" 
                                    size="xs" 
                                    wire:click="$dispatch('create-graduate', { graduate: {{ $graduate->id }} })"
                                    class="hover:bg-amber-500 hover:text-amber-500 dark:hover:bg-amber-950/30"
                                />
                            </flux:modal> 

                            {{-- Delete Button with Flux Confirmation --}}
                            <flux:modal.trigger name="delete-graduate-{{ $graduate->id }}" class="flex-none">
                                <flux:button icon="trash" variant="ghost" size="xs" color="red" 
                                    class="hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-950/30"
                                />
                            </flux:modal.trigger>

                            <flux:modal name="delete-graduate-{{ $graduate->id }}" class="md:w-96">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Confirm Deletion</flux:heading>
                                        <flux:subheading>Are you sure you want to delete <strong>{{ $graduate->first_name }} {{ $graduate->last_name }}</strong>? This action cannot be undone.</flux:subheading>
                                    </div>

                                    <div class="flex gap-2 justify-end">
                                        <flux:modal.close>
                                            <flux:button variant="ghost">Cancel</flux:button>
                                        </flux:modal.close>

                                        <flux:button wire:click="delete({{ $graduate->id }})" variant="primary" color="red">
                                            Delete Record
                                        </flux:button>
                                    </div>
                                </div>
                            </flux:modal>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <div class="mt-4">
        {{ $graduates->links() }}
    </div>

</div>