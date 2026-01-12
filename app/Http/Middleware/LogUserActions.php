<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogUserActions
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Simpan response untuk digunakan nanti
        $response = $next($request);

        // Cek apakah user sedang login dan metode HTTP yang digunakan melibatkan perubahan data
        if (Auth::check() && $this->isDatabaseAction($request)) {
            // Mendapatkan data user
            $user = Auth::user();

            // Menentukan aksi yang dilakukan
            $actionName = $this->getActionName($request);

            // Menentukan nama entitas (contoh: 'pegawai', 'division', dll) dari URL atau nama route
            $entityName = $this->getEntityName($request);

            // Simpan log ke tb_log dengan format yang diinginkan
            DB::table('tb_log')->insert([
                'user_id' => $user->id,
                'user_action' => "{$entityName} > {$actionName}",
                'ip_address' => "
                    [
                        LaravelIP: {$request->ip()},
                        X-Forwarded-For: {$request->header('X-Forwarded-For')},
                        X-Real-IP: {$request->header('X-Real-IP')},
                        Remote-Addr: {$_SERVER['REMOTE_ADDR']},
                        Path: {$request->path()},
                    ]
                ",
                'user_agent' => $request->header('User-Agent'),
                'user_location' => 'Unknown', // Implementasi untuk user location opsional
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // simpan ke laravel.log
            Log::info('User accessed:', [
                'user_id' => $user->id,
                'user_action' => "{$entityName} > {$actionName}",
                'ip_address' => [
                    'LaravelIP' => $request->ip(),
                    'X-Forwarded-For' => $request->header('X-Forwarded-For'),
                    'X-Real-IP' => $request->header('X-Real-IP'),
                    'Remote-Addr' => $_SERVER['REMOTE_ADDR'],
                    'Path' => $request->path(),
                ],
                'user_agent' => $request->header('User-Agent'),
                'user_location' => 'Unknown', // Implementasi untuk user location opsional
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $response;
    }

    /**
     * Menentukan nama aksi berdasarkan metode HTTP request.
     *
     * @return string
     */
    private function getActionName(Request $request)
    {
        if ($request->isMethod('post')) {
            return 'create';
        } elseif ($request->isMethod('put') || $request->isMethod('patch')) {
            return 'update';
        } elseif ($request->isMethod('delete')) {
            return 'delete';
        }

        return 'unknown';
    }

    /**
     * Menentukan apakah request melibatkan perubahan data di database.
     *
     * @return bool
     */
    private function isDatabaseAction(Request $request)
    {
        return $request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch') || $request->isMethod('delete');
    }

    /**
     * Menentukan nama entitas berdasarkan URL atau nama route.
     *
     * @return string
     */
    private function getEntityName(Request $request)
    {
        // Ambil nama dari route, atau fallback ke segmen URL jika nama route tidak tersedia
        $routeName = $request->route()->getName();

        if ($routeName) {
            // Asumsikan nama route memiliki format seperti 'pegawai.store', 'division.update'
            $parts = explode('.', $routeName);

            return $parts[0] ?? 'unknown';
        }

        // Alternatif, jika nama route tidak ada, ambil segmen pertama dari URI
        return $request->segment(1) ?? 'unknown';
    }
}
