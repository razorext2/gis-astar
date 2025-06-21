<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use DirectoryIterator;

class ApiPegawaiController extends Controller
{
    public function getSixMonthsBefore()
    {
        $months = [];
        for ($i = 0; $i < 6; $i++) {
            $date = Carbon::now()->subMonths($i);
            $months[] = [
                'label' => $date->isoFormat('MMMM YYYY'),
                'value' => $date->format('Y-m')
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $months,
        ]);
    }

    public function getPegawai()
    {
        $data = Pegawai::whereNotNull('storage')->pluck('kode_pegawai');
        return response()->json($data);
    }

    public function getPegawaiImages($kode_pegawai)
    {
        $directoryPath = public_path('storage/labels/' . $kode_pegawai);
        $filePath = $directoryPath . '/photo1.png';

        if (!is_dir($directoryPath)) {
            return response()->json(['error' => 'Directory not found'], 404);
        }

        if (file_exists($filePath)) {
            // buat path relative
            $relativePath = str_replace(public_path(), '', $filePath);

            return response()->json($relativePath);
        } else {
            return response()->json(['error' => 'photo1.png not found'], 404);
        }
    }

    public function getPegawaiDataByLabel($label)
    {
        $pegawai = Pegawai::with(['attendanceRelasi', 'jabatanRelasi', 'golonganRelasi'])
            ->where('kode_pegawai', $label)
            ->first();

        if ($pegawai) {
            return response()->json($pegawai);
        } else {
            return response()->json(['error' => 'Pegawai not found'], 404);
        }
    }
}
