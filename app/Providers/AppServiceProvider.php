<?php

namespace App\Providers;

use App\Models\Floor;
use App\Observers\FloorObserver;
use Illuminate\Support\Facades\Vite;
use App\Services\CloudinaryService;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use App\Policies\ReceptionistPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => ReceptionistPolicy::class,
    ];

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