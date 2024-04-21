<?php

namespace App\Http\Controllers\Resume\Education\User;

use App\Components\Responser\Facades\Responser;
use App\Components\Resume\Education\Repositories\ResumeEducationRepository;
use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\ResumeEducation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ResumeEducationController extends Controller
{
    public function delete(Resume $resume, ResumeEducation $education, ResumeEducationRepository $repository): RedirectResponse
    {
        $repository->setResume($resume)->delete($education->getKey());

        return redirect()->route('users.resumes.show', ['resume' => $resume->getKey()]);
    }
}
