<?php

namespace App\Jobs;

use App\Events\NewTaskAssignedEvent;
use App\Models\User;
use App\Notifications\NewTaskAssigned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class NotifyCollectorNewAssignedJob implements ShouldQueue
{
    use Queueable;

    protected $assign_to;
    protected $collect_id;
    protected $no_sr;
    /**
     * Create a new job instance.
     */
    public function __construct($assign_to, $collect_id, $no_sr)
    {
        $this->assign_to = $assign_to;
        $this->collect_id = $collect_id;
        $this->no_sr = $no_sr;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // cari kolektor yang mau diberikan notifikasi
            $user = User::select(['id', 'kode_pegawai'])
                ->where('kode_pegawai', $this->assign_to)
                ->first();

            // berikan notifikasi disaat ada tugas baru
            $user->notify(new NewTaskAssigned($user->id, $this->collect_id, $this->no_sr));

            // ambil data notifikasi terakhir
            $notification = $user->notifications()->latest()->first();

            // broadcast notifikasi baru
            broadcast(new NewTaskAssignedEvent($notification->id, $user->id, $this->collect_id, $this->no_sr));
        } catch (\Exception $e) {
            Log::error('Notify new assign job failed for user: ' . $this->assign_to . ' - Error: ' . $e->getMessage());
        }
    }
}
