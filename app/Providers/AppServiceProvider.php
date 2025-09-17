<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        // Add HTTP request/response logging
        Http::macro('withLogging', function () {
            return $this->beforeSending(function ($request) {
                Log::debug('HTTP Request', [
                    'method' => $request->method(),
                    'url' => (string) $request->url(),
                    'headers' => $request->headers(),
                    'body' => $request->body()
                ]);
            })->retry(3, 100, function ($exception, $request) {
                Log::warning('HTTP Request Failed - Retrying', [
                    'exception' => get_class($exception),
                    'message' => $exception->getMessage(),
                    'url' => (string) $request->url()
                ]);
                
                return $exception instanceof \Illuminate\Http\Client\ConnectionException;
            });
        });
    }
}
