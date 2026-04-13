<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
        'graduate_id',
        'has_leadership_experience',
        'leadership_role_description',
        'is_student_volunteer',
        'is_education_adequate',
        'rating_employment_potential',
    ])
]

class UniversityExperience extends Model
{
   use HasFactory;

   protected $casts = [
        'has_leadership_experience' => 'boolean',
        'is_student_volunteer' => 'boolean',
        'is_education_adequate' => 'boolean',
    ];

    public function graduate(): BelongsTo
    {
        return $this->belongsTo(Graduate::class);
    }
}
