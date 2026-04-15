<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Graduate extends Model
{
    use HasFactory;

    protected $fillable = [
    'id',
    'student_number', 
    'first_name', 
    'last_name', 
    'university_name',
    'course',
    'birth_date',
    'graduation_date',
    'gender', 
    'nationality', 
    'pob_country', 
    'home_province', 
    'pre_uni_city', 
    'previous_school_name', 
    'is_first_gen_family', 
    'is_first_gen_village', 
    'father_education_level', 
    'mother_education_level'
];

    protected $casts = [
        'birth_date' => 'date',
        'graduation_date' => 'date', 
        'is_first_gen_family' => 'boolean',
        'is_first_gen_village' => 'boolean',
    ];

    // Assuming a graduate can have multiple academic records
    public function academicRecords(): HasMany
    {
        return $this->hasMany(AcademicRecord::class);
    }

    // Assuming a graduate can have multiple employment history records
    public function employments(): HasMany
    {
        return $this->hasMany(Employment::class);
    }

    public function universityExperience(): HasOne
    {
        return $this->hasOne(UniversityExperience::class);
    }

    public function feedbackSkills(): HasOne
    {
        return $this->hasOne(FeedbackSkill::class);
    }

    public function alumniEngagement(): HasOne
    {
        return $this->hasOne(AlumniEngagement::class);
    }
}
