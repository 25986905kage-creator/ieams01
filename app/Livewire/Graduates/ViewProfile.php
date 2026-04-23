<?php

namespace App\Livewire\Graduates;

use App\Models\Graduate;
use App\Models\AcademicRecord;
use App\Models\AlumniEngagement;
use App\Models\Employment;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Livewire\Forms\Graduate\GraduateCreateForm;
use App\Livewire\Forms\Graduate\AcademicRecordForm;
use App\Livewire\Forms\Graduate\EmploymentForm;
use App\Livewire\Forms\Graduate\AlumniEngagementForm;

class ViewProfile extends Component
{
    public GraduateCreateForm $form;                            // The GraduateCreateForm object
    public AcademicRecordForm $academicForm;                    // The AcademicRecordForm object
    public EmploymentForm $employmentForm;                      // The EmploymentdForm object
    public AlumniEngagementForm $crmForm;                       // The EmploymentdForm object
    public bool $showProfileModal = false;
    public ?int $graduateId = null;
    public ?int $acadmicId = null;
    public bool $isEditing = false;                             // Track if the form is in edit mode
    public string $activeTab = 'demographics';                  // Track our custom tabs
    
    // ViewProfile class properties to toggle inline forms
    public bool $isEditingGraduate = false;
    public bool $isEditingDemographics = false;
    public bool $isAddingAcademic = false;
    public bool $isAddingEmployment = false;
    public bool $isEditingCRM = false;
    public bool $isEditingEmployment = false;

    public function mount($id = null)
    {
        if($id)
        { 
            $this->loadProfile($id);
        }
        // Livewire 3+ handles the instantiation of Form objects automatically 
        // if they are public properties, but if you hit this error, 
        // manually instantiating it here is the safest fallback.
        $this->form = new GraduateCreateForm($this, 'form');
        $this->academicForm = new AcademicRecordForm($this, 'academicForm');
        $this->employmentForm = new EmploymentForm($this, 'employmentForm');
        $this->crmForm = new AlumniEngagementForm($this, 'crmForm');
    }

    #[On('view-graduate')]
    public function loadProfile($id)
    {
        $this->graduateId = $id;
        $this->academicId = $id;
        $this->academicForm->graduate_id = $id;
        $this->employmentForm->graduate_id = $id;
        $this->crmForm->graduate_id = $id;
        $this->isEditing = false;
        $this->activeTab = 'demographics';

        $this->isEditingDemographics = false;
        $this->isAddingAcademic = false;
        $this->isAddingEmployment = false;
        $this->isEditingCRM = false;

        // This loads the graduate and its relationships
        // $graduate = $this->graduate;

        // 1. Fetch the data using the $id passed from the event/mount
        $this->graduate = Graduate::with(['employments', 'academicRecords', 'alumniEngagement'])
            ->findOrFail($id);

        // 2. Pre-fill your CRM Form if data exists
        if ($this->graduate->alumniEngagement) {
            $this->crmForm->setEngagement($this->graduate->alumniEngagement);
            $this->isEditingCRM = false;
        } else {
            // Issue (ii) fix: If fresh DB, default to editing mode
            $this->isEditingCRM = true; 
        }
        
        // Now that the ID is set, the Computed property "graduate" will work
        if($this->graduate){    
            $this->form->setGraduate($this->graduate);
        }

        // Load existing CRM data if it exists
        if($this->graduate->alumniEngagement) {
            $this->crmForm->setEngagement($this->graduate->alumniEngagement);
        } else {
            $this->crmForm->reset(['personal_email', 'primary_mobile_number', 'primary_social_media', 'wants_to_join_alumni']);
        }

        $this->showProfileModal = true;
    }

    #[Computed]
    public function graduate()
    {
        return Graduate::with([
            'academicRecords',
            'employments',
            'universityExperience',
            'feedbackSkills', 
            'alumniEngagement',
        ])->find($this->graduateId);
    }

    public function editDemographics()
    {
        // Instead of manual assignment, use the method already in your Form Object
        if ($this->graduate) {
            $this->form->setGraduate($this->graduate);
        }

        // Now trigger the UI switch
        $this->isEditingDemographics = true;
    }

    public function addAcademic()
    {
        $this->academicForm->reset();                          // Clear old data
        $this->academicForm->setAcademic($this->graduate->id); // Link to current graduate
        $this->isAddingAcademic = true;
    }

    public function editAcademic($id)
    {
        $this->academicForm->edit($id);
        $this->isAddingAcademic = true;
    }

    public function addEmployment()
    {
        $this->employmentForm->reset();                          // Clear old data
        $this->employmentForm->setGraduate($this->graduate->id); // Link to current graduate
        $this->isAddingEmployment = true;
    }

    public function editEmployment($id)
    {
        $this->employmentForm->edit($id);
        $this->isAddingEmployment = true;
    }

    // Optional: Add cancel methods if you want a "Stop Editing" button
    public function cancelAcademicEdit() { $this->academicForm->reset(['id', 'degree_type', 'award_type', 'graduated_in_year', 'uni_start_date', 'uni_end_date']); }
    public function cancelEmploymentEdit() { $this->employmentForm->reset(['id', 'employment_status', 'job_title', 'job_location_type', 'industry_sector', 'entrepreneurial_intent', 'job_securing_year']); }

    // Methods to "Open" the forms for fresh records
    public function startNewAcademic() { $this->academicForm->reset(); $this->isAddingAcademic = true; }
    public function startNewEmployment() { $this->employmentForm->reset(); $this->isAddingEmployment = true; }

    // Add cancel methods to hide forms
    public function cancelGraduate() { $this->isAddingGraduate = false; $this->form->reset(); }
    public function cancelAcademic() { $this->isAddingAcademic = false; $this->academicForm->reset(); }
    public function cancelEmployment() { $this->isAddingEmployment = false; $this->employmentForm->reset(); }

    public function save()
    {
        $this->form->update();

        $this->isEditing = false;
        unset($this->graduate);                 // Reset the UI data

        $this->dispatch(
            'toast', 
            variant: 'success', 
            heading: 'Saved', 
            text: 'Graduate record updated.'
        );
    }

    public function saveDemographics()
    {
        $this->form->update();                  // GraduateForm object save logic
        $this->isEditingDemographics = false;
        $this->graduate->refresh();
        $this->cancelGraduate();

        $this->dispatch(
            'toast', 
            variant: 'success', 
            heading: 'Updated', 
            text: 'Demographics updated successfully.');
    }

    public function saveAcademicRecord()
    {
        // Force the form to use the ID currently stored in the component
        $this->academicForm->graduate_id = $this->graduateId;
        $this->academicForm->store();
        $this->isAddingAcademic = false;

        // Unset the computer property so the UI fetches the fresh DB data
        unset($this->graduate);

        $this->dispatch(
            'toast', 
            variant: 'success', 
            heading: 'Added', 
            text: 'Academic record added successfully.'
        );
    }

    public function saveEmployment()
    {
        $this->employmentForm->graduate_id = $this->graduateId;     // Safety first!
        $this->employmentForm->store();

        $this->isAddingEmployment = false;

        unset($this->graduate);

        $this->dispatch('toast', 
            variant: 'success', 
            heading: 'Employment Updated', 
            text: 'Job record added successfully.'
        );
    }

    public function saveCRM()
    {
        $this->crmForm->graduate_id = $this->graduateId;
        $this->crmForm->store();

        unset($this->graduate);
        $this->dispatch('toast', 
            variant: 'success', 
            heading: 'Contact Updated', 
            text: 'The alumni engagement details have been saved.'
        );
    }

    public function deleteAcademic($id)
    {
        AcademicRecord::findOrFail($id)->delete();
        
        // Refresh the graduate object to update the list
        unset($this->graduate);
        
        $this->dispatch('toast', variant: 'success', heading: 'Deleted', text: 'Academic record removed.');
    }

    public function deleteEmployment($id)
    {
        Employment::findOrFail($id)->delete();
        
        // Refresh the graduate object to update the list
        unset($this->graduate);
        
        $this->dispatch('toast', variant: 'success', heading: 'Deleted', text: 'Employment record removed.');
    }

    public function render()
    {
        return view('livewire.graduates.view-profile');
    }
}