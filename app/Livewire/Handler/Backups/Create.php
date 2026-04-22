<?php

namespace App\Livewire\Handler\Backups;

use App\Jobs\NotifyBackupReadyJob;
use App\Livewire\Concerns\HandlesErrors;
use App\Models\Backup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class Create extends Component
{
    use HandlesErrors;

    public function create(Request $request)
    {
        $this->runSafely(function () use ($request) {
            $name = Carbon::now()->format('Y-m-d-H-i-s').'.zip';
            $uid = $request->user()->id;

            // BugFix: Memisahkan query karena instance query builder bersifat mutable,
            // jika digabung, where() kedua akan membawa whereDate() dari pengecekan pertama.
            $backupTodayCount = Backup::where('user_id', $uid)
                ->whereDate('created_at', Carbon::now())
                ->count();

            if ($backupTodayCount >= 5) {
                $this->dispatch('swal', title: 'Gagal!', text: 'Anda hanya dapat mencadangkan sebanyak <b>5x sehari</b>.', icon: 'error');

                return;
            }

            $runningCount = Backup::where('user_id', $uid)
                ->where('status', 'running')
                ->count();

            if ($runningCount > 0) {
                $this->dispatch('swal', title: 'Gagal!', text: 'Masih ada proses pencadangan yang sedang berjalan!', icon: 'error');

                return;
            }

            Backup::create([
                'name' => $name,
                'type' => 'DB',
                'file' => 'backup/'.$name,
                'status' => 'running',
                'user_id' => $uid,
            ]);

            NotifyBackupReadyJob::dispatch($name, Carbon::now(), $uid)->delay(now()->addSeconds(5));

            $this->dispatch('pg:eventRefresh-BackupTable');

            $this->dispatch('swal', title: 'Sedang diproses...', text: 'Cadangan database dengan nama <b>'.$name.'</b> sedang dibuat.', icon: 'info');
        }, 'Gagal memproses pencadangan database.', [
            'user_id' => $request->user()->id ?? null,
            'action' => 'create backup',
        ]);
    }

    public function render()
    {
        return view('livewire.handler.backups.create');
    }
}
