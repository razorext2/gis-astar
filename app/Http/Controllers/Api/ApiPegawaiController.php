<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

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

    public function getPegawaiImages($storage)
    {
        $sanitizedStorage = basename($storage);
        $directoryPath = public_path('storage/labels/' . $sanitizedStorage);

        if (!is_dir($directoryPath)) {
            return response()->json(['error' => 'Directory not found'], 404);
        }

        $images = glob($directoryPath . '/*.{png,jpg,jpeg,webp}', GLOB_BRACE);
        // dd($images);

        if (!empty($images)) {
            $relativeImagePaths = array_map(function ($path) {
                return App::environment('production')
                    // ganti nanti disini juga
                    // ? str_replace(public_path(), '/attendance', $path)
                    ? str_replace(public_path(), '/attendance', $path)
                    : str_replace(public_path(), '', $path);
            }, $images);

            // dd($relativeImagePaths);

            return response()->json($relativeImagePaths);
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
