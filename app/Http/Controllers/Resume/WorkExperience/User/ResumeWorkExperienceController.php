<?php

namespace App\Http\Controllers\Resume\WorkExperience\User;

use App\Components\City\Repositories\CityRepository;
use App\Components\Resume\Helpers\DtoFillers\ResumeEducationDtoFiller;
use App\Components\Resume\Helpers\DtoFillers\ResumeWorkExperienceDtoFiller;
use App\Components\Resume\Repositories\ResumeRepository;
use App\Components\Resume\WorkExperience\Repositories\ResumeWorkExperienceRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resume\WorkExperience\User\StoreResumeWorkExperienceRequest;
use App\Http\Requests\Resume\WorkExperience\User\UpdateResumeWorkExperienceRequest;
use App\Models\Resume;
use App\Models\ResumeWorkExperience;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResumeWorkExperienceController extends Controller
{
    public function create(Request $request, Resume $resume, CityRepository $cityRepository): View
    {
        if ($resume->getAttribute('user_id') !== $request->user('web.users')->getKey()) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view()->make('users.resume.workExperience.create', [
            'resume' => $resume,
            'cities' => $cityRepository->all(),
        ]);
    }

    public function store(StoreResumeWorkExperienceRequest $request, Resume $resume, ResumeRepository $resumeRepository): RedirectResponse
    {
        $resumeRepository->setUser($request->user('web.users'))->update(
            resumeId: $resume->getKey(),
            workExperience: ResumeWorkExperienceDtoFiller::fill($resume, $request->input('work_experiences')),
        );

        return redirect()->route('users.resumes.show', ['resume' => $resume->getKey()]);
    }

    public function edit(Request $request, Resume $resume, ResumeWorkExperience $workExperience, CityRepository $cityRepository): View
    {
        if (
            $resume->getAttribute('user_id') !== $request->user('web.users')->getKey()
            || $workExperience->getAttribute('resume_id') !== $resume->getKey()
        ) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view()->make('users.resume.workExperience.edit', [
            'resume' => $resume,
            'workExperience' => $workExperience,
            'cities' => $cityRepository->all(),
        ]);
    }

    public function update(UpdateResumeWorkExperienceRequest $request, Resume $resume, ResumeWorkExperience $workExperience, ResumeRepository $resumeRepository): RedirectResponse
    {
        $resumeRepository->setUser($request->user('web.users'))->update(
            resumeId: $resume->getKey(),
            workExperience: ResumeWorkExperienceDtoFiller::fill($resume, $request->input('work_experiences')),
        );

        return redirect()->route('users.resumes.show', ['resume' => $resume->getKey()]);
    }

    public function delete(
        Resume $resume,
        ResumeWorkExperience $workExperience,
        ResumeWorkExperienceRepository $repository
    ): RedirectResponse
    {
        $repository->setResume($resume)->delete($workExperience->getKey());

        return redirect()->route('users.resumes.show', ['resume' => $resume->getKey()]);
    }
}
