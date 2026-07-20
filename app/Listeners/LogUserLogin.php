<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

class LogUserLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;

        // Menyimpan log login ke tb_log
        DB::table('log_histories')->insert([
            'user_id' => $user->id,
            'user_action' => 'login',
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_location' => 'Unknown', // Implementasi untuk user location opsional
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
