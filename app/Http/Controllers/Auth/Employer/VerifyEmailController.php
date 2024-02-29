<?php

namespace App\Http\Controllers\Auth\Employer;

use App\Components\Auth\Email\Verify\Common\EmailVerifier;
use App\Components\JWT\Enums\AuthGuardEnum;
use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Employer\ResendVerifyEmailRequest;
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

    public function resend(ResendVerifyEmailRequest $request, EmailVerifier $emailVerifier): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return Responser::setErrorCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->error(Lang::get('auth.email.verified'));
        }

        $token = $emailVerifier
            ->setUser($request->user('api.employers'))
            ->setGuard(AuthGuardEnum::EMPLOYER)
            ->updateEmail($request->input('email'))
            ->sendVerification();

        return Responser::setData([
            'message' => Lang::get('auth.email.sent'),
            'token' => $token?->toArray()
        ])->success();
    }
}
