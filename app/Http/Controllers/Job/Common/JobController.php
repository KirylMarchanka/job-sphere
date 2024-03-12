<?php

namespace App\Http\Controllers\Job\Common;

use App\Components\Employer\Job\DTO\PaginateFiltersDto;
use App\Components\Employer\Job\Enums\JobEducationEnum;
use App\Components\Employer\Job\Enums\JobExperienceEnum;
use App\Components\Employer\Job\Repositories\JobRepository;
use App\Components\Responser\Facades\Responser;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Job\Common\JobIndexRequest;
use App\Models\Employer;
use App\Models\EmployerJob;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    public function index(JobIndexRequest $request, Employer $employer, JobRepository $repository): JsonResponse
    {
        $data = $repository->setEmployer($employer)->paginate(
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
            $request->integer('per_page', 15)
        );

        return Responser::wrap(false)->setData($data)->success();
    }

    public function show(Employer $employer, EmployerJob $job): JsonResponse
    {
        return Responser::setData($job->load(['employer:id,name', 'city.country', 'skills'])->toArray())->success();
    }
}
