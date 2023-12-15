<?php

namespace App\Http\Controllers\Auth\User;

use App\Components\JWT\JWTToken;
use App\Components\Responser\Facades\Responser;
use App\Components\User\DTO\User;
use App\Components\User\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

//@todo Swagger
class RegisterController extends Controller
{
    public function register(RegisterRequest $request, UserRepository $repository, JWTToken $JWTToken): JsonResponse
    {
        $user = $repository->store(
            new User(
                $request->input('name'),
                $request->input('email'),
                $request->input('mobile_number'),
                Hash::make($request->input('password'))
            )
        );

        Event::dispatch(new Registered($user));

        return Responser::setData([
            'message' => Lang::get('auth.verify.email.sent'),
            'token' => $JWTToken->generate($user)->toArray(),
        ])->success();
    }
}
