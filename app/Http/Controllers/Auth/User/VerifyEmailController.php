<?php

namespace App\Http\Controllers\Auth\User;

use App\Components\JWT\JWTToken;
use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\ResendVerifyEmailRequest;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

//@todo Swagger
class VerifyEmailController extends Controller
{
    public function show(): JsonResponse
    {
        return Responser::setData(['message' => Lang::get('auth.email.resend')])
            ->success();
    }

    public function verify(EmailVerificationRequest $request): JsonResponse
    {
        $request->fulfill();

        return Responser::setData(['message' => Lang::get('auth.email.verified')])
            ->success();
    }

    public function resend(ResendVerifyEmailRequest $request, JWTToken $JWTToken): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return Responser::setErrorCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->error(Lang::get('auth.email.verified'));
        }

        $token = null;
        if ($request->has('email') && $request->user()->getAttribute('email') !== $request->input('email')) {
            $request->user()->update(['email' => $request->input('email')]);
            $token = $JWTToken->generate($request->user());
        }

        $request->user()->sendEmailVerificationNotification();

        return Responser::setData([
            'message' => Lang::get('auth.email.sent'),
            'token' => $token?->toArray()
        ])->success();
    }
}
