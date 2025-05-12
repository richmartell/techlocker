<?php

namespace App\Providers;

use App\Services\HaynesPro;
use Illuminate\Support\ServiceProvider;

class HaynesProServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(HaynesPro::class, function ($app) {
            return new HaynesPro();
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