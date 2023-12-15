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
            'password' => $user->password,
        ]);
    }

    public function update(int $id, array $params): void
    {
        UserModel::query()->where('id', $id)->update($params);
    }

    public function delete(int $id): void
    {
        UserModel::query()->where('id', $id)->delete();
    }
}
