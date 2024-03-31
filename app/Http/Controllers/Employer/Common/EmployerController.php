<?php

namespace App\Http\Controllers\Employer\Common;

use App\Components\Employer\Repositories\EmployerRepository;
use App\Components\Employer\Sector\Repositories\SectorRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\Common\IndexEmployerRequest;
use Illuminate\Contracts\View\View;

class EmployerController extends Controller
{
    public function index(IndexEmployerRequest $request, EmployerRepository $employerRepository, SectorRepository $sectorRepository): View
    {
        return view('employers.index', [
            'employers' => $employerRepository->all($request->input('name'), $request->input('sector')),
            'sectors' => $sectorRepository->all(),
            'name' => $request->input('name'),
            'sector' => $request->input('sector'),
        ]);
    }

    public function show(EmployerRepository $repository, int $employer): View
    {
        return view('employers.show', [
            'employer' => $repository->show($employer),
        ]);
    }
}
