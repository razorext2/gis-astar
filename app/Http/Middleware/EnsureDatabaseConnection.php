<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class EnsureDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Tes koneksi database (ping)
            DB::connection()->getPdo();
        } catch (\Throwable $e) {
            // Jika gagal, paksa reconnect
            DB::disconnect();
            DB::reconnect();
        }

        return $next($request);
    }
}
