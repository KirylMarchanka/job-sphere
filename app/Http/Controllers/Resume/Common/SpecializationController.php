<?php

namespace App\Http\Controllers\Resume\Common;

use App\Components\Responser\Facades\Responser;
use App\Components\Resume\Specialization\Repositories\SpecializationRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class SpecializationController extends Controller
{
    public function index(SpecializationRepository $repository): JsonResponse
    {
        $specializations = Cache::remember('specializations', 3600, fn() => $repository->all());

        return Responser::setData($specializations)->success();
    }
}
