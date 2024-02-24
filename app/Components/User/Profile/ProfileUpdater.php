<?php

namespace App\Components\User\Profile;

use App\Components\User\DTO\User as UserDto;
use App\Components\User\Repositories\UserRepository;
use App\Events\User\Profile\UserProfileUpdated;
use App\Models\User;

class ProfileUpdater
{
    private UserRepository $repository;
    private User $user;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function update(UserDto $user): void
    {
        $params = $user->toArray();
        if ($user->email !== $this->user->getAttribute('email')) {
            $params['email_verified_at'] = null;
        }

        $this->repository->update($this->user->getKey(), $params);
        UserProfileUpdated::dispatch($this->user->refresh());
    }
}
