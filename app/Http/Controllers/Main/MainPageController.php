<?php

namespace App\Http\Controllers\Main;

use App\Components\Employer\Repositories\EmployerRepository;
use App\Http\Controllers\Controller;
use App\Models\EmployerJob;
use Illuminate\Contracts\View\View;

class MainPageController extends Controller
{
    public function index(EmployerRepository $repository): View
    {
        return view()->make('welcome', [
            'employers' => $repository->get(limit: 10),
            'jobs' => EmployerJob::query()->inRandomOrder()->limit(5)->get()->toArray(),
        ]);
    }
}
