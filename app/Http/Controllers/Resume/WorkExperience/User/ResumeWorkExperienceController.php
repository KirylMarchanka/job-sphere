<?php

namespace App\Http\Controllers\Resume\WorkExperience\User;

use App\Components\Responser\Facades\Responser;
use App\Components\Resume\WorkExperience\Repositories\ResumeWorkExperienceRepository;
use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\ResumeWorkExperience;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ResumeWorkExperienceController extends Controller
{
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
