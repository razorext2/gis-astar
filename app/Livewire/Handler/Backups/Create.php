<?php

namespace App\Livewire\Handler\Backups;

use App\Jobs\NotifyBackupReadyJob;
use App\Models\Backup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Create extends Component
{
    public function create(Request $request)
    {
        $name = Carbon::now()->format('Y-m-d-H-i-s') . '.zip';
        $uid = $request->user()->id;

        $data = Backup::where('user_id', $uid);

        if ($data->whereDate('created_at', Carbon::now())->count() >= 5) {
            return $this->dispatch('swal', title: 'Gagal!', text: 'Anda hanya dapat mencadangkan sebanyak <b>5x sehari</b>.', icon: 'error');
        }

        if ($data->where('status', 'running')->count() > 0) {
            return $this->dispatch('swal', title: 'Gagal!', text: 'Masih ada proses pencadangan yang sedang berjalan!', icon: 'error');
        }

        Backup::create([
            'name' => $name,
            'type' => 'DB',
            'file' => 'backup/' . $name,
            'status' => 'running',
            'user_id' => $uid,
        ]);

        NotifyBackupReadyJob::dispatch($name, Carbon::now(), $uid)->delay(now()->addSeconds(5));

        $this->dispatch('pg:eventRefresh-BackupTable');

        return $this->dispatch('swal', title: 'Sedang diproses...', text: 'Cadangan database dengan nama <b>' . $name . '</b> sedang dibuat.', icon: 'info');
    }

    public function render()
    {
        return view('livewire.handler.backups.create');
    }
}
