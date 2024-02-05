<?php

namespace App\Models;

use App\Components\Resume\Education\Enums\DegreeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeEducation extends Model
{
    use HasFactory;

    protected $casts = [
        'start_date' => 'date:Y-m',
        'end_date' => 'date:Y-m',
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }

    public function educationalInstitution(): BelongsTo
    {
        return $this->belongsTo(EducationalInstitution::class);
    }

    protected function degree(): Attribute
    {
        return Attribute::make(get: fn(int $value) => DegreeEnum::translations($value));
    }
}
