<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
        'graduate_id',
        'sat_teaching_quality',
        'sat_faculty_interaction',
        'sat_career_assistance',
        'sat_employment_assistance',
        'sat_faculty_mentorship',
        'exp_oral_presentation',
        'exp_problem_solving',
        'exp_practical_learning',
        'exp_innovation_modeling',
        'impact_communication',
        'impact_problem_solving',
        'impact_teamwork',
        'impact_tech_knowledge',
        'exp_industry_networking',
        'exp_alumni_networking',
    ])
]

class FeedbackSkill extends Model
{
    use HasFactory;
    
    public function graduate(): BelongsTo
    {
        return $this->belongsTo(Graduate::class);
    }
}
