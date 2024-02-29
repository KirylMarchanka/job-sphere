<?php

namespace App\Http\Controllers\Employer\Common;

use App\Components\Employer\Repositories\EmployerRepository;
use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\Common\IndexEmployerRequest;
use Illuminate\Http\JsonResponse;

class EmployerController extends Controller
{
    public function index(IndexEmployerRequest $request, EmployerRepository $repository): JsonResponse
    {
        return Responser::wrap(false)
            ->setData($repository->all($request->input('name'), $request->input('sector')))
            ->success();
    }
}
