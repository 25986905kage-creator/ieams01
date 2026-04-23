<?php

namespace App\Livewire\Forms\Graduate;

use Livewire\Attributes\Validate;
use App\Models\Graduate;
use Livewire\Form;
use Carbon\Carbon;

class GraduateCreateForm extends Form
{
    public ?int $id = null; 
    public ?Graduate $graduate = null;

    // --- Header Fields ---
    #[Validate('required|string|max:255')]
    public string $first_name = '';

    #[Validate('required|string|max:255')]
    public string $last_name = '';

    #[Validate('required|string|max:255')]
    public string $student_number = '';

    #[Validate('nullable|string|max:255')]
    public ?string $home_province = '';

    // Demographic fields

    #[Validate('required|string|min:5|max:255')]
    public $name_used_at_uni = '';

    #[Validate('required|string|min:3|max:255')]
    public $gender = '';

    #[Validate('nullable|date')]
    public $birth_date  = null;
    

     #[Validate('required|string|min:5|max:255')]
    public $nationality = '';
    
     #[Validate('required|string|min:5|max:255')]
    public $pob_country = '';
    
    #[Validate('required|string|min:5|max:255')]
    public $home_country = '';
    
     #[Validate('required|string|min:3|max:255')]
    public $pre_uni_city = '';

     #[Validate('required|string|min:5|max:255')]
    public $previous_school_name = '';
    
    #[Validate('boolean')]
    public $is_first_gen_family = false;
    
    #[Validate('boolean')]
    public $is_first_gen_village = false;
    
    #[Validate('required|min:5')]
    public $father_education_level = '';
    
    #[Validate('required|min:5')]
    public $mother_education_level = '';

    public function setGraduate(Graduate $graduate)
    {
        // 1. Store the model for later updates
        $this->graduate = $graduate;
        $this->id = $graduate->id;

        // 2. Bulk assign standard text/select properties
        // (Notice it uses $graduate->only() here)
        $this->fill($graduate->only([
            'first_name', 'last_name', 'student_number', 'home_province',
            'name_used_at_uni', 'gender', 'home_country', 'nationality', 'pob_country',
            'previous_school_name', 'pre_uni_city', 'father_education_level', 'mother_education_level'
        ]));
        
        // 3. Handle strict Date formatting for HTML5// Ensure date is formatted for HTML5 input
        if($graduate->birth_date) {
            $this->birth_date = $graduate->birth_date->format('Y-m-d');
        }

        // 4. Handle Boolean casting for checkboxes
        $this->is_first_gen_family = (bool) $graduate->is_first_gen_family;
        $this->is_first_gen_village = (bool) $graduate->is_first_gen_village;
    }

    public function edit($id)
    {
        $demographicDetail = Graduate::findOrFail($id);

        $this->id = $demographicDetail->id;

        $this->student_number = $demographicDetail-> student_number;
        $this->first_name = $demographicDetail->first_name;
        $this->last_name = $demographicDetail->last_name;
        $this->name_used_at_uni = $demographicDetail->name_used_at_uni;
        $this->birth_date = $demographicDetail->birth_date;
        $this->gender = $demographicDetail->gender;
        $this->nationality = $demographicDetail->nationality;
        $this->pob_country = $demographicDetail->pob_country; 
        $this->home_province = $demographicDetail->home_country;
        $this->pre_uni_city = $demographicDetail->pre_uni_city;
        $this->previous_school_name = $demographicDetail->previous_school_name;
        $this->father_education_level = $demographicDetail->father_education_level; 
        $this->mother_education_level = $demographicDetail->mother_education_level;
        $this->is_first_gen_family = (bool) $demographicDetail->is_first_gen_family;
        $this->is_first_gen_village = (bool) $demographicDetail->is_first_gen_village;
    }

    public function update()
    {
        // Triggers the #[Validate] attributes natively in Livewire 4
        $validateData = $this->validate();
        
        $this->graduate->update($validateData);
    }

    public function store()
    {
        
        $this->validate();

        $graduate = Graduate::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'student_number' => $this->student_number,
            'home_province' => $this->home_province,
            'home_country' => $this->home_country,
            'name_used_at_uni' => $this->name_used_at_uni,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'nationality' => $this->nationality,
            'pob_country' => $this->pob_country,
            'previous_school_name' => $this->previous_school_name,
            'pre_uni_city' => $this->pre_uni_city,
            'is_first_gen_family' => $this->is_first_gen_family,
            'is_first_gen_village' => $this->is_first_gen_village,
            'father_education_level' => $this->father_education_level,
            'mother_education_level' => $this->mother_education_level,
        ]);

        // Reset the form so it's clean for the next entry
        $this->reset(); 

        return $graduate;
    }

    
}

