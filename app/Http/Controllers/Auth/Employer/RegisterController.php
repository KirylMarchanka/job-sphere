<?php

namespace App\Http\Controllers\Auth\Employer;

use App\Components\Employer\DTO\Employer as EmployerDto;
use App\Components\Employer\Repositories\EmployerRepository;
use App\Components\JWT\Enums\AuthGuardEnum;
use App\Components\JWT\JWTToken;
use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Employer\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request, EmployerRepository $repository, JWTToken $JWTToken): JsonResponse
    {
        $employer = $repository->store(
            new EmployerDto(
                $request->input('name'),
                $request->input('email'),
                $request->input('description'),
                $request->input('site_url'),
                $request->input('password'),
            ),
        );

        Event::dispatch(new Registered($employer));

        return Responser::setData([
            'message' => Lang::get('auth.verify.email.sent'),
            'token' => $JWTToken->setGuard(AuthGuardEnum::EMPLOYER)->generate($employer)->toArray(),
        ])->success();
    }
}
