<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider  extends ServiceProvider
{
    public const HOME = '/redirect';

    public function boot(): void
    {
        //
    }
}
