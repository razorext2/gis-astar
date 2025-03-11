<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\Backup;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        return view('dashboard.backup.index');
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
