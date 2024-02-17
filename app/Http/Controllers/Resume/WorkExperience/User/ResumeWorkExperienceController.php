<?php

namespace App\Http\Controllers\Resume\WorkExperience\User;

use App\Components\Responser\Facades\Responser;
use App\Components\Resume\WorkExperience\Repositories\ResumeWorkExperienceRepository;
use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\ResumeWorkExperience;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResumeWorkExperienceController extends Controller
{
    public function delete(
        Resume $resume,
        ResumeWorkExperience $workExperience,
        ResumeWorkExperienceRepository $repository
    ): JsonResponse
    {
        $repository->setResume($resume)->delete($workExperience->getKey());

        return Responser::setHttpCode(Response::HTTP_NO_CONTENT)->success();
    }
}
