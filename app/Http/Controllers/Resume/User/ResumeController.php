<?php

namespace App\Http\Controllers\Resume\User;

use App\Components\City\Repositories\CityRepository;
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
use App\Components\Resume\Specialization\Repositories\SpecializationRepository;
use App\Components\Skill\Repositories\SkillRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resume\User\DeleteResumeRequest;
use App\Http\Requests\Resume\User\StoreResumeRequest;
use App\Http\Requests\Resume\User\UpdateResumeRequest;
use App\Models\Resume;
use App\Models\ResumeContact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function index(Request $request, ResumeRepository $repository): View
    {
        $resumes = $repository->setUser($request->user())->all();

        return view('users.resume.index', ['resumes' => $resumes]);
    }

    public function show(
        Request $request,
        string $resume,
        ResumeRepository $resumeRepository,
        CityRepository $cityRepository,
        SkillRepository $skillRepository,
        SpecializationRepository $specializationRepository,
    ): View
    {
        $resume = $resumeRepository->setUser($request->user())->find($resume);
        $resume->setRelation('contact', $this->getOtherSources($resume->getRelation('contact')));

        return view('users.resume.show', [
            'resume' => $resume,
            'statuses' => StatusEnum::toArray(),
            'cities' => $cityRepository->all(),
            'employments' => EmploymentEnum::toArray(),
            'schedules' => ScheduleEnum::toArray(),
            'skills' => $skillRepository->all(),
            'specializations' => $specializationRepository->getChildren(),
        ]);
    }

    private function getOtherSources(ResumeContact $contact): ResumeContact
    {
        $otherSources = json_decode($contact->getRawOriginal('other_sources') ?? '', true);
        if (null === $otherSources) {
            return $contact->setAttribute('original_other_sources', [
                'linkedin' => null,
                'telegram' => null,
            ]);
        }

        return $contact->setAttribute('original_other_sources', [
            'linkedin' => $otherSources['linkedin'] ?? null,
            'telegram' => $otherSources['telegram'] ?? null,
        ]);
    }

    public function store(StoreResumeRequest $request, ResumeRepository $repository): RedirectResponse
    {
        $resume = $repository->setUser($request->user())->store(
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

        return redirect()->route('users.resumes.show', ['resume' => $resume->getKey()]);
    }

    public function update(UpdateResumeRequest $request, Resume $resume, ResumeRepository $repository): RedirectResponse
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

        return redirect()->route('users.resumes.index');
    }

    public function delete(DeleteResumeRequest $request, Resume $resume, ResumeRepository $repository): RedirectResponse
    {
        dd($resume, $request->method());
        $repository->setUser($request->user('web.users'))->delete($resume->getKey());

        return redirect()->route('users.resumes.index');
    }
}
