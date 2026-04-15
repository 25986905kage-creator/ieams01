<?php

use Livewire\Component;
use App\Models\Graduate;

new class extends Component
{
    public ?Graduate $graduate = null;
    public ?SubTitle $subTitle = null;
    public $currentStep = 1; // Start at step 1
    public $totalSteps = 3;

    // Graduate properties
    public $id, $student_number, $first_name, $last_name, $university_name, $course, $birth_date, $graduation_date, $gender, $nationality, $pob_country, $home_province, 
    $pre_uni_city, $previous_school_name, $is_first_gen_family = false, $is_first_gen_village = false, $father_education_level, $mother_education_level;


    protected $listeners = ['edit-graduate' => 'loadGraduate'];

    public function loadGraduate(Graduate $graduate)
    {
        $this->graduate = $graduate;

        // Use except(['graduate']) to prevent mass assignment on the model property itself
        $this->fill(
            collect($graduate->toArray())
                ->except(['graduate', 'created_at', 'updated_at'])
                ->toArray()
        );

       // Force these to strings so the radio button 'value="1"' matches
        $this->is_first_gen_family = $graduate->is_first_gen_family ? "1" : "0";
        $this->is_first_gen_village = $graduate->is_first_gen_village ? "1" : "0";

        // Ensure dates are string format for HTML inputs
        $this->birth_date = $graduate->birth_date?->format('Y-m-d');
        $this->graduation_date = $graduate->graduation_date?->format('Y-m-d');

        $this->currentStep = 1;
        $this->modal('create-graduate')->show();
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

    public function save()
    {
        $data = $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'student_number' => 'required', 
            'university_name'  => 'required',
            'course' => 'required',
            'birth_date'  => 'date|required',
            'graduation_date' => 'date|required',
            'gender' => 'required',
            'nationality' => 'required', 
            'pob_country' => 'required', 
            'home_province' => 'required', 
            'pre_uni_city' => 'required', 
            'previous_school_name' => 'required', 
            'is_first_gen_family' => 'required|in:0,1,true,false', 
            'is_first_gen_village' => 'required|in:0,1,true,false', 
            'father_education_level' => 'required', 
            'mother_education_level' => 'required',
        ]);
        
        // If $this->graduate exists, update it. Otherwise, create new
        Graduate::updateOrCreate(
            ['id' => $this->graduate?->id ?? null], // Match by ID if editing
            $data
        );

        // Dispatch the refresh event to the index component to update the list of graduates
        $this->dispatch('graduate-saved')->to('graduates::graduate.index');

        // True if we're editing an existing record
        $isUpdating = (bool) $this->graduate; 

         // Show the Success Toast with appropriate message based on whether we're creating or updating
         Flux::toast(
            text: $isUpdating ? 'Graduate record updated successfully.' : 'New graduate created successfully.',
            variant: $isUpdating ? 'success' : 'success',
        );

        $this->modal('create-graduate')->close();

        // Clear form for next time
        $this->reset();
    }
 
}
?>

<div>

    <flux:modal name="create-graduate" class="md:w-1/2" dismissable>
        <form action="" class="space-y-8" wire:submit.prevent="save">
            
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">{{$graduate ? 'Update Graduate Information' : 'Create New Graduate Record'}} </flux:heading>
                    <flux:text class="mt-2">
                        Step {{ $currentStep }} of {{$totalSteps}}: {{ $graduate ? 'Update' : 'Create' }} information.</flux:text>
                </div>

                <!-- Step 1: Basic Information -->
                 @if($currentStep === 1)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <flux:input wire:model="first_name" label="First Name" description:trailing="Enter the graduate's first name." />
                        <flux:input wire:model="last_name" label="Last Name" description:trailing="Enter the graduate's last name." />
                        
                        <flux:input wire:model="gender" label="Gender" description:trailing="Enter the graduate's gender." />
                        <flux:input wire:model="birth_date" label="Date of birth" type="date" description:trailing="Enter the graduate's date of birth." />

                        <flux:input wire:model="pob_country" label="Country of Birth" description:trailing="Enter the graduate's country of birth." />
                        <flux:input wire:model="nationality" label="Nationality" description:trailing="Enter the graduate's nationality." />
                    </div>
                @endif

                <!-- Step 2: Academic Information -->
                 @if($currentStep === 2)
    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <flux:input wire:model="student_number" label="Student ID" description:trailing="Enter the graduate's student ID." />
                        <flux:input wire:model="course" label="Course" description:trailing="Enter the graduate's course of study." />
                        
                        <flux:input wire:model="university_name" label="University" description:trailing="Enter the graduate's university." />
                        <flux:input wire:model="graduation_date" label="Graduation Date" type="date" description:trailing="Enter the graduate's graduation date." />
                        
                        <flux:input wire:model="home_province" label="Home Province" description:trailing="Enter the graduate's home province." />
                        <flux:input wire:model="nationality" label="Nationality" description:trailing="Enter the graduate's nationality." />
                    </div>
                @endif

                <!-- Step 3: Other Information -->
                 @if($currentStep === 3)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <flux:input wire:model="pre_uni_city" label="City" description:trailing="Enter the graduate's city prior to Uni." />
                        <flux:input wire:model="previous_school_name" label="Previous School Name" description:trailing="Enter the graduate's previous school." />
                        
                        <flux:input wire:model="father_education_level" label="Father's Education Level" description:trailing="Enter the graduate's father's education level." />
                        <flux:input wire:model="mother_education_level" label="Mother's Education Level" description:trailing="Enter the graduate's mother's education level." />
                    
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <flux:radio.group wire:model="is_first_gen_family" label="First-Generation Family">
                            <flux:radio value="1" label="Yes" />
                            <flux:radio value="0" label="No" />
                        </flux:radio.group>
                        
                        <flux:radio.group wire:model="is_first_gen_village" label="First-Generation Village">
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
                        <flux:button type="submit" variant="primary" color="green">
                            {{ $graduate ? 'Update Record' : 'Save Graduate' }}
                        </flux:button>
                    @endif
                </div>
            </div>
        </form>
    </flux:modal>

</div>