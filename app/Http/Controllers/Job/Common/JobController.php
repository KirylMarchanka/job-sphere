<?php

namespace App\Http\Controllers\Job\Common;

use App\Components\City\Repositories\CityRepository;
use App\Components\Employer\Job\DTO\PaginateFiltersDto;
use App\Components\Employer\Job\Enums\JobEducationEnum;
use App\Components\Employer\Job\Enums\JobExperienceEnum;
use App\Components\Employer\Job\Repositories\JobRepository;
use App\Components\Employer\Sector\Repositories\SectorRepository;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use App\Components\Resume\Repositories\ResumeRepository;
use App\Components\Skill\Repositories\SkillRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Job\Common\JobIndexRequest;
use App\Models\City;
use App\Models\Employer;
use App\Models\EmployerJob;
use App\Models\Skill;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(
        JobIndexRequest  $request,
        JobRepository    $jobRepository,
        SectorRepository $sectorRepository,
        CityRepository   $cityRepository,
        SkillRepository  $skillRepository,
    ): View
    {
        $jobs = $jobRepository->paginate(
            new PaginateFiltersDto(
                title: $request->input('title'),
                isArchived: false,
                sector: $request->input('sector'),
                city: $request->input('city'),
                salaryFrom: $request->input('salary_from'),
                salaryTo: $request->input('salary_to'),
                education: $request->whenFilled('education', fn(int $education) => JobEducationEnum::from($education), fn() => null),
                employment: $request->whenFilled('employment', fn(int $employment) => EmploymentEnum::from($employment), fn() => null),
                experience: $request->whenFilled('experience', fn(int $experience) => JobExperienceEnum::from($experience), fn() => null),
                schedule: $request->whenFilled('schedule', fn(int $schedule) => ScheduleEnum::from($schedule), fn() => null),
                skills: $request->input('skills'),
            ),
            $request->integer('page', 1),
            $request->integer('per_page', 10)
        );

        return view('employers.jobs.index', [
            'jobs' => $jobs,
            'sectors' => $sectorRepository->all(),
            'cities' => $cityRepository->all(),
            'education' => JobEducationEnum::toArray(),
            'employment' => EmploymentEnum::toArray(),
            'experience' => JobExperienceEnum::toArray(),
            'schedule' => ScheduleEnum::toArray(),
            'skills' => $skillRepository->all(),
            'data' => $request->toArray(),
        ]);
    }

    public function show(Request $request, Employer $employer, EmployerJob $job, ResumeRepository $resumeRepository): View
    {
        return view('employers.jobs.show', [
            'employer' => $employer,
            'job' => $job->load(['city.country', 'skills'])->toArray(),
            'previousPage' => $this->getPreviousPage($request->headers->get('referer')),
            'resumes' => $request->user('web.users') ? $resumeRepository->setUser($request->user('web.users'))->getResumesForJobApply($job->getKey()) : collect(),
        ]);
    }

    private function getPreviousPage(?string $referer): int
    {
        if (null === $referer) {
            return 1;
        }

        $parsed = parse_url($referer);
        if (!array_key_exists('query', $parsed)) {
            return 1;
        }

        $result = [];
        parse_str($parsed['query'], $result);
        if (!array_key_exists('page', $result)) {
            return 1;
        }

        return intval($result['page']);
    }
}
