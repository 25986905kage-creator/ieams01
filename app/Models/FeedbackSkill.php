<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class FeedbackSkill extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'sat_teaching_quality' => 'integer',
        'sat_faculty_interaction' => 'integer',
        'sat_career_assistance' => 'integer',
        'sat_employment_assistance' => 'integer',
        'sat_faculty_mentorship' => 'integer',
        'exp_oral_presentation' => 'integer',
        'exp_problem_solving' => 'integer',
        'exp_practical_learning' => 'integer',
        'exp_innovation_modeling' => 'integer',
        'impact_communication' => 'integer',
        'impact_problem_solving' => 'integer',
        'impact_teamwork' => 'integer',
        'impact_tech_knowledge' => 'integer',
        'exp_industry_networking' => 'integer',
        'exp_alumni_networking' => 'integer',
    ];

    protected $fillable = [
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
    ];

    public function graduate(): BelongsTo
    {
        return $this->belongsTo(Graduate::class);
    }
}
