<?php

namespace App\Livewire\Forms\Graduate;

use App\Models\AlumniEngagement;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AlumniEngagementForm extends Form
{
    public ?int $graduate_id = null;

    #[Validate('nullable|email|max:255')]
    public string $personal_email = '';

    #[Validate('nullable|string|max:20')]
    public string $primary_mobile_number = '';

    #[Validate('nullable|string|max:255')]
    public string $primary_social_media = '';

    #[Validate('boolean')]
    public bool $wants_to_join_alumni = false;

    public function store()
    {
        $this->validate();

        // We use updateOrCreate here because usually there is only ONE 
        // engagement record per graduate.
        AlumniEngagement::updateOrCreate(
            ['graduate_id' => $this->graduate_id],
            [
                'personal_email' => $this->personal_email,
                'primary_mobile_number' => $this->primary_mobile_number,
                'primary_social_media' => $this->primary_social_media,
                'wants_to_join_alumni' => $this->wants_to_join_alumni,
            ]
        );
    }

    public function setEngagement(AlumniEngagement $engagement)
    {
        $this->personal_email = $engagement->personal_email ?? '';
        $this->primary_mobile_number = $engagement->primary_mobile_number ?? '';
        $this->primary_social_media = $engagement->primary_social_media ?? '';
        $this->wants_to_join_alumni = (bool)$engagement->wants_to_join_alumni;
    }
}