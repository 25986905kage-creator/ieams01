<flux:modal wire:model="showProfileModal" variant="wide" class="md:max-w-7xl w-full">
    <!-- Loading state for better UX -->
    <div wire:loading wire:target="loadGraduate" class="flex justify-center py-10">
        <flux:spacer />
        <flux:heading size="lg">Loading Profile...</flux:heading>
        <flux:spacer />
    </div>

    <div wire:loading.remove wire:target="loadGraduate">
        @if($this->graduate)
            <!-- Header: Profile Identity -->
            <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-700 pb-4">
                <div class="w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-3xl border border-blue-200 dark:border-blue-800">
                    <flux:heading size="xl">👨‍🎓</flux:heading>
                </div>
                <div class="flex-1">
                    @if($isEditing)
                        <div class="flex grid-cols-1 md:grid-cols-4 gap-2 mb-2">
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

            <!-- Navigation Tabs -->
            <div class="flex gap-2 border-b border-zinc-200 dark:border-zinc-700 pb-2 mb-6 overflow-x-auto">
                <flux:button class="mt-2" size="sm" variant="{{ $activeTab === 'demographics' ? 'primary' : 'ghost' }}" color="{{ $activeTab === 'demographics' ? 'blue' : '' }}" wire:click="$set('activeTab', 'demographics')" icon="user">Demographics</flux:button>
                <flux:button class="mt-2" size="sm" variant="{{ $activeTab === 'academics' ? 'primary' : 'ghost' }}" color="{{ $activeTab === 'academics' ? 'blue' : '' }}" wire:click="$set('activeTab', 'academics')" icon="academic-cap">Academics</flux:button>
                <flux:button class="mt-2" size="sm" variant="{{ $activeTab === 'employment' ? 'primary' : 'ghost' }}" color="{{ $activeTab === 'employment' ? 'blue' : '' }}" wire:click="$set('activeTab', 'employment')" icon="briefcase">Employment</flux:button>
                <flux:button class="mt-2" size="sm" variant="{{ $activeTab === 'crm' ? 'primary' : 'ghost' }}" color="{{ $activeTab === 'crm' ? 'blue' : '' }}" wire:click="$set('activeTab', 'crm')" icon="phone">Contact & CRM</flux:button>
            </div>

            <div class="min-h-[250px]">
                <!-- 1. DEMOGRAPHICS TAB -->
                @if($activeTab === 'demographics')
                    @if($isEditingDemographics)
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <flux:input wire:model="form.first_name" label="First Name" />
                            <flux:input wire:model="form.last_name" label="Last Name" />
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
                        <!-- GRADUATES VIEW  ONLY LISTING -->
                        <dl class="grid grid-cols-1 md:grid-cols-3 gap-y-4 p-4 rounded-xl border bg-zinc-50/30">
                            <div><dt class="text-zinc-500">Preferred Name</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->name_used_at_uni ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Gender</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->gender ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Date of Birth</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->birth_date->format('Y-m-d') ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Nationality</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->nationality ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Country of Birth</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->pob_country ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Secondary (National) High School</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->previous_school_name ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">City before Uni</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->pre_uni_city ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Father's Education</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->father_education_level ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">Mother's Education</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->mother_education_level ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">First Gen Student (family)</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->is_first_gen_family ?: 'N/A' }}</dd></div>
                            <div><dt class="text-zinc-500">First Gen Student (village)</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->is_first_gen_village ?: 'N/A' }}</dd></div>
                        </dl>
                    @endif

                <!-- 2. ACADEMICS TAB -->
                @elseif($activeTab === 'academics')
                    <div class="space-y-4">
                        <div class="flex justify-between items-center mb-4">
                            <flux:heading size="lg">Academic History</flux:heading>
                            <!-- Button outside loop so it works for New Entries -->
                            <flux:button variant="primary" color="lime" size="xs" icon="plus" wire:click="addAcademic" />
                        </div>

                        @if($isAddingAcademic)
                            <form wire:submit="saveAcademicRecord" class="bg-white p-4 border rounded-lg shadow-sm mb-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <flux:input wire:model="academicForm.degree_type" label="Degree Type" required />
                                    <flux:input wire:model="academicForm.award_type" label="Award Type" />
                                </div>
                                <div class="flex justify-end gap-2 mt-4">
                                    <flux:button size="sm" variant="ghost" wire:click="$set('isAddingAcademic', false)">Cancel</flux:button>
                                    <flux:button size="sm" type="submit" variant="primary" color="lime">Save Record</flux:button>
                                </div>
                            </form>
                        @endif

                        @forelse($this->graduate->academicRecords as $record)
                        
                            @if(!$isAddingAcademic)
                                <div class="p-4 rounded-lg border border-zinc-200 bg-zinc-50 flex justify-between items-center">
                                        <div>
                                            <div class="font-semibold">{{ $record->degree_type }}</div>
                                            <div class="text-xs text-zinc-500">{{ $record->graduated_in_year?->format('Y') }}</div>
                                        </div>
                                    <div class="flex gap-2">
                                        <flux:button size="xs" variant="primary" color="amber" icon="pencil-square" wire:click="editAcademic({{ $record->id }})" />
                                        <flux:button size="xs" variant="primary" color="red" icon="trash" wire:click="deleteAcademic({{ $record->id }})" wire:confirm="Are you sure?" />
                                    </div>
                                </div>
                            @endif
                        @empty
                            <flux:text color="zinc" class="italic">No academic records found. Click '+' to add one.</flux:text>
                        @endforelse
                    </div>

                <!-- 3. EMPLOYMENT TAB -->
                @elseif($activeTab === 'employment')
                    <div class="space-y-4">
                        <div class="flex justify-between items-start mb-4">
                            <flux:heading size="lg">Employment History</flux:heading>

                            <div class="flex gap-2">
                                <flux:button variant="primary" color="lime" size="xs" icon="plus" wire:click="addEmployment" />
                            </div>
                        </div>

                        @if($isAddingEmployment)
                            <form wire:submit="saveEmployment" class="bg-white p-4 border rounded-lg shadow-sm mb-6">
                                <!-- PROFILE: EMPLOYMENT LISTING -->
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <flux:input wire:model="employmentForm.employment_status" label="Employment Status" />
                                    <flux:input wire:model="employmentForm.job_title" label="Job Title" />
                                    <flux:input wire:model="employmentForm.job_location_type" label="Job Location Type" />
                                    <flux:input wire:model="employmentForm.industry_sector" label="Industry Sector" />
                                    <flux:input wire:model="employmentForm.entrepreneurial_intent" label="Entrepreneurial Intent" />
                                    <flux:input wire:model="employmentForm.job_securing_year" label="Year Employed" />
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <flux:button size="sm" variant="ghost" wire:click="$set('isAddingEmployment', false)">Cancel</flux:button>
                                    <flux:button size="sm" type="submit" variant="primary" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Save Job</span>
                                        <span wire:loading>Saving...</span>
                                    </flux:button>
                                </div>
                            </form>
                        @endif

                        @forelse($this->graduate->employments as $job)
                            <!-- EMPLOYMENT HISTORY: READ ONLY VIEW -->
                             @if(!$isAddingEmployment)
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-y-4 p-4 rounded-xl border bg-zinc-50/30">
                                    <dl class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div><dt class="text-zinc-500">Employment Status</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $job->employment_status ?: 'N/A' }}</dd></div>
                                        <div><dt class="text-zinc-500">Job Title</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $job->job_title ?: 'N/A' }}</dd></div>
                                        <div><dt class="text-zinc-500">Job Location Type</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $job->job_location_type ?: 'N/A' }}</dd></div>
                                        <div><dt class="text-zinc-500">Industry Sector</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $job->industry_sector ?: 'N/A' }}</dd></div>
                                        <div><dt class="text-zinc-500">Entrepreneurial Intent</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $job->entrepreneurial_intent ?: 'N/A' }}</dd></div>
                                        <div><dt class="text-zinc-500">Year Job Secured</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $job->job_securing_year->format('Y') ?: 'N/A' }}</dd></div>                               
                                    </dl>      
                                    <div class="flex justify-end items-start gap-2">
                                        @if(!$isAddingEmployment)
                                            <flux:button variant="primary" color="amber" size="xs" icon="pencil-square" wire:click="editEmployment({{ $job->id }})" />
                                            <flux:button size="xs" variant="primary" color="red" icon="trash" wire:click="deleteEmployment({{ $job->id }})" wire:confirm="Are you sure?" />                                      
                                        @endif  
                                    </div>
                                </div>
                            @endif
                        @empty
                            <flux:text class="italic">No history recorded.</flux:text>
                        @endforelse
                    </div>

                <!-- 4. CONTACT & CRM TAB -->
                @elseif($activeTab === 'crm')
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <flux:heading size="lg">Contact & Alumni Engagement</flux:heading>
                            <div class="flex gap-2">
                                <!-- Issue 1: The 'Close/Cancel' logic is now inside the toggle -->
                                @if(!$isEditingCRM)
                                    <flux:button variant="primary" color="lime" size="xs" icon="plus" wire:click="$set('isEditingCRM', true)" />
                                    <flux:button variant="primary" color="amber" size="xs" icon="pencil-square" wire:click="$set('isEditingCRM', true)" />
                                @else
                                    <flux:button variant="primary" color="red" size="xs" icon="x-mark" wire:click="$set('isEditingCRM', false)" />
                                @endif
                            </div>
                        </div>

                        <!-- For new graduates, ensure $isEditingCRM is true if no record exists -->
                        @if($isEditingCRM || !$this->graduate->alumniEngagement)
                            <form wire:submit="saveCRM" class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <flux:input wire:model="crmForm.personal_email" label="Personal Email" />
                                    <flux:input wire:model="crmForm.primary_mobile_number" label="Mobile Number" />
                                    <flux:input wire:model="crmForm.work_email" label="Work Email" />
                                    <flux:input wire:model="crmForm.personal_email" label="personal Email" />
                                    <flux:input wire:model="crmForm.postal_address" label="Postal Address" />
                                    <flux:input wire:model="crmForm.primary_mobile_number" label="Mobile Number" />
                                    <flux:input wire:model="crmForm.landline_number" label="Landline Nummber" />
                                    <flux:input wire:model="crmForm.reachable_social_media" label="Social Media" />
                                    <flux:input wire:model="crmForm.aware_alumni_assoc" label="Aware of PNGUoT Alumni" />
                                    <flux:input wire:model="crmForm.wants_to_join_alumni" label="Want to Join Alumni" />
                                </div>
                                <div class="flex justify-end">
                                    <flux:button type="submit" variant="primary" color="lime">Update Engagement</flux:button>
                                </div>
                            </form>
                        @else
                            <!-- READ-ONLY CRM VIEW -->
                            <dl class="grid grid-cols-1 md:grid-cols-3 gap-y-4 p-4 rounded-xl border bg-zinc-50/30">
                                <div><dt class="text-zinc-500">Work Email</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->alumniEngagement->work_email ?: 'N/A' }}</dd></div>
                                <div><dt class="text-zinc-500">Personal Email</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->alumniEngagement->personal_email ?: 'N/A' }}</dd></div>
                                <div><dt class="text-zinc-500">Postal Address</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->alumniEngagement->postal_address ?: 'N/A' }}</dd></div>
                                <div><dt class="text-zinc-500">Mobile Number</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->alumniEngagement->primary_mobile_number ?: 'N/A' }}</dd></div>
                                <div><dt class="text-zinc-500">Landline Number</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->alumniEngagement->landline_number ?: 'N/A' }}</dd></div>
                                <div><dt class="text-zinc-500">Preferred Social Media</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->alumniEngagement->reachable_social_media ?: 'N/A' }}</dd></div>
                                <div><dt class="text-zinc-500">Aware of Alumni</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->alumniEngagement->aware_of_alumni_assoc ?: 'N/A' }}</dd></div>
                                <div><dt class="text-zinc-500">Want to Join Alumni</dt><dd class="font-medium text-zinc-900 dark:text-zinc-100">{{ $this->graduate->alumniEngagement->wants_to_join_alumni ?: 'N/A' }}</dd></div>
                            </dl>
                        @endif
                    </div>
                @endif
            </div>

            <!-- GLOBAL MODAL FOOTER -->
            <div class="mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                {{-- Issue 1: Close button now properly toggled --}}
                @if(!$isEditingDemographics && !$isAddingAcademic && !$isAddingEmployment && !$isEditingCRM)
                    <flux:button wire:click="$set('showProfileModal', false)">Close Profile</flux:button>
                @endif

                @if($activeTab === 'demographics')
                    @if(!$isEditingDemographics)
                        <flux:button variant="primary" color="amber" icon="pencil-square" wire:click="$set('isEditingDemographics', true)">Edit Demographics</flux:button>
                    @else
                        <flux:button variant="primary" color="red" wire:click="$set('isEditingDemographics', false)">Cancel</flux:button>
                        <flux:button variant="primary" color="lime" wire:click="saveDemographics">Save Changes</flux:button>
                    @endif
                @endif
            </div>
        @endif
    </div>
</flux:modal>