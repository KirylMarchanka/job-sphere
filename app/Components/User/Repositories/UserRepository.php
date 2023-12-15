<?php

namespace App\Components\User\Repositories;

use App\Components\User\DTO\User;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function store(User $user): UserModel
    {
        return UserModel::query()->create([
            'name' => $user->name,
            'email' => $user->email,
            'mobile_number' => $user->mobileNumber,
            'password' => Hash::make($user->password),
        ]);
    }
}
