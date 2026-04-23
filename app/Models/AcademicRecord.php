<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class AcademicRecord extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $model = AcademicRecord::class;

    protected $casts = [
        'graduated_in_year' => 'date',
        'uni_start_date' => 'date',
        'uni_end_date' => 'date'
    ];

    public function graduate(): BelongsTo
    {
        return $this->belongsTo(Graduate::class);
    }

    // BI Scope: Filter by award type (e.g., finding top performers)
    public function scopeWithHonours(Builder $query): Builder
    {
        return $query->where('award_type', 'First Class Honours');
    }
}
