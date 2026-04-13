<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

    #[Fillable([
        'graduate_id',
        'degree_type',
        'award_type',
        'graduate_year',
        ])
    ]

class AcademicRecord extends Model
{
    protected $model = AcademicRecord::class;

    use HasFactory;

    public function graduate(): BelongsTo
    {
        return $this->belongsTo(Graduate::class);
    }
}
