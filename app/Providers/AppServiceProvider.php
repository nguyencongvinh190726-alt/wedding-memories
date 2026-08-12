<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Railway terminates HTTPS before requests reach the PHP container.
        // Force generated form actions and asset URLs to keep using HTTPS.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
