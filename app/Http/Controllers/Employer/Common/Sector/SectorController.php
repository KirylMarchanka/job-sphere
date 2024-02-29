<?php

namespace App\Http\Controllers\Employer\Common\Sector;

use App\Components\Employer\Sector\Repositories\SectorRepository;
use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\Common\Sectore\IndexSectorRequest;
use Illuminate\Http\JsonResponse;

class SectorController extends Controller
{
    public function index(IndexSectorRequest $request, SectorRepository $repository): JsonResponse
    {
        return Responser::setData($repository->all($request->input('parent_id')))->success();
    }
}
