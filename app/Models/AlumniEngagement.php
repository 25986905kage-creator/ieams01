<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
'graduate_id',
        'aware_of_alumni_assoc',
        'wants_to_join_alumni',
        'personal_email',
        'work_email',
        'postal_address',
        'primary_mobile_number',
        'secondary_mobile_number',
        'landline_number',
        'primary_social_media',
        'secondary_social_media',
        'tertiary_social_media',
    ])
]

class AlumniEngagement extends Model
{
    use HasFactory;

    protected $casts = [
        'aware_of_alumni_assoc' => 'boolean',
        'wants_to_join_alumni' => 'boolean',
    ];

    public function graduate(): BelongsTo
    {
        return $this->belongsTo(Graduate::class);
    }
}
