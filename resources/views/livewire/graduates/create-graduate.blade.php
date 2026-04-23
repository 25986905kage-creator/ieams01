<div>
    <flux:main>
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item icon="home" href="{{ route('dashboard') }}" wire:navigate />
            <flux:breadcrumbs.item href="{{ route('graduate.list-graduate') }}" wire:navigate>Graduates</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Add New</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="flex items-center justify-between mb-6">
            <div>
                <flux:heading size="xl">Add New Graduate</flux:heading>
                <flux:subheading>Enter the core demographics for a new graduate record.</flux:subheading>
            </div>
            <flux:button href="{{ route('graduate.list-graduate') }}" wire:navigate variant="ghost" icon="arrow-left">Back to List</flux:button>
        </div>

        <flux:separator class="mb-6" />

        <form wire:submit="save" class="max-w-4xl space-y-8">
            {{-- Section 1: Basic Identification --}}
            <section>
                <flux:heading size="lg" class="mb-4">Basic Identification</flux:heading>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input wire:model="form.first_name" label="First Name" required />
                    <flux:input wire:model="form.last_name" label="Last Name" required />
                    <flux:input wire:model="form.name_used_at_uni" label="Preferred Name (At Uni)" required />
                    <flux:input wire:model="form.student_number" label="Student Number" required />
                </div>
            </section>

            <flux:separator variant="subtle" />

            {{-- Section 2: Demographics --}}
            <section>
                <flux:heading size="lg" class="mb-4">Demographics</flux:heading>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <flux:select wire:model="form.gender" label="Gender" required>
                        <option value="" disabled selected>Select Gender...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </flux:select>
                    
                    <flux:input wire:model="form.birth_date" type="date" label="Date of Birth" />
                    <flux:input wire:model="form.nationality" label="Nationality" required />
                    <flux:input wire:model="form.pob_country" label="Country of Birth" required />
                    <flux:input wire:model="form.home_province" label="Home Province" />
                    <flux:input wire:model="form.home_country" label="Home Country" />
                    <flux:input wire:model="form.pre_uni_city" label="City Before Uni" required />
                </div>
            </section>

            <flux:separator variant="subtle" />

            {{-- Section 3: Background & Education --}}
            <section>
                <flux:heading size="lg" class="mb-4">Background & Education</flux:heading>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input wire:model="form.previous_school_name" label="Previous School Name" required />
                    
                    <div class="space-y-4">
                        <flux:select wire:model="form.father_education_level" label="Father's Education Level" required>
                            <option value="" disabled selected>Select Level...</option>
                            <option value="Primary">Primary</option>
                            <option value="Secondary">Secondary</option>
                            <option value="Tertiary">Tertiary</option>
                            <option value="Unknown">Unknown</option>
                        </flux:select>

                        <flux:select wire:model="form.mother_education_level" label="Mother's Education Level" required>
                            <option value="" disabled selected>Select Level...</option>
                            <option value="Primary">Primary</option>    
                            <option value="Secondary">Secondary</option>
                            <option value="Tertiary">Tertiary</option>
                            <option value="Unknown">Unknown</option>
                        </flux:select>
                    </div>
                </div>

                <div class="flex gap-6 mt-6 p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <flux:checkbox wire:model="form.is_first_gen_family" label="First Generation Student (Family)" />
                    <flux:checkbox wire:model="form.is_first_gen_village" label="First Generation Student (Village)" />
                </div>
            </section>

            {{-- Form Actions --}}
            <div class="flex justify-end items-end gap-4 pt-4">
                <flux:button type="submit" variant="primary" color="lime" icon="plus">Create Graduate</flux:button>
                <flux:button href="{{ route('graduate.list-graduate') }}" wire:navigate variant="ghost">Cancel</flux:button>
                
            </div>
        </form>
    </flux:main>
</div>
