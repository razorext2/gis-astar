<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\Dayoff;
use App\Models\Collector;
use App\Observers\CollectObserver;
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
        // force https
        URL::forceScheme('https');

        // force root url
        $this->app['url']->forceRootUrl($this->app['config']->get('app.url'));

        // oberserver
        Dayoff::observe(DayoffObserver::class);
        Collector::observe(CollectObserver::class);

        $this->app['url']->forceRootUrl($this->app['config']->get('app.url'));
    }
}
