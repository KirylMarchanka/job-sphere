<?php

namespace App\Models;

use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use App\Components\Resume\Enums\StatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'status', 'salary', 'employment', 'schedule', 'description'];

    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(Specialization::class);
    }

    public function contact(): HasOne
    {
        return $this->hasOne(ResumeContact::class);
    }

    public function personalInformation(): HasOne
    {
        return $this->hasOne(ResumePersonalInformation::class);
    }

    public function workExperience(): HasMany
    {
        return $this->hasMany(ResumeWorkExperience::class)->orderByDesc('from');
    }

    public function education(): HasMany
    {
        return $this->hasMany(ResumeEducation::class)->orderByDesc('end_date');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(get: fn(int $status) => StatusEnum::translations($status));
    }

    protected function employment(): Attribute
    {
        return Attribute::make(get: fn(int $employment) => EmploymentEnum::translations($employment));
    }

    protected function schedule(): Attribute
    {
        return Attribute::make(get: fn(int $schedule) => ScheduleEnum::translations($schedule));
    }

    public function getTotalWorkExperienceAttribute(): ?string
    {
        //@todo Вынести в отдельный класс
        /** @var Collection $exp */
        $exp = $this->loadMissing('workExperience')->getRelation('workExperience');

        $months = 0;
        $exp->sortBy('from')->each(function (ResumeWorkExperience $workExperience) use (&$months) {
            $from = Carbon::parse($workExperience->getAttribute('from'));

            if (null === $workExperience->getAttribute('to')) {
                $months += $from->diffInMonths(now());
                return;
            }

            $to = Carbon::parse($workExperience->getAttribute('to'));
            $months += $from->diffInMonths($to);
        });

        return Lang::get('resume.work_exp.total', ['years' => floor($months / 12), 'months' => $months % 12]);
    }
}
