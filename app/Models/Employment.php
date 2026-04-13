<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
        'graduate_id',
        'employment_status',
        'job_title',
        'job_location_type',
        'industry_sector',
        'entrepreneurial_intent',
        'job_securing_date',
    ])
]

class Employment extends Model
{
    use HasFactory;
    
    protected $casts = [
        'job_securing_date' => 'date',
    ];

    public function graduate(): BelongsTo
    {
        return $this->belongsTo(Graduate::class);
    }
}
