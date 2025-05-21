<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('User accessed:', [
            'path' => $request->path(),
            'method' => $request->method(),
            'laravel_ip' => $request->ip(),
            'X-Forwarded-For' => $request->header('X-Forwarded-For'),
            'X-Real-IP' => $request->header('X-Real-IP'),
            'Remote-Addr' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
            'user_agent' => $request->userAgent(),
        ]);

        return $next($request);
    }
}
