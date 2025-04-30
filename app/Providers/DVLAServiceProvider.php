<?php

namespace App\Providers;

use App\Services\DVLA;
use Illuminate\Support\ServiceProvider;

class DVLAServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(DVLA::class, function ($app) {
            return new DVLA();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
} 