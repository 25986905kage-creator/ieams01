<?php

use App\Livewire\Forms\Graduate\GraduateCreateForm;
use Livewire\Component;
use App\Models\Graduate;

new class extends Component
{
    public GraduateCreateForm $form;
    public ?Graduate $graduate = null;
    public $currentStep = 1;
    public $totalSteps = 3;
    public $activeTab = 'basic';

    protected $listeners = ['edit-graduate' => 'loadGraduate'];

    public function loadGraduate(Graduate $graduate)
    {
        // Use the form's objecct's helper to fill the data
        $this->form->setGraduate($graduate);

        // Fix dates for HTML input specifically within the form object
        $this->form->birth_date = $graduate->birth_date?->format('Y-m-d');
        $this->form->graduation_date = $graduate->graduation_date?->format('Y-m-d');

        $this->currentStep = 1;
        $this->modal('create-graduate')->show();
    }

    public function save()
    {
        // If editing, update. If new, use the for's store method
        if($this->graduate){
            $this->form->validate();
            $this->graduate->update($this->form->al());
        } else {
            $this->store->store();
        }

        $this->dispatch('graduate-saved');

        Flux::toast(
            text: $this->graduate ? 'Record updated successfully.' : 'Record created successfully',
            variant: 'success'
        );

        $this->modal('create-graduate')->close();
        $this->form->reset();
    }

    public function increaseStep()
    {
        $this->currentStep++;
    }

    public function decreaseStep()
    {
        $this->currentStep--;
    }

    // Method to force boolean values from the UI into real booleans in the component
    public function updating($property, $value)
    {
        // Force string "true"/"false" or "1"/"0" from the UI into real booleans
        if (in_array($property, ['is_first_gen_family', 'is_first_gen_village'])) {
            $this->{$property} = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
    }
} 
?>

<div>

    <flux:modal name="create-graduate" class="w-full md:max-w-5xl h-[90vh]" dismissable>

        {{-- TAB: BASIC INFO --}}
        @if($activeTab === 'basic')
            <form action="" wire:submit.prevent="save" class="space-y-8 h-full flex flex-col">
                
                {{-- I. Modal Header --}}
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">{{$graduate ? 'Update Graduate Information' : 'Create New Graduate Record'}} </flux:heading>
                        <flux:text class="mt-2">
                            Step {{ $currentStep }} of {{$totalSteps}}: {{ $graduate ? 'Update' : 'Create' }} information.</flux:text>
                    </div>

                    {{-- II. Tab Navigation (Only show if editing) --}}
                    @if(@$graduate)
                        <div class="flex items-center gap-2 p-2 mb-6 bg-zinc-100 dark:bg-white/5 rounded-lg w-fit">
                            <flux:button wire:click="setTab('basic')" :variant="$activeTab === 'basic' ? 'filled' : 'ghost'" size="sm">Personal Info</flux:button>
                            <flux:button wire:click="setTab('academic')" :variant="$activeTab === 'academic' ? 'filled' : 'ghost'" size="sm">Academic History</flux:button>
                            <flux:button wire:click="setTab('employment')" :variant="$activeTab === 'employment' ? 'filled' : 'ghost'" size="sm">Employment History</flux:button>
                            <flux:button wire:click="setTab('universityExperience')" :variant="$activeTab === 'universityExperience' ? 'filled' : 'ghost'" size="sm">University Experience</flux:button>
                            <flux:button wire:click="setTab('feedbackSkills')" :variant="$activeTab === 'feedbackSkills' ? 'filled' : 'ghost'" size="sm">Feedback & Skills</flux:button>
                            <flux:button wire:click="setTab('alumniEngagement')" :variant="$activeTab === 'alumniEngagement' ? 'filled' : 'ghost'" size="sm">Alumni Engagement</flux:button>
                        </div>
                    @endif

                    <!-- STEP 1: BASIC INFORMATION -->
                    @if($currentStep === 1)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <flux:input wire:model="form.first_name" label="First Name" description:trailing="Enter the graduate's first name." />
                            <flux:input wire:model="form.last_name" label="Last Name" description:trailing="Enter the graduate's last name." />
                            
                            <flux:input wire:model="form.gender" label="Gender" description:trailing="Enter the graduate's gender." />
                            <flux:input wire:model="form.birth_date" label="Date of birth" type="date" description:trailing="Enter the graduate's date of birth." />

                            <flux:input wire:model="form.pob_country" label="Country of Birth" description:trailing="Enter the graduate's country of birth." />
                            <flux:input wire:model="form.nationality" label="Nationality" description:trailing="Enter the graduate's nationality." />
                        </div>
                    @endif

                    <!-- STEP 2: ACADEMIC INFORMATION -->
                    @if($currentStep === 2)
        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <flux:input wire:model="form.student_number" label="Student ID" description:trailing="Enter the graduate's student ID." />
                            <flux:input wire:model="form.course" label="Course" description:trailing="Enter the graduate's course of study." />
                            
                            <flux:input wire:model="form.university_name" label="University" description:trailing="Enter the graduate's university." />
                            <flux:input wire:model="form.graduation_date" label="Graduation Date" type="date" description:trailing="Enter the graduate's graduation date." />
                            
                            <flux:input wire:model="form.home_province" label="Home Province" description:trailing="Enter the graduate's home province." />
                            <flux:input wire:model="form.nationality" label="Nationality" description:trailing="Enter the graduate's nationality." />
                        </div>
                    @endif

                    <!-- STEP 3: OTHER INFORMATION -->
                    @if($currentStep === 3)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <flux:input wire:model="form.pre_uni_city" label="City" description:trailing="Enter the graduate's city prior to Uni." />
                            <flux:input wire:model="form.previous_school_name" label="Previous School Name" description:trailing="Enter the graduate's previous school." />
                            
                            <flux:input wire:model="form.father_education_level" label="Father's Education Level" description:trailing="Enter the graduate's father's education level." />
                            <flux:input wire:model="form.mother_education_level" label="Mother's Education Level" description:trailing="Enter the graduate's mother's education level." />
                        
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <flux:radio.group wire:model="form.is_first_gen_family" label="First-Generation Family">
                                <flux:radio value="1" label="Yes" />
                                <flux:radio value="0" label="No" />
                            </flux:radio.group>
                            
                            <flux:radio.group wire:model="form.is_first_gen_village" label="First-Generation Village">
                                <flux:radio value="1" label="Yes" />
                                <flux:radio value="0" label="No" />
                            </flux:radio.group>
                        </div>
                    @endif

                    
                    <!-- Navigation Buttons -->
                    <div class="flex modal-footer">
                        <flux:spacer />

                        @if($currentStep > 1)
                            <flux:button type="button" variant="primary" color="zinc" wire:click="decreaseStep" class="mr-2">Previous</flux:button>
                        @endif

                        @if($currentStep < $totalSteps)
                            <flux:button type="button" variant="primary" wire:click="increaseStep">Next</flux:button>
                        @else
                            <flux:button type="submit" variant="primary" color="zinc">
                                {{ $graduate ? 'Update' : 'Save' }}
                            </flux:button>
                        @endif
                    </div>

                </div>
            </form>
        @endif

        {{-- TAB: ACADEMIC HISTORY SECTION --}}
        @if($activeTab === 'academic')
            <div class="space-y-6">
                <div class="flex justify-between items-center">
                    <flux:heading size="lg">Academic History</flux:heading>
                </div>

                @if($graduate)
                    <flux:separator class="my-8" />
                    
                    <div class="space-y-6 pb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <flux:heading size="lg">Academic History</flux:heading>
                                <flux:subheading>Degrees and certifications earned.</flux:subheading>
                            </div>
                            <flux:button 
                                icon="{{ $showAddAcademic ? 'minus' : 'plus' }}" 
                                size="sm" 
                                variant="outline" 
                                wire:click="$toggle('showAddAcademic')"
                            >
                                {{ $showAddAcademic ? 'Cancel' : 'Add Record' }}
                            </flux:button>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Table showing Academic Records --}}
            @if($graduate)
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Degree Type</flux:table.column>
                        <flux:table.column>Award Type</flux:table.column>
                        <flux:table.column>Date Commenced</flux:table.column>
                        <flux:table.column>Date Completed</flux:table.column>
                    </flux:table.columns>
                        
                    @foreach($graduate->academicRecords as $record)
                        <flux:table.row>
                            <flux:table.cell>{{$record->degree_type}}</flux:table.cell>
                            <flux:table.cell>{{$record->award_type}}</flux:table.cell>
                            <flux:table.cell>{{$record->uni_start_date}}</flux:table.cell>
                            <flux:table.cell>{{$record->uni_end_date}}</flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table>
            @endif

            {{-- Inline Add Form --}}
            @if($showAddAcademic)
                <div class="p-6 bg-zinc-50 dark:bg-white/5 border border-fuchsia-200 dark:border-fuchsia-900 rounded-2xl space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input wire:model="degree_type" label="Degree Type" placeholder="e.g. Masters" />
                        <flux:input wire:model="award_type" label="Award Type" />
                        <flux:input wire:model="uni_start_date" label="Uni start date" />
                        <flux:input wire:model="uni_end_date" label="Uni completion date" />
                    </div>
                    <div class="flex justify-end">
                        <flux:button size="sm" variant="primary" color="green" wire:click="addAcademicRecord">
                            Save
                        </flux:button>
                    </div>
                </div>
            @endif
        @endif

        {{-- TAB: EMPLOYMENT HISTORY --}}
        @if($activeTab === 'employment')
            <div class="space-y-6 pb-8">
            
                <div class="flex justify-between items-center">
                    <flux:heading>Employment History</flux:heading>
                </div>

                {{--Employment Form & List Logic goes here --}}
                @if($graduate)
                    <flux:separator class="my-8" />
                    
                    <div class="space-y-6 pb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <flux:heading size="lg">Employement History</flux:heading>
                                <flux:subheading>Work experience acquired.</flux:subheading>
                            </div>
                            <flux:button 
                                icon="{{ $showAddEmployment ? 'minus' : 'plus' }}" 
                                size="sm" 
                                variant="outline" 
                                wire:click="$toggle('showAddEmployment')"
                            >
                                {{ $showAddEmployment ? 'Cancel' : 'Add Record' }}
                            </flux:button>
                        </div>
                    </div>
                @endif
            </div>
        @endif   
        
        {{-- TAB: UNIVERSITY EXPERIENCE --}}
        @if($activeTab === 'universityExperience')
            <div class="space-y-6 pb-8">
                
                <div class="flex justify-between items-center">
                    <flux:heading size="lg">University Experience</flux:heading>
                </div>

                @if($graduate)
                    <flux:separator class="my-8" />
                    
                    <div class="space-y-6 pb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <flux:heading size="lg">University Experience</flux:heading>
                            </div>
                            <flux:button 
                                icon="{{ $showAddUniversityExperience ? 'minus' : 'plus' }}" 
                                size="sm" 
                                variant="outline" 
                                wire:click="$toggle('showAddUniversityExperience')"
                            >
                                {{ $showAddUniversityExperience ? 'Cancel' : 'Add Record' }}
                            </flux:button>
                        </div>
                    </div>
                @endif
            </div>
            
            {{-- Your Add University Experience Form & List Logic from earlier goes here --}}
        @endif
        
        {{-- TAB: FEEDBACK & SKILLS --}}
        @if($activeTab === 'feedbackSkills')
            <div class="space-y-6">
                <div class="flex justify-between items-center">
                    <flux:heading size="lg">Feedback & Skills</flux:heading>
                </div>
                
                @if($graduate)
                    <flux:separator class="my-8" />
                    
                    <div class="space-y-6 pb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <flux:heading size="lg">Feedback & Skills</flux:heading>
                            </div>
                            <flux:button 
                                icon="{{ $showAddFeedbackSkills ? 'minus' : 'plus' }}" 
                                size="sm" 
                                variant="outline" 
                                wire:click="$toggle('showAddFeedbackSkills')"
                            >
                                {{ $showAddFeedbackSkills ? 'Cancel' : 'Add Record' }}
                            </flux:button>
                        </div>
                    </div>
                @endif
              
                {{-- Your Feedback & Skills Form & List Logic from earlier goes here --}}
            </div>
        @endif

        {{-- TAB: ALUMNI ENGAGEMENT --}}
        @if($activeTab === 'alumniEngagement')
            <div class="space-y-6">
                <div class="flex justify-between items-center">
                    <flux:heading size="lg">Alumni Engagement</flux:heading>
                </div>

                @if($graduate)
                    <flux:separator class="my-8" />
                    
                    <div class="space-y-6 pb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <flux:heading size="lg">Alumni Engagement</flux:heading>
                            </div>
                            <flux:button 
                                icon="{{ $showAddAlumniEngagement ? 'minus' : 'plus' }}" 
                                size="sm" 
                                variant="outline" 
                                wire:click="$toggle('showAddAlumniEngagement')"
                            >
                                {{ $showAddAlumniEngagement ? 'Cancel' : 'Add Record' }}
                            </flux:button>
                        </div>
                    </div>
                @endif
                
                {{-- Your Alumni Engagement Form & List Logic from earlier goes here --}}
            </div>
        @endif

    </flux:modal>

</div>