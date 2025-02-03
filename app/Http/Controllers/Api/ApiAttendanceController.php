<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceOut;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiAttendanceController extends Controller
{
    public function getAttendanceData(Request $request)
    {
        $date = $request->query('date') ? Carbon::parse($request->query('date'))->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $kode_pegawai = $request->query('id');

        $attendance = Attendance::whereDate('jam_masuk', $date)
            ->where('kode_pegawai', $kode_pegawai)
            ->get();

        $attendanceOut = AttendanceOut::whereDate('jam_keluar', $date)
            ->where('kode_pegawai', $kode_pegawai)
            ->get();

        return response()->json([
            'attendance' => $attendance,
            'attendanceOut' => $attendanceOut,
        ]);
    }

    public function checkAttendance(Request $request)
    {
        $kodePegawai = $request->input('kode_pegawai');
        $today = now()->startOfDay();

        $attendance = Attendance::where('kode_pegawai', $kodePegawai)
            ->whereDate('jam_masuk', $today)
            ->first();

        return response()->json([
            'hasClockedIn' => $attendance ? true : false,
            'jam_masuk' => $attendance ? $attendance->jam_masuk : null,
        ]);
    }

    public function photoRegistProcess(Request $request)
    {
        $request->validate([
            'kode_pegawai' => 'required|exists:tb_pegawai,kode_pegawai',
            'photo1' => 'required|string',
            'photo2' => 'required|string',
        ]);

        $this->saveImages($request);
        return redirect()->to(route('landing.page') . '/#Scan')->with('success', 'Data berhasil diperbarui!');
    }

    public function saveImages(Request $request)
    {
        $kodePegawai = $request->input('kode_pegawai');

        $folderPath = "public/labels/{$kodePegawai}";
        $folderToDB = "labels/{$kodePegawai}/";

        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath);
            chmod(storage_path("app/public/labels"), 0755);
            chmod(storage_path("app/{$folderPath}"), 0755);
        }

        $photo1Data = $request->input('photo1');
        $photo2Data = $request->input('photo2');

        $photo1Data = str_replace('data:image/jpeg;base64,', '', $photo1Data);
        $photo1Data = base64_decode($photo1Data);
        $photo1Path = "{$folderPath}/photo1.png";
        Storage::put($photo1Path, $photo1Data);

        $photo2Data = str_replace('data:image/jpeg;base64,', '', $photo2Data);
        $photo2Data = base64_decode($photo2Data);
        $photo2Path = "{$folderPath}/photo2.png";
        Storage::put($photo2Path, $photo2Data);

        Pegawai::where('kode_pegawai', $kodePegawai)
            ->update([
                'storage' => $folderToDB,
            ]);
    }
}
