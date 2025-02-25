<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Jobs\NotifyBackupReadyJob;
use App\Models\Backup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BackupController extends Controller
{
    public function index()
    {
        return view('dashboard.backup.index');
    }

    public function store(Request $request)
    {
        $name = Carbon::now()->format('Y-m-d-H-i-s') . '.zip';
        $uid = $request->user()->id;

        $data = Backup::where('user_id', $uid);

        if ($data->whereDate('created_at', Carbon::now())->count() >= 5) {
            return new ApiResource(false, 'Gagal membuat cadangan', 'Anda hanya dapat mencadangkan sebanyak <b>5x sehari</b>.');
        }

        if ($data->where('status', 'running')->count() > 0) {
            return new ApiResource(false, 'Gagal membuat cadangan', 'Masih ada proses pencadangan yang sedang berjalan!');
        }

        Backup::create([
            'name' => $name,
            'type' => 'DB',
            'file' => 'backup/' . $name,
            'status' => 'running',
            'user_id' => $uid,
        ]);

        NotifyBackupReadyJob::dispatch($name, Carbon::now(), $uid);

        return new ApiResource(true, 'Sedang diproses...', 'Cadangan database dengan nama <b>' . $name . '</b> sedang dibuat.');
    }

    public function destroy($id)
    {
        $data = Backup::where('id', $id)->first();

        if (!$data) {
            return new ApiResource(false, 'Gagal menghapus data', 'ID tidak ditemukan');
        }

        if (Storage::exists($data->file)) {
            Storage::delete($data->file);
        }

        $data->delete();
        return new ApiResource(true, 'Cadangan berhasil dihapus.');
    }

    public function download($id)
    {
        $data = Backup::select('id', 'file')->where('id', $id)->first();

        if (!$data) {
            return new ApiResource(false, 'Gagal mengunduh data', 'ID tidak ditemukan');
        }

        if (!Storage::exists($data->file)) {
            return new ApiResource(false, 'Gagal mengunduh file', 'File tidak ditemukan');
        }

        $file = Storage::download($data->file);

        if (!$file) {
            return new ApiResource(false, 'Gagal mengunduh file', 'File tidak terunduh');
        }

        return $file;
    }
}
