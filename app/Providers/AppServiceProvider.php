<?php

namespace App\Providers;

use App\Models\LeaveRequest\LeaveRequest;
use App\Observers\LeaveRequestObserver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        URL::macro(
            'alternateHasCorrectSignature',
            function (Request $request, $absolute = true, array $ignoreQuery = []) {
                $ignoreQuery[] = 'signature';

                $absoluteUrl = url($request->path());
                $url = $absolute ? $absoluteUrl : '/'.$request->path();

                $queryString = collect(explode('&', (string) $request
                    ->server->get('QUERY_STRING')))
                    ->reject(fn ($parameter) => in_array(Str::before($parameter, '='), $ignoreQuery))
                    ->join('&');

                $original = rtrim($url.'?'.$queryString, '?');

                // Use the application key as the HMAC key
                $key = config('app.key'); // Ensure app.key is properly set in .env

                if (empty($key)) {
                    throw new \RuntimeException('Application key is not set.');
                }

                $signature = hash_hmac('sha256', $original, $key);

                return hash_equals($signature, (string) $request->query('signature', ''));
            }
        );

        URL::macro('alternateHasValidSignature', function (Request $request, $absolute = true, array $ignoreQuery = []) {
            return URL::alternateHasCorrectSignature($request, $absolute, $ignoreQuery)
                && URL::signatureHasNotExpired($request);
        });

        Request::macro('hasValidSignature', function ($absolute = true, array $ignoreQuery = []) {
            return URL::alternateHasValidSignature($this, $absolute, $ignoreQuery);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LeaveRequest::observe(LeaveRequestObserver::class);

        // force https
        URL::forceScheme('https');

        // force root url
        $this->app['url']->forceRootUrl($this->app['config']->get('app.url'));

        // Auto-register moved PowerGrid tables under their short/kebab/stud names
        if (is_dir(app_path('Livewire/PowergridTables'))) {
            $files = glob(app_path('Livewire/PowergridTables/*Table.php'));
            foreach ($files as $file) {
                $className = basename($file, '.php');
                $classPath = 'App\\Livewire\\PowergridTables\\' . $className;
                if (class_exists($classPath)) {
                    \Livewire\Livewire::component($className, $classPath);
                    $kebabName = \Illuminate\Support\Str::kebab($className);
                    \Livewire\Livewire::component($kebabName, $classPath);
                }
            }
        }
    }
}
