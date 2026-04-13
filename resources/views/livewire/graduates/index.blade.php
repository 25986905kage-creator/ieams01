<flux:main>
    <div class="mb-6 flex justify-between items-end">
        <div>
            <flux:heading size="xl">Graduates Directory</flux:heading>
            <flux:subheading>Manage alumni, academic records, and employment statuses.</flux:subheading>
        </div>
        
        <flux:button variant="primary" icon="plus" wire:navigate href="/graduates/create">
            Add Graduate
        </flux:button>
    </div>

    <flux:card class="p-0">
        <flux:table :paginate="$this->graduates">
            <flux:table.columns>
                <flux:table.column 
                    sortable 
                    :sorted="$sortBy === 'student_number'" 
                    :direction="$sortDir" 
                    wire:click="sort('student_number')"
                >
                    Student No.
                </flux:table.column>
                
                <flux:table.column 
                    sortable 
                    :sorted="$sortBy === 'last_name'" 
                    :direction="$sortDir" 
                    wire:click="sort('last_name')"
                >
                    Alumni Name
                </flux:table.column>
                
                <flux:table.column>Degree Track</flux:table.column>
                <flux:table.column>Current Status</flux:table.column>
                <flux:table.column align="end">Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->graduates as $graduate)
                    <flux:table.row :key="$graduate->id">
                        
                        <flux:table.cell class="font-medium text-zinc-900 dark:text-white">
                            {{ $graduate->student_number }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <flux:avatar size="sm" :name="$graduate->first_name . ' ' . $graduate->last_name" />
                                <div>
                                    <div class="font-medium">{{ $graduate->first_name }} {{ $graduate->last_name }}</div>
                                    <div class="text-xs text-zinc-500">{{ $graduate->university_name }}</div>
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:text class="text-sm">
                                {{ $graduate->academicRecords->first()?->degree_type ?? 'No Record' }}
                            </flux:text>
                        </flux:table.cell>

                        <flux:table.cell>
                            @php
                                $status = $graduate->employments->first()?->employment_status ?? 'Unknown';
                                $color = match($status) {
                                    'Employed Full-Time', 'Employed Part-Time' => 'green',
                                    'Studying' => 'blue',
                                    'Unemployed' => 'red',
                                    default => 'zinc',
                                };
                            @endphp
                            <flux:badge size="sm" :color="$color" inset="top bottom">
                                {{ $status }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell align="end">
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />
                                
                                <flux:menu>
                                    <flux:menu.item icon="eye" wire:navigate href="/graduates/{{ $graduate->student_number }}">View Profile</flux:menu.item>
                                    <flux:menu.item icon="pencil-square">Edit Record</flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item icon="trash" variant="danger">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>

                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>
</flux:main>