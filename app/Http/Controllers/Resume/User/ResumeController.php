<?php

namespace App\Http\Controllers\Resume\User;

use App\Components\Responser\Facades\Responser;
use App\Components\Resume\Repositories\ResumeRepository;
use App\Http\Controllers\Controller;
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
}
