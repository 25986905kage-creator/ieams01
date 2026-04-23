<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

class Graduate extends Model
{
    use HasFactory;

    // Guarding 'id' is a standard practice, allowing mass assignment for other fields
    protected $guarded = ['id'];

    // Cast dates to Carbon instances for easy manipulation
    protected $casts = [
        'birth_date' => 'date',
        'graduated_in_year' => 'date',
        'is_first_gen_family' => 'boolean',
        'is_first_gen_village' => 'boolean',
    ];

    protected $fillable = [
    'student_number', 
    'first_name', 
    'last_name',
    'name_used_at_uni',
    'birth_date',
    'gender', 
    'nationality', 
    'pob_country', 
    'home_province', 
    'pre_uni_city', 
    'previous_school_name', 
    'father_education_level', 
    'mother_education_level',
    'is_first_gen_family', 
    'is_first_gen_village'
    ];

    /**
     * Get the graduate's full name.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->first_name} {$this->last_name}",
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function academicRecords(): HasMany
    {
        return $this->hasMany(AcademicRecord::class);
    }

    public function employments(): HasMany
    {
        // One-to-Many allows tracking a graduate's job history over time
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

      /*
    |--------------------------------------------------------------------------
    | Accessor Method(s) to call $graduate->graduation_year directly.
    |--------------------------------------------------------------------------
    */

    protected function graduationYear(): Attribute
    {
        return Attribute::make(
            get: function () {
                $record = $this->academicRecords->sortByDesc('graduated_in_year')->first();
                
                // If a record exists and has a date, format it to just the year here.
                if ($record && $record->graduated_in_year) {
                    return $record->graduated_in_year->format('Y');
                }
                
                return 'N/A';
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | BI Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include graduates from a specific nationality.
     */
    public function scopeOfNationality(Builder $query, string $nationality): Builder
    {
        return $query->where('nationality', $nationality);
    }

    /**
     * Scope a query to include only first-generation university students.
     */
    public function scopeFirstGeneration(Builder $query): Builder
    {
        return $query->where('is_first_gen_family', true)
                     ->orWhere('is_first_gen_village', true);
    }
}

?>
