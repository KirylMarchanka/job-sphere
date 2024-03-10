<?php

namespace App\Http\Controllers\Resume\Common;

use App\Components\Responser\Facades\Responser;
use App\Components\Resume\Repositories\ResumeRepository;
use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function index(Request $request, ResumeRepository $repository): JsonResponse
    {
        return Responser::wrap(false)->setData($repository->paginate($request->all()))->success();
    }

    public function show(Resume $resume): JsonResponse
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

        return Responser::setData($resume->toArray())->success();
    }
}
