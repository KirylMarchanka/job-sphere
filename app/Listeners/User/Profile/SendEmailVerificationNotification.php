<?php

namespace App\Listeners\User\Profile;

use App\Events\User\Profile\UserProfileUpdated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param Registered|UserProfileUpdated $event
     * @return void
     */
    public function handle(Registered|UserProfileUpdated $event): void
    {
        if ($event->user instanceof MustVerifyEmail && !$event->user->hasVerifiedEmail()) {
            $event->user->sendEmailVerificationNotification();
        }
    }
}
