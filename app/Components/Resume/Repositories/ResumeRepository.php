<?php

namespace App\Components\Resume\Repositories;

use App\Components\Resume\DTOs\ResumeContactDto;
use App\Components\Resume\DTOs\ResumeDto;
use App\Components\Resume\DTOs\ResumeEducationDto;
use App\Components\Resume\DTOs\ResumePersonalInformationDto;
use App\Components\Resume\DTOs\ResumeSkillDto;
use App\Components\Resume\DTOs\ResumeSpecializationDto;
use App\Components\Resume\DTOs\ResumeWorkExperienceDto;
use App\Models\Resume;
use App\Models\User;

class ResumeRepository
{
    private User $user;

    //@todo Статистика? Кол-во просмотров, показов, откликов
    public function all(): array
    {
        return $this->user->resumes()
            ->select(['id', 'title', 'status', 'updated_at'])
            ->orderBy('status')
            ->orderBy('updated_at')
            ->get()
            ->toArray();
    }

    public function find(string $id): ?array
    {
        return $this->user->resumes()->with([
            'specializations:id,name',
            'contact',
            'skills:id,name',
            'personalInformation',
            'personalInformation.city',
            'personalInformation.city.country',
            'workExperiences',
            'workExperiences.city',
            'workExperiences.city.country',
            'education',
            'education.educationalInstitution',
            'education.educationalInstitution.city',
            'education.educationalInstitution.city.country',
        ])->where('id', $id)->first()?->append(['totalWorkExperience'])->toArray();
    } // @todo Знание языков (?), Прикрепление фото (?)

    /**
     * @param ResumeDto $resume
     * @param array<ResumeSpecializationDto> $specializations
     * @param array<ResumeSkillDto> $skills
     * @param ResumeContactDto $contact
     * @param ResumePersonalInformationDto $personalInformation
     * @param array<ResumeEducationDto> $education
     * @param array<ResumeWorkExperienceDto> $workExperience
     *
     * @return Resume
     */
    public function store(
        ResumeDto $resume,
        array $specializations,
        array $skills,
        ResumeContactDto $contact,
        ResumePersonalInformationDto $personalInformation,
        array $education,
        array $workExperience
    ): Resume
    {
        /** @var Resume $resumeModel */
        $resumeModel = $this->user->resumes()->create($resume->toArray());
        if (!empty($specializations)) {
            $resumeModel->specializations()->attach(array_map(fn(ResumeSpecializationDto $specialization) => $specialization->id, $specializations));
        }

        if (!empty($skills)) {
            $resumeModel->skills()->attach(array_map(fn(ResumeSkillDto $skill) => $skill->id, $skills));
        }

        $resumeModel->contact()->create($contact->toArray());
        $resumeModel->personalInformation()->create($personalInformation->toArray());
        $resumeModel->education()->createMany(array_map(fn(ResumeEducationDto $educationValue) => $educationValue->toArray(), $education));

        if (!empty($workExperience)) {
            $resumeModel->workExperiences()->createMany(array_map(fn(ResumeWorkExperienceDto $workExperienceValue) => $workExperienceValue->toArray(), $workExperience));
        }

        return $resumeModel;
    }

    /**
     * @param int $resumeId
     * @param ResumeDto $resume
     * @param array<ResumeSpecializationDto>|null $specializations
     * @param array<ResumeSkillDto>|null $skills
     * @param ResumeContactDto|null $contact
     * @param ResumePersonalInformationDto|null $personalInformation
     * @param array<ResumeEducationDto>|null $education
     * @param array<ResumeWorkExperienceDto>|null $workExperience
     *
     * @return void
     */
    public function update(
        int                           $resumeId,
        ResumeDto                     $resume,
        ?array                        $specializations,
        ?array                        $skills,
        ?ResumeContactDto             $contact,
        ?ResumePersonalInformationDto $personalInformation,
        ?array                        $education,
        ?array                        $workExperience,
    ): void
    {
        /** @var Resume $resumeModel */
        $resumeModel = $this->user->resumes()
            ->where('id', $resumeId)
            ->first();

        $resumeModel->update($resume->toArray());

        if (null !== $specializations) {
            $resumeModel->specializations()->sync(array_map(fn(ResumeSpecializationDto $specialization) => $specialization->id, $specializations));
        }

        if (null !== $skills) {
            $resumeModel->skills()->sync(array_map(fn(ResumeSkillDto $skill) => $skill->id, $skills));
        }

        if (null !== $contact) {
            $resumeModel->contact()->update($contact->toArray());
        }

        if (null !== $personalInformation) {
            $resumeModel->personalInformation()->update($personalInformation->toArray());
        }

        if (null !== $education) {
            foreach ($education as $value) {
                if (null === $value->id) {
                    $resumeModel->education()->create($value->toArray());
                    continue;
                }

                $resumeModel->education()->where('id', $value->id)->update($value->toArray());
            }
        }

        if (null !== $workExperience) {
            foreach ($workExperience as $value) {
                if (null === $value->id) {
                    $resumeModel->workExperiences()->create($value->toArray());
                    continue;
                }

                $resumeModel->workExperiences()->where('id', $value->id)->update($value->toArray());
            }
        }
    }

    public function delete(int $resumeId): void
    {
        $this->user->resumes()->where('id', $resumeId)->delete();
    }

    public function setUser(User $user): ResumeRepository
    {
        $this->user = $user;
        return $this;
    }
}
