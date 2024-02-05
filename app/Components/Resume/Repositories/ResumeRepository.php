<?php

namespace App\Components\Resume\Repositories;

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
            'workExperience',
            'workExperience.city',
            'workExperience.city.country',
            'education',
            'education.educationalInstitution',
            'education.educationalInstitution.city',
            'education.educationalInstitution.city.country',
        ])->where('id', $id)->first()?->append(['totalWorkExperience'])->toArray();
    } // @todo Знание языков (?), Прикрепление фото (?)

    public function setUser(User $user): ResumeRepository
    {
        $this->user = $user;
        return $this;
    }
}
