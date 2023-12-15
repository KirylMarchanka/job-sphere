<?php

namespace App\Providers;

use App\Components\Responser\Responser;
use Illuminate\Support\ServiceProvider;

class ResponserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('responser', fn () => new Responser());
    }
}
