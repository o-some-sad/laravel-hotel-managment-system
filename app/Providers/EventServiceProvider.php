<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Floor;
use App\Observers\FloorObserver;
class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // 
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Removed parent::boot() as it does not exist in the parent class.
        Floor::observe(FloorObserver::class);
    }
}
