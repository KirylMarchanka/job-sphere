<?php

namespace App\Http\Controllers\Employer\Common;

use App\Components\Employer\Repositories\EmployerRepository;
use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\Common\IndexEmployerRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class EmployerController extends Controller
{
    public function index(IndexEmployerRequest $request, EmployerRepository $repository): JsonResponse
    {
        return Responser::wrap(false)
            ->setData($repository->all($request->input('name'), $request->input('sector')))
            ->success();
    }

    public function show(EmployerRepository $repository, int $employer): View
    {
        return view('employers.show', [
            'employer' => $repository->show($employer),
        ]);
    }
}
