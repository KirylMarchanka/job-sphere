<?php

namespace App\Components\Resume\Helpers\DtoFillers;

use App\Components\Resume\DTOs\ResumeEducationDto;
use App\Components\Resume\Education\Enums\DegreeEnum;
use App\Models\Resume;
use Carbon\Carbon;

class ResumeEducationDtoFiller
{
    /**
     * @param Resume $resume
     * @param array|null $education
     * @return array<ResumeEducationDto>|null
     */
    public static function fill(Resume $resume, ?array $education): ?array
    {
        if (empty($education)) {
            return null;
        }

        $resumeEducation = $resume->loadMissing('education')->getRelation('education');

        return array_filter(array_map(function (array $education) use ($resumeEducation) {
            if (isset($education['id']) && $resumeEducation->where('id', $education['id'])->isEmpty()) {
                return null;
            }

            if (!isset($education['id'])) {
                return new ResumeEducationDto(
                    $education['educational_institution_id'],
                    $education['department'],
                    $education['specialization'],
                    DegreeEnum::from($education['degree']),
                    Carbon::parse($education['start_date']),
                    Carbon::parse($education['end_date']),
                );
            }

            $currentResumeEducation = $resumeEducation->where('id', $education['id'])->first();

            return new ResumeEducationDto(
                $education['educational_institution_id'] ?? $currentResumeEducation->getAttribute('educational_institution_id'),
                $education['department'] ?? $currentResumeEducation->getAttribute('department'),
                $education['specialization'] ?? $currentResumeEducation->getAttribute('specialization'),
                DegreeEnum::from($education['degree'] ?? $currentResumeEducation->getRawOriginal('degree')),
                Carbon::parse($education['start_date'] ?? $currentResumeEducation->getRawOriginal('start_date')),
                Carbon::parse($education['end_date'] ?? $currentResumeEducation->getRawOriginal('end_date')),
                $currentResumeEducation->getAttribute('id'),
            );
        }, $education));
    }
}
