<?php

namespace App\Livewire\Forms\Graduate;

use App\Models\AcademicRecord;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AcademicRecordForm extends Form
{
    public ?int $id = null;                         // Track which record is being edited 
    public ?int $graduate_id = null;
    public ?int $academic_id = null;

    #[Validate('required|string|max:255')]
    public string $degree_type = '';

    #[Validate('required|string|max:255')]
    public string $award_type = '';

    #[Validate('required|date')]
    public string $graduated_in_year = ''; 

    #[Validate('nullable|date')]
    public ?string $uni_start_date = null;

    #[Validate('nullable|date')]
    public ?string $uni_end_date = null;

    public function setAcademic(Academic $academic)
    {
        $this->academic = $academic;
        $this->id = $academic->graduate_id;

        $this->fill($academic->only([
            'degree_type', 'award_type', 'graduated_in_year'
        ]));

        if($academic->uni_start_date){
            $this->uni_start_date = $academic->uni_start_date->format('Y-m-d');
        }

        if($academic->uni_end_date){
            $this->uni_end_date = $academic->uni_end_date->format('Y-m-d');
        }
    }

    public function edit($id)
    {
        $record = AcademicRecord::findOrFail($id);

        $this->id = $record->id;
        $this->degree_type = $record->degree_type;
        $this->award_type = $record->award_type;
        $this->graduated_in_year = $record->graduated_in_year?->format('Y-m-d');
        $this->uni_start_date = $record->uni_start_date?->format('Y-m-d');
        $this->uni_end_date = $record->uni_end_date?->format('Y-m-d');
    }

    public function store()
    {
        $this->validate();

        $data = [
            'graduate_id' => $this->graduate_id,
            'degree_type' => $this->degree_type,
            'award_type' => $this->award_type,
            'graduated_in_year' => $this->graduated_in_year,
            'uni_start_date' => $this->uni_start_date,
            'uni_end_date' => $this->uni_end_date,
        ];

        if($this->id){
            AcademicRecord::find($this->id)->update($data);
        } else {
            AcademicRecord::create($data);
        }

        // Reset all fields except graduate_id so the user can easily add a second degree
        $this->reset(['id', 'degree_type', 'award_type', 'graduated_in_year', 'uni_start_date', 'uni_end_date']); 
    }

}