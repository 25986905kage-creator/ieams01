<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class AlumniEngagement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'aware_of_alumni_assoc' => 'boolean',
        'wants_to_join_alumni' => 'boolean',
    ];

    public function graduate(): BelongsTo
    {
        return $this->belongsTo(Graduate::class);
    }

    // CRM Scope: Quickly grab lists of people ready to be onboarded
    public function scopePendingMembers(Builder $query): Builder
    {
        return $query->where('wants_to_join_alumni', true);
    }
}
