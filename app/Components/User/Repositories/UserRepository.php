<?php

namespace App\Components\User\Repositories;

use App\Components\User\DTO\User;
use App\Models\User as UserModel;

class UserRepository
{
    public function find(int $id): ?UserModel
    {
        return UserModel::query()->find($id);
    }

    public function store(User $user): UserModel
    {
        return UserModel::query()->create($user->toArray());
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
