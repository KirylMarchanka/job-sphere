<?php

namespace App\Http\Controllers\Resume\Education\User;

use App\Components\Responser\Facades\Responser;
use App\Components\Resume\DTOs\ResumeEducationDto;
use App\Components\Resume\Education\Enums\DegreeEnum;
use App\Components\Resume\Education\Repositories\ResumeEducationRepository;
use App\Components\Resume\Helpers\DtoFillers\ResumeEducationDtoFiller;
use App\Components\Resume\Repositories\ResumeRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resume\Education\User\StoreResumeEducationRequest;
use App\Http\Requests\Resume\Education\User\UpdateResumeEducationRequest;
use App\Models\EducationalInstitution;
use App\Models\Resume;
use App\Models\ResumeEducation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResumeEducationController extends Controller
{
    public function create(Request $request, Resume $resume): View
    {
        if ($resume->getAttribute('user_id') !== $request->user('web.users')->getKey()) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view()->make('users.resume.education.create', [
            'resume' => $resume,
            'educationalInstitutions' => EducationalInstitution::query()->select(['id', 'name'])->get(),
            'degrees' => DegreeEnum::toArray(),
        ]);
    }

    public function store(StoreResumeEducationRequest $request, Resume $resume, ResumeRepository $resumeRepository): RedirectResponse
    {
        $resumeRepository->setUser($request->user('web.users'))->update(
            resumeId: $resume->getKey(),
            education: ResumeEducationDtoFiller::fill($resume, $request->input('education')),
        );

        return redirect()->route('users.resumes.show', ['resume' => $resume->getKey()]);
    }

    public function edit(Request $request, Resume $resume, ResumeEducation $education): View
    {
        if (
            $resume->getAttribute('user_id') !== $request->user('web.users')->getKey()
            || $education->getAttribute('resume_id') !== $resume->getKey()
        ) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view()->make('users.resume.education.edit', [
            'resume' => $resume,
            'education' => $education,
            'educationalInstitutions' => EducationalInstitution::query()->select(['id', 'name'])->get(),
            'degrees' => DegreeEnum::toArray(),
        ]);
    }

    public function update(UpdateResumeEducationRequest $request, Resume $resume, ResumeEducation $education, ResumeRepository $resumeRepository): RedirectResponse
    {
        $resumeRepository->setUser($request->user('web.users'))->update(
            resumeId: $resume->getKey(),
            education: ResumeEducationDtoFiller::fill($resume, $request->input('education')),
        );

        return redirect()->route('users.resumes.show', ['resume' => $resume->getKey()]);
    }

    public function delete(Resume $resume, ResumeEducation $education, ResumeEducationRepository $repository): RedirectResponse
    {
        $repository->setResume($resume)->delete($education->getKey());

        return redirect()->route('users.resumes.show', ['resume' => $resume->getKey()]);
    }
}
