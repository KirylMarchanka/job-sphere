<?php

namespace App\Http\Controllers\Auth\Employer;

use App\Components\Auth\Email\Verify\Common\EmailVerifier;
use App\Components\Employer\Repositories\EmployerRepository;
use App\Components\JWT\Enums\AuthGuardEnum;
use App\Components\Responser\Facades\Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Employer\ResendVerifyEmailRequest;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function verify(Request $request, EmployerRepository $repository): RedirectResponse
    {
        $employer = $repository->find($request->input('id', 0));
        if (null === $employer) {
            return redirect()->route('index')->with('notification', [
                'message' => 'Работодатель для подтверждения не найден.'
            ]);
        }

        if (!$employer->hasVerifiedEmail()) {
            $employer->markEmailAsVerified();

            event(new Verified($employer));
        }

        return redirect()->route('employers.auth.login')->with('notification', [
            'message' => Lang::get('auth.verify.email.verified'),
        ]);
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
