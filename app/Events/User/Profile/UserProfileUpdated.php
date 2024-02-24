<?php

namespace App\Events\User\Profile;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserProfileUpdated
{
    use Dispatchable, SerializesModels;

    public Authenticatable $user;

    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }
}
