<?php

namespace App\Components\Resume\Repositories;

use App\Components\Resume\Contacts\Enums\ResumeContactPreferredContactEnum;
use App\Components\Resume\Contacts\Helpers\ResumeContactPreferredValueChecker;
use App\Components\Resume\DTOs\ResumeContactDto;
use App\Components\Resume\DTOs\ResumeDto;
use App\Components\Resume\DTOs\ResumeEducationDto;
use App\Components\Resume\DTOs\ResumePersonalInformationDto;
use App\Components\Resume\DTOs\ResumeSkillDto;
use App\Components\Resume\DTOs\ResumeSpecializationDto;
use App\Components\Resume\DTOs\ResumeWorkExperienceDto;
use App\Models\Resume;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ResumeRepository
{
    private readonly User $user;
    private readonly ResumeContactPreferredValueChecker $contactPreferredValueChecker;

    public function __construct(ResumeContactPreferredValueChecker $contactPreferredValueChecker)
    {
        $this->contactPreferredValueChecker = $contactPreferredValueChecker;
    }

    public function paginate(array $data): array
    {
        return Resume::query() //@todo Вынести фильтры в классы
            ->select(['id', 'title', 'status', 'salary', 'employment', 'schedule'])
            ->with('workExperiences')
            ->when(isset($data['title']), function (Builder $builder) use ($data) {
                return $builder->where('title', 'like', "%{$data['title']}%");
            })
            ->when(isset($data['isset_salary']), function (Builder $builder) {
                return $builder->whereNotNull('salary');
            })
            ->when(isset($data['salary_from']), function (Builder $builder) use ($data) {
                return $builder->where('salary', '>=', $data['salary_from']);
            })
            ->when(isset($data['salary_to']), function (Builder $builder) use ($data) {
                return $builder->where('salary', '<=', $data['salary_to']);
            })
            ->when(isset($data['employment']), function (Builder $builder) use ($data) {
                return $builder->whereIn('employment', $data['employment']);
            })
            ->when(isset($data['schedule']), function (Builder $builder) use ($data) {
                return $builder->whereIn('schedule', $data['schedule']);
            })
            ->when(isset($data['education_degree']), function (Builder $builder) use ($data) {
                return $builder->whereHas('education', function (Builder $builder) use ($data) {
                    return $builder->whereIn('degree', $data['education_degree']);
                });
            })
            ->when(isset($data['specializations']), function (Builder $builder) use ($data) {
                return $builder->whereHas('specializations', function (Builder $builder) use ($data) {
                    return $builder->whereIn('specialization_id', $data['specializations']);
                });
            })
            ->when(isset($data['skills']), function (Builder $builder) use ($data) {
                return $builder->whereHas('skills', function (Builder $builder) use ($data) {
                    return $builder->whereIn('skill_id', $data['skills']);
                });
            })
            ->when(isset($data['city']), function (Builder $builder) use ($data) {
                return $builder->whereHas('personalInformation', function (Builder $builder) use ($data) {
                    return $builder->whereIn('city_id', $data['city']);
                });
            })
            ->when(isset($data['years_from']), function (Builder $builder) use ($data) {
                return $builder->whereHas('personalInformation', function (Builder $builder) use ($data) {
                    return $builder->where('birthdate', '>=', Carbon::parse($data['years_from'])->diffInYears(now()));
                });
            })
            ->when(isset($data['years_to']), function (Builder $builder) use ($data) {
                return $builder->whereHas('personalInformation', function (Builder $builder) use ($data) {
                    return $builder->where('birthdate', '<=', Carbon::parse($data['years_to'])->diffInYears(now()));
                });
            })
            ->when(isset($data['work_experience']), function (Builder $builder) use ($data) {
                return $builder->whereHas('workExperiences', function (Builder $builder) use ($data) {
                    return $builder->whereRaw('(SELECT SUM(TIMESTAMPDIFF(MONTH, `from`, IFNULL(`to`, NOW()))) FROM resume_work_experiences WHERE resume_id = resumes.id) >= ?', [(int)$data['work_experience']]);
                });
            })
            ->orderByDesc('updated_at')
            ->paginate()
            ->through(fn(Resume $resume) => $resume->append('total_work_experience')->makeHidden('workExperiences')->toArray())
            ->toArray();
    }

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

        if (!$this->contactPreferredValueChecker->checkFillings(null, $contact->toArray())) {
            $contact->preferredContactSource = ResumeContactPreferredContactEnum::MOBILE_NUMBER;
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
