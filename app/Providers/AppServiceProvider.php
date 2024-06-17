<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void

    {
        Schema::defaultStringLength(191);

        // $lifetime = config('session.lifetime');
        // $tokenExpirationTime = now()->addMinutes($lifetime);

        // Session::put('csrf_token_expiration', $tokenExpirationTime);
    }
}
