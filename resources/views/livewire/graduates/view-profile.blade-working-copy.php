<flux:modal wire:model="showProfileModal" variant="wide" class="md:max-w-5xl">

    <!-- Main Content (Hidden while loading) -->
    <div wire:loading.remove wire:target="loadGraduate">

        @if($this->graduate)
            <div class="flex items-center gap-4 border-b border-zinc-200 dark:border-zinc-700 pb-4">
                <div class="w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-3xl border border-blue-200 dark:border-blue-800">
                    <flux:heading size="xl">👨‍🎓</flux:heading>
                </div>
                <div class="flex-1">
                    @if($isEditing)
                        <div class="flex gap-2 mb-2">
                            <flux:input wire:model="form.first_name" placeholder="First Name" />
                            <flux:input wire:model="form.last_name" placeholder="Last Name" />
                        </div>
                        <div class="flex gap-2">
                            <flux:input wire:model="form.student_number" placeholder="Student Number" size="sm" />
                            <flux:input wire:model="form.home_province" placeholder="Home Province" size="sm" />
                        </div>
                    @else
                        <flux:heading size="xl">{{ $this->graduate->first_name }} {{ $this->graduate->last_name }}</flux:heading>
                        <div class="text-zinc-500 dark:text-zinc-400 mt-1 flex items-center gap-4">
                            <span class="flex items-center gap-1"><flux:icon.identification class="w-4 h-4"/> {{ $this->graduate->student_number }}</span>
                            <span class="flex items-center gap-1"><flux:icon.map-pin class="w-4 h-4"/> {{ $this->graduate->home_province }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex gap-2 border-b border-zinc-200 dark:border-zinc-700 pb-2 mb-6 overflow-x-auto">
                <flux:button class="mt-2" size="sm" variant="{{ $activeTab === 'demographics' ? 'primary' : 'ghost' }}" color="{{ $activeTab === 'demographics' ? 'blue' : '' }}" wire:click="$set('activeTab', 'demographics', 'color')" icon="user">Demographics</flux:button>
                <flux:button class="mt-2" size="sm" variant="{{ $activeTab === 'academics' ? 'primary' : 'ghost' }}" color="{{ $activeTab === 'academics' ? 'blue' : '' }}" wire:click="$set('activeTab', 'academics', 'color')" icon="academic-cap">Academics</flux:button>
                <flux:button class="mt-2" size="sm" variant="{{ $activeTab === 'employment' ? 'primary' : 'ghost' }}" color="{{ $activeTab === 'employment' ? 'blue' : '' }}" wire:click="$set('activeTab', 'employment', 'color')" icon="briefcase">Employment</flux:button>
                <flux:button class="mt-2" size="sm" variant="{{ $activeTab === 'crm' ? 'primary' : 'ghost' }}" color="{{ $activeTab === 'crm' ? 'blue' : '' }}" wire:click="$set('activeTab', 'crm', 'color')" icon="phone">Contact & CRM</flux:button>
            </div>

            <div class="min-h-[250px]">
                @if($activeTab === 'demographics')
                    @if($isEditing)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <flux:input wire:model="form.name_used_at_uni" label="Preferred Name" />
                            <flux:input wire:model="form.gender" label="Gender" />
                            <flux:input wire:model="form.birth_date" type="date" label="Date of Birth" />
                            <flux:input wire:model="form.nationality" label="Nationality" />
                            <flux:input wire:model="form.pob_country" label="Country of Birth" />
                            <flux:input wire:model="form.previous_school_name" label="Previous School" />
                            <flux:input wire:model="form.pre_uni_city" label="City Before Uni" />
                            <flux:input wire:model="form.father_education_level" label="Father's Education" />
                            <flux:input wire:model="form.mother_education_level" label="Mother's Education" />
                            
                            <div class="col-span-3 flex gap-6 pt-2">
                                <flux:checkbox wire:model="form.is_first_gen_family" label="First Gen Student? (Family)" />
                                <flux:checkbox wire:model="form.is_first_gen_village" label="First Gen Student? (Village)" />
                            </div>
                        </div>
                    @else
                        <dl class="grid grid-cols-1 md:grid-cols-3 gap-y-4 gap-x-8 text-sm">
                            <div><dt class="text-zinc-500">Preferred Name</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->name_used_at_uni ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Gender</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->gender ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Date of Birth</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->birth_date?->format('d-M-Y') ?? 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Nationality</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->nationality ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Country of Birth</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->pob_country ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Previous School before Uni</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->previous_school_name ?: 'N/A' }}</dd></div>                  
                            <div><dt class="text-zinc-500">City Before Uni</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->pre_uni_city ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">First Gen Student? (Family)</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->is_first_gen_family ? 'Yes' : 'No' }}</dd></div>
                            <div><dt class="text-zinc-500">First Gen Student? (Village)</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->is_first_gen_village ? 'Yes' : 'No' }}</dd></div>
                            <div><dt class="text-zinc-500">Father's Education Level</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->father_education_level ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Mother's Education Level</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->mother_education_level ?: 'N/A' }}</dd></div>
                        </dl>
                    @endif

                @elseif($activeTab === 'academics')
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                        <div class="col-span-2"><dt class="text-zinc-500">Course Enrolled</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->course ?: 'N/A' }}</dd></div>
                        @php $academic = $this->graduate->academicRecords->first(); @endphp
                        <div><dt class="text-zinc-500">Graduation Year</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $academic?->graduated_in_year?->format('Y') ?? 'N/A' }}</dd></div>
                        <div><dt class="text-zinc-500">Degree Type</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $academic->degree_type ?? 'N/A' }}</dd></div>
                        <div class="col-span-2"><dt class="text-zinc-500">High School Attended</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->previous_school_name ?: 'N/A' }}</dd></div>
                    </dl>
                
                @elseif($activeTab === 'employment')
                    @php $job = $this->graduate->employments->first(); @endphp
                    @if($job)
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                            <div>
                                <dt class="text-zinc-500">Status</dt>
                                <dd class="font-medium mt-1">
                                    <flux:badge color="{{ $job->employment_status === 'Employed' ? 'emerald' : 'amber' }}">{{ $job->employment_status ?: 'Unknown' }}</flux:badge>
                                </dd>
                            </div>
                            <div><dt class="text-zinc-500">Job Title</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $job->job_title ?: 'N/A' }}</dd></div>
                            <div class="col-span-2"><dt class="text-zinc-500">Industry Sector</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $job->industry_sector ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Year Secured</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $job->job_securing_year ? \Carbon\Carbon::parse($job->job_securing_year)->format('Y') : 'N/A' }}</dd></div>
                        </dl>
                    @else
                        <div class="text-zinc-500 italic py-4">No employment data recorded.</div>
                    @endif
                
                @elseif($activeTab === 'crm')
                    @php $crm = $this->graduate->alumniEngagement; @endphp
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                        <div><dt class="text-zinc-500">Personal Email</dt><dd class="font-medium text-blue-600 dark:text-blue-400"><a href="mailto:{{ $crm->personal_email ?? '' }}">{{ $crm->personal_email ?? 'N/A' }}</a></dd></div>
                        <div><dt class="text-zinc-500">Mobile Number</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $crm->primary_mobile_number ?? 'N/A' }}</dd></div>
                        <div><dt class="text-zinc-500">Social Media Reach</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $crm->primary_social_media ?? 'N/A' }}</dd></div>
                        
                        <div class="col-span-2 mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                            <dt class="text-zinc-500 mb-2">Alumni Association Status</dt>
                            <dd>
                                @if($crm && $crm->wants_to_join_alumni)
                                    <flux:badge color="blue" icon="check-circle">Wants to Join Association</flux:badge>
                                @else
                                    <flux:badge color="zinc">Not Interested / Unknown</flux:badge>
                                @endif
                            </dd>
                        </div>
                    </dl>
                @endif
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-zinc-200 dark:border-zinc-700 mt-6">
                @if($isEditing)
                    <flux:button wire:click="$set('isEditing', false)" variant="ghost">Cancel</flux:button>
                    <flux:button wire:click="save" variant="primary" icon="check">Save Changes</flux:button>
                @else
                    <flux:button wire:click="$set('showProfileModal', false)" variant="ghost">Close</flux:button>
                    <flux:button wire:click="$set('isEditing', true)" variant="primary" color="amber" icon="pencil-square">Edit Record</flux:button>
                @endif
            </div>
        @endif
    </div>
</flux:modal>