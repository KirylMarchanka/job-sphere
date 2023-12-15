<?php

namespace App\Http\Controllers\Profile\User;

use App\Components\Responser\Facades\Responser;
use App\Components\User\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\User\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class ProfileController extends Controller
{
    public function show(): JsonResponse
    {
        return Responser::setData(Auth::user()->toArray())->success();
    }

    public function update(UpdateProfileRequest $request, UserRepository $repository): JsonResponse
    {
        $data = $request->only(['name', 'email', 'mobile_number', 'password']);
        if (null === $data['password']) {
            unset($data['password']);
        }

        $repository->update(Auth::id(), $data);

        return Responser::setData(['message' => Lang::get('profile.user.updated')])->success();
    }

    public function destroy(UserRepository $repository): JsonResponse
    {
        $repository->delete(Auth::id());

        return Responser::setData(['message' => Lang::get('profile.user.deleted')])->success();
    }
}
