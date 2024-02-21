<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EducationalInstitution extends Model
{
    use HasFactory;

    public function resumeEducation(): HasMany
    {
        return $this->hasMany(ResumeEducation::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
