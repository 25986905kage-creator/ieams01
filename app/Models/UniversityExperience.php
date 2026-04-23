<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class UniversityExperience extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

   protected $casts = [
        'has_leadership_experience' => 'boolean',
        'is_student_volunteer' => 'boolean',
        'is_education_adequate' => 'boolean',
    ];

   protected $fillable = [
        'has_leadership_experience',
        'leadership_role_description',
        'is_student_volunteer',
        'is_education_adequate',
        'rating_employment_potential',
    ];

    public function graduate(): BelongsTo
    {
        return $this->belongsTo(Graduate::class);
    }

    public function scopeLeaders(Builder $query): Builder
    {
        return $query->where('has_leadership_experience', true);
    }
}
