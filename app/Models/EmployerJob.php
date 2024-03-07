<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EmployerJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'salary_from',
        'salary_to',
        'salary_employer_paid_taxes',
        'experience',
        'education',
        'schedule',
        'description',
        'city_id',
        'street',
        'employment',
        'is_archived',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }
}
