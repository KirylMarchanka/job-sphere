<?php

namespace App\Http\Controllers\Auth\User;

use App\Components\Auth\Email\Verify\Common\EmailVerifier;
use App\Components\JWT\Enums\AuthGuardEnum;
use App\Components\Responser\Facades\Responser;
use App\Components\User\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\ResendVerifyEmailRequest;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmailController extends Controller
{
    public function show(): JsonResponse
    {
        return Responser::setData(['message' => Lang::get('auth.email.resend')])
            ->success();
    }

    public function verify(Request $request, UserRepository $repository): RedirectResponse
    {
        $user = $repository->find($request->input('id', 0));
        if (null === $user) {
            return redirect()->route('index')->with('notification', [
                'message' => 'Пользователь для подтверждения не найден.'
            ]);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            event(new Verified($user));
        }

        return redirect()->route('users.auth.login')->with('notification', [
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
            ->setUser($request->user('api.users'))
            ->setGuard(AuthGuardEnum::USER)
            ->updateEmail($request->input('email'))
            ->sendVerification();

        return Responser::setData([
            'message' => Lang::get('auth.email.sent'),
            'token' => $token?->toArray()
        ])->success();
    }
}
