
<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <flux:heading size="xl">Graduate Directory</flux:heading>
            <flux:subheading>Overview of graduates over the years.</flux:subheading>
        </div>
        
        <div class="flex justify-end items-end w-2/4">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                icon="magnifying-glass" 
                placeholder="Search by name, ID, province or nationality ..." 
            />
        </div>

        <div>
            <flux:button href="{{ route('graduate.create-graduate') }}" wire:navigate variant="primary" color="lime" icon="plus">
                Add Graduate
            </flux:button>
        </div>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Student ID</flux:table.column>
            <flux:table.column sortable sorted direction="desc">Name</flux:table.column>
            <flux:table.column sortable>Province</flux:table.column>
            <flux:table.column sortable>Nationality</flux:table.column>
            <flux:table.column sortable>Graduation</flux:table.column>
            <flux:table.column sortable>Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($graduates as $graduate)
                <flux:table.row :key="$graduate->id">
                    <flux:table.cell class="text-zinc-800 dark:text-zinc-600">{{ $graduate->student_number }}</flux:table.cell>
                    <flux:table.cell class="text-zinc-800 dark:text-zinc-600">{{ $graduate->first_name }} {{ $graduate->last_name }}</flux:table.cell>
                    <flux:table.cell class="text-zinc-800 dark:text-zinc-600">{{ $graduate->home_province }}</flux:table.cell>
                    <flux:table.cell class="text-zinc-800 dark:text-zinc-600">{{ $graduate->nationality }}</flux:table.cell>
                    <flux:table.cell class="text-zinc-800 dark:text-zinc-600">{{ $graduate->graduation_year }}</flux:table.cell>

                    <flux:table.cell class="text-zinc-800 dark:text-zinc-600">
                        <!-- View Graduate Profile button -->
                        <flux:button 
                            icon="academic-cap" 
                            variant="ghost" 
                            size="xs" 
                            wire:click="$dispatch('view-graduate', { id: {{ $graduate->id }} })"
                            class="hover:bg-amber-500 hover:text-amber-600 dark:hover:bg-amber-950/30 data-loading:opacity-50"
                        />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <div class="mt-4">
        {{ $graduates->links() }}
    </div>

    <livewire:graduates.view-profile />
</div>