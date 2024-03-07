<?php

namespace App\Http\Controllers\Employer\Job\Common;

use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JobController extends Controller
{
    public function index(Request $request, int $employerId): JsonResponse
    {
        $employer = Employer::query()->find($employerId);
        if (null === $employer) {
            return Responser::setHttpCode(Response::HTTP_NOT_FOUND)->error('Employer not found.');
        }

        return Responser::wrap(false)->setData($employer->jobs()->where('is_archived', false)->paginate())->success();
    }
}
