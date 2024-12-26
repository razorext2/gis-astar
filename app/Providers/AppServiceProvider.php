<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Dayoff;
use App\Observers\DayoffObserver;

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
        Dayoff::observe(DayoffObserver::class);
        $this->app['url']->forceRootUrl($this->app['config']->get('app.url'));
    }
}
