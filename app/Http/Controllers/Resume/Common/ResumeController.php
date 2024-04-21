<?php

namespace App\Http\Controllers\Resume\Common;

use App\Components\City\Repositories\CityRepository;
use App\Components\Employer\Job\Enums\JobEducationEnum;
use App\Components\Employer\Sector\Repositories\SectorRepository;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use App\Components\Resume\Repositories\ResumeRepository;
use App\Components\Skill\Repositories\SkillRepository;
use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResumeController extends Controller
{
    public function index(
        Request $request,
        ResumeRepository $repository,
        CityRepository $cityRepository,
        SkillRepository $skillRepository,
    ): View
    {
        return view('resumes.index', [
            'resumes' => $repository->paginate($request->all()),
            'cities' => $cityRepository->all(),
            'education' => JobEducationEnum::toArray(),
            'employment' => EmploymentEnum::toArray(),
            'schedule' => ScheduleEnum::toArray(),
            'skills' => $skillRepository->all(),
            'data' => $request->toArray(),
        ]);
    }

    public function show(Resume $resume): View
    {
        $resume->load([
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
        ])->append('total_work_experience');

        return view('resumes.show', [
            'resume' => $resume->toArray(),
        ]);
    }
}
