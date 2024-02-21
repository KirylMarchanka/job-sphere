<?php

namespace App\Components\Resume\Helpers\DtoFillers;

use App\Components\Resume\DTOs\ResumeWorkExperienceDto;
use App\Models\Resume;
use Carbon\Carbon;

class ResumeWorkExperienceDtoFiller
{
    /**
     * @param Resume $resume
     * @param array|null $workExperience
     * @return array<ResumeWorkExperienceDto>|null
     */
    public static function fill(Resume $resume, ?array $workExperience): ?array
    {
        if (null === $workExperience) {
            return null;
        }

        $resumeWorkExperience = $resume->loadMissing('workExperiences')->getRelation('workExperiences');

        return array_filter(array_map(function (array $workExperience) use ($resumeWorkExperience) {
            if (isset($workExperience['id']) && $resumeWorkExperience->where('id', $workExperience['id'])->isEmpty()) {
                return null;
            }

            if (!isset($workExperience['id'])) {
                return new ResumeWorkExperienceDto(
                    $workExperience['company_name'],
                    $workExperience['city_id'],
                    $workExperience['position'],
                    $workExperience['site_url'],
                    $workExperience['description'],
                    Carbon::parse($workExperience['from']),
                    null === $workExperience['to'] ? $workExperience['to'] : Carbon::parse($workExperience['to']),
                );
            }

            $currentResumeWorkExperience = $resumeWorkExperience->where('id', $workExperience['id'])->first();

            if (array_key_exists('to', $workExperience)) {
                $to = null === $workExperience['to'] ? null : Carbon::parse($workExperience['to']);
            } else {
                $to = Carbon::parse($currentResumeWorkExperience->getRawOriginal('to'));
            }

            return new ResumeWorkExperienceDto(
                $workExperience['company_name'] ?? $currentResumeWorkExperience->getAttribute('company_name'),
                $workExperience['city_id'] ?? $currentResumeWorkExperience->getAttribute('city_id'),
                $workExperience['position'] ?? $currentResumeWorkExperience->getAttribute('position'),
                $workExperience['site_url'] ?? $currentResumeWorkExperience->getAttribute('site_url'),
                $workExperience['description'] ?? $currentResumeWorkExperience->getAttribute('description'),
                Carbon::parse($workExperience['from'] ?? $currentResumeWorkExperience->getRawOriginal('from')),
                $to,
                $currentResumeWorkExperience->getAttribute('id')
            );
        }, $workExperience));
    }
}
