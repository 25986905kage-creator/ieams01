<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AcademicRecord extends Model
{

    protected $fillable = [
        'graduate_id',
        'degree_type',
        'award_type',
        'start_date',
        'end_date',
        'graduation_year',
    ];

    protected $model = AcademicRecord::class;

    use HasFactory;

    public function graduate(): BelongsTo
    {
        return $this->belongsTo(Graduate::class);
    }
}
