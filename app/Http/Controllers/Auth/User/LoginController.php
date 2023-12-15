<?php

namespace App\Http\Controllers\Auth\User;

use App\Components\Auth\UserAuthenticator;
use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login(LoginRequest $request, UserAuthenticator $authenticator): JsonResponse
    {
        $token = $authenticator->authenticate($request->input('email'), $request->input('password'));

        return null === $token
            ? Responser::setHttpCode(Response::HTTP_UNPROCESSABLE_ENTITY)->error(Lang::get('auth.login.user-not-found'))
            : Responser::setData($token->toArray())->success();
    }
}
