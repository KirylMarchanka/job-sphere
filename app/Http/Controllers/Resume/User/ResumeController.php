<?php

namespace App\Http\Controllers\Resume\User;

use App\Components\Responser\Facades\Responser;
use App\Components\Resume\DTOs\ResumeContactDto;
use App\Components\Resume\DTOs\ResumeDto;
use App\Components\Resume\DTOs\ResumeEducationDto;
use App\Components\Resume\DTOs\ResumePersonalInformationDto;
use App\Components\Resume\DTOs\ResumeSkillDto;
use App\Components\Resume\DTOs\ResumeSpecializationDto;
use App\Components\Resume\DTOs\ResumeWorkExperienceDto;
use App\Components\Resume\Enums\EmploymentEnum;
use App\Components\Resume\Enums\ScheduleEnum;
use App\Components\Resume\Enums\StatusEnum;
use App\Components\Resume\Helpers\DtoFillers\ResumeContactDtoFiller;
use App\Components\Resume\Helpers\DtoFillers\ResumeDtoFiller;
use App\Components\Resume\Helpers\DtoFillers\ResumeEducationDtoFiller;
use App\Components\Resume\Helpers\DtoFillers\ResumePersonalInformationDtoFiller;
use App\Components\Resume\Helpers\DtoFillers\ResumeSkillDtoFiller;
use App\Components\Resume\Helpers\DtoFillers\ResumeSpecializationDtoFiller;
use App\Components\Resume\Helpers\DtoFillers\ResumeWorkExperienceDtoFiller;
use App\Components\Resume\Repositories\ResumeRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resume\User\DeleteResumeRequest;
use App\Http\Requests\Resume\User\StoreResumeRequest;
use App\Http\Requests\Resume\User\UpdateResumeRequest;
use App\Models\Resume;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

class ResumeController extends Controller
{
    public function index(Request $request, ResumeRepository $repository): JsonResponse
    {
        $resumes = $repository->setUser($request->user())->all();

        return empty($resumes)
            ? Responser::setHttpCode(Response::HTTP_NOT_FOUND)->error(Lang::get('user.resumes.list_not_found'))
            : Responser::setData($resumes)->success();
    }

    public function show(Request $request, string $resume, ResumeRepository $repository): JsonResponse
    {
        $resume = $repository->setUser($request->user())->find($resume);

        return null === $resume
            ? Responser::setHttpCode(Response::HTTP_NOT_FOUND)->error(Lang::get('user.resumes.single_not_found'))
            : Responser::setData($resume)->success();
    }

    public function store(StoreResumeRequest $request, ResumeRepository $repository): JsonResponse
    {
        $repository->setUser($request->user())->store(
            new ResumeDto(
                $request->input('title'),
                StatusEnum::from($request->integer('status')),
                $request->input('salary'),
                EmploymentEnum::from($request->integer('employment')),
                ScheduleEnum::from($request->integer('schedule')),
                $request->input('description')
            ),
            $request->whenFilled('specializations', fn(array $specializations) => array_map(fn(int $specialization) => new ResumeSpecializationDto($specialization), $specializations), fn() => []),
            $request->whenFilled('skills', fn(array $skills) => array_map(fn(int $skill) => new ResumeSkillDto($skill), $skills), fn() => []),
            new ResumeContactDto(...$request->input('contact')),
            new ResumePersonalInformationDto(...$request->input('personal_information')),
            $request->whenFilled('education', fn(array $educations) => array_map(fn(array $education) => new ResumeEducationDto(...$education), $educations), fn() => []),
            $request->whenFilled('work_experiences', fn(array $workExperiences) => array_map(fn(array $workExperience) => new ResumeWorkExperienceDto(...$workExperience), $workExperiences), fn() => []),
        );

        return Responser::setData(['success' => true])->setHttpCode(Response::HTTP_CREATED)->success();
    }

    public function update(UpdateResumeRequest $request, Resume $resume, ResumeRepository $repository): JsonResponse
    {
        $repository->setUser($request->user())->update(
            $resume->getKey(),
            ResumeDtoFiller::fill($resume, $request->only(['title', 'status', 'salary', 'employment', 'schedule', 'description'])),
            ResumeSpecializationDtoFiller::fill($request->input('specializations')),
            ResumeSkillDtoFiller::fill($request->input('skills')),
            ResumeContactDtoFiller::fill($resume, $request->input('contact')),
            ResumePersonalInformationDtoFiller::fill($resume, $request->input('personal_information')),
            ResumeEducationDtoFiller::fill($resume, $request->input('education')),
            ResumeWorkExperienceDtoFiller::fill($resume, $request->input('work_experiences')),
        );

        return Responser::setData(['success' => true])->setHttpCode(Response::HTTP_CREATED)->success();
    }

    public function delete(DeleteResumeRequest $request, Resume $resume, ResumeRepository $repository): JsonResponse
    {
        $repository->setUser($request->user())->delete($resume->getKey());

        return Responser::setData(['success' => true])->success();
    }
}
