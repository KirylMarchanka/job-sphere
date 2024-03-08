<?php

namespace App\Models;

use App\Components\Employer\Job\Enums\JobEducationEnum;
use App\Components\Employer\Job\Enums\JobExperienceEnum;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }

    protected function experience(): Attribute
    {
        return Attribute::make(get: fn(?int $experience) => null === $experience ? null : JobExperienceEnum::translations($experience));
    }

    protected function education(): Attribute
    {
        return Attribute::make(get: fn(?int $education) => null === $education ? null : JobEducationEnum::translations($education));
    }

    protected function schedule(): Attribute
    {
        return Attribute::make(get: fn(int $schedule) => ScheduleEnum::translations($schedule));
    }

    protected function employment(): Attribute
    {
        return Attribute::make(get: fn(int $employment) => EmploymentEnum::translations($employment));
    }
}
