<?php

    use Livewire\Component;
    use Livewire\WithPagination;
    use App\Models\Graduate;

    new class extends Component
    {
        use WithPagination;

        // Define sort properties
        public $search = '';
        public $filterNationality = '';
        public $sortby = 'graduation_date';
        public $sortdirection = 'desc';

        // This "listens" for the event and refreshes the component
        #[On('graduate-saved')]
        public function refreshList()
        {
            // Reset to page 1 so the newest/updated record is visible
            $this->resetPage();
            
            // Force the component to re-render using JavaScript
            $this->js('$wire.$refresh()');

        }

        // Reset pagination when search term changes
        public function updatingSearch()
        {
            $this->resetPage();
        }

        // Method to handle sorting logic from the UI
        public function sortBy($column) 
        {
            if ($this->sortby === $column) {
                // Toggle sort direction if the same column is clicked
                $this->sortdirection = $this->sortdirection === 'asc' ? 'desc' : 'asc';
            } else {
                // Set new column and default to ascending
                $this->sortby = $column;
                $this->sortdirection = 'asc';
            }
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
    }

?>

<div class="max-w-7xl mx-auto space-y-6 p-4 md:p-8">
    <flux:heading size="xl" class="text-zinc-900 dark:text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        Graduates
    </flux:heading>
    <flux-subheading class="text-zinc-600 dark:text-zinc-400">Manage and view information about graduates.</flux-subheading>

    <flux:separator variant="subtle" />

    <div class="flex flex-row items-center justify-between gap-4">

        <!-- Search and Action Bar -->
        <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="search graduates" clearable />
        
        <!-- Modal Button -->
        <flux:modal.trigger name="create-graduate" class="flex-none">
            <flux:button variant="primary" color="fuchsia" icon="plus" class="w-full sm:w-auto">
                Create Graduate
            </flux:button>
        </flux:modal.trigger>

    </div>

    <livewire:graduates::graduate.create />

    <!-- Table showing list of graduates -->
    <flux:table :paginate="$graduates">
        <flux:table.columns>
            <flux:table.column :direction="$sortby === 'student_number' ? $sortdirection : null" wire:click="sortBy('student_number')">Student ID</flux:table.column>
            <flux:table.column :direction="$sortby === 'first_name' ? $sortdirection : null" wire:click="sortBy('first_name')">Name</flux:table.column><flux:table.column :direction="$sortby === 'home_province' ? $sortdirection : null" wire:click="sortBy('home_province')">Home Province</flux:table.column>
            <flux:table.column :direction="$sortby === 'nationality' ? $sortdirection : null" wire:click="sortBy('nationality')">Nationality</flux:table.column>
            <flux:table.column :direction="$sortby === 'graduation_date' ? $sortdirection : null" wire:click="sortBy('graduation_date')">Graduation Date</flux:table.column>
             <flux:table.column>Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse($graduates as $graduate)
                <flux:table.row :key="$graduate->id">
                    <!-- Stack name and ID for mobile readability -->
                    <flux:table.cell>
                        <flux:text variant="strong">{{ $graduate->student_number }}</flux:text>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:text variant="strong">{{ $graduate->first_name }} {{ $graduate->last_name }}</flux:text>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:text variant="strong">{{ $graduate->home_province }}</flux:text>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:text variant="strong">{{ $graduate->nationality }}</flux:text>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:text variant="strong">{{ $graduate->graduation_date->format('Y-m-d') ?? 'N/A' }}</flux:text>
                    </flux:table.cell>

                    <div>
                        <flux:table.cell>

                        {{-- Academic Records Button --}}
                        <flux:button 
                            icon="academic-cap" 
                            variant="ghost" 
                            size="xs" 
                            color="zinc"
                            title="Academic Records"
                            wire:click="$dispatch('manage-academic-records', { graduate: {{ $graduate->id }} })" 
                            class="hover:bg-fuchsia-500 hover:text-fuchsia-500 dark:hover:bg-fuchsia-950/30"
                        />


                            <flux:button 
                                icon="pencil-square" 
                                variant="ghost" 
                                size="xs" 
                                wire:click="$dispatch('edit-graduate', { graduate: {{ $graduate->id }} })"
                                class="hover:bg-amber-500 hover:text-amber-500 dark:hover:bg-amber-950/30"
                            />

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

                                    <div class="flex gap-2">
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

                    </div>
                </flux:table.row>
                   @empty
                <flux:table.row>
                    <flux:table.cell colspan="7" class="text-center py-10 text-zinc-500">
                        No graduates found.
                    </flux:table.cell>
                </flux:table.row>
        @endforelse
        </flux:table.rows>
    </flux:table>

    <livewire:graduates::graduate.academic-manager />
 
</div>