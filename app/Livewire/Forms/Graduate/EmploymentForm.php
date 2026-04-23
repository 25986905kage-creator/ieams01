<?php

namespace App\Livewire\Forms\Graduate;

use App\Models\Employment;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EmploymentForm extends Form
{
    public ?int $id = null;
    public ?int $graduate_id = null;

    #[Validate('required|string')]
    public string $employment_status = '';

    #[Validate('nullable|string|max:255')]
    public string $job_title = '';

    #[Validate('nullable|string')]
    public string $job_location_type = '';

    #[Validate('nullable|string')]
    public string $industry_sector = '';

    #[Validate('nullable|string')]
    public string $entrepreneurial_intent = '';

    #[Validate('nullable|date')]
    public ?string $job_securing_year = null;

    // Use this when opening the "Add" form
    public function setGraduate($graduateId)
    {
        $this->graduate_id = $graduateId;
    }

    public function edit($id)
    {
        $job = Employment::findOrFail($id);
        
        $this->id = $job->id;
        $this->graduate_id = $job->graduate_id; // Added this!
        $this->employment_status = $job->employment_status;
        $this->job_title = $job->job_title ?? '';
        $this->job_location_type = $job->job_location_type ?? '';
        $this->industry_sector = $job->industry_sector ?? '';
        $this->entrepreneurial_intent = $job->entrepreneurial_intent ?? '';
        $this->job_securing_year = $job->job_securing_year?->format('Y-m-d');
    }

    public function store()
    {
        $this->validate();

        // Use updateOrCreate to simplify the logic and prevent ID mismatches
        Employment::updateOrCreate(
            ['id' => $this->id],
            [
                'graduate_id' => $this->graduate_id,
                'employment_status' => $this->employment_status,
                'job_title' => $this->job_title,
                'job_location_type' => $this->job_location_type,
                'industry_sector' => $this->industry_sector,
                'entrepreneurial_intent' => $this->entrepreneurial_intent,
                'job_securing_year' => $this->job_securing_year,
            ]
        );

        // Reset everything EXCEPT the graduate_id, 
        // so the form stays linked to this user for the next entry
        $this->reset(['id', 'employment_status', 'job_title', 'job_location_type', 'industry_sector', 'entrepreneurial_intent', 'job_securing_year']);
    }
}