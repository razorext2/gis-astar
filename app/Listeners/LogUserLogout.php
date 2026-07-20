<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\DB;

class LogUserLogout
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
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = $event->user;

        // Menyimpan log logout ke tb_log
        DB::table('log_histories')->insert([
            'user_id' => $user->id,
            'user_action' => 'logout',
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_location' => 'Unknown', // Implementasi untuk user location opsional
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
