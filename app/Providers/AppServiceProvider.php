<?php

namespace App\Providers;

use App\Models\Floor;
use App\Observers\FloorObserver;
use Illuminate\Support\Facades\Vite;
use App\Services\CloudinaryService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CloudinaryService::class, function ($app) {
            return new CloudinaryService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Floor::observe(FloorObserver::class);
    }
}

