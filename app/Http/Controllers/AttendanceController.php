<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{

    public function index()
    {
        return view('dashboard.attendanceIn.view');
    }

    public function storeAttendance(Request $request)
    {
        try {
            $kodePegawai = $request->input('kode_pegawai');
            $timestamp = Session::get('current_date');
            $photoURL = $kodePegawai . $timestamp;
            if (!is_null($request->input('longitude'))) {
                $longitude = $request->input('longitude');
                $latitude = $request->input('latitude');
            } else {
                $longitude = NULL;
                $latitude = NULL;
            }

            $absensi = Attendance::create([
                'kode_pegawai' => $kodePegawai,
                'upl' => 0,
                'upl68' => 0,
                'uplm68' => 0,
                'upljam' => 0,
                'jenis' => 'Wajah',
                'waktuori' => now(),
                'status' => 1,
                'jam_masuk' => now(), // Menggunakan helper now() untuk mendapatkan waktu saat ini
                'longitude' => $longitude,
                'latitude' => $latitude,
                'photoURL' => $photoURL,
                'created_at' => now(),
                'verified' => 1,
                'verified_by' => 'System',
                'distance' => 0,
            ]);

            if (!$absensi || !$absensi->exists) {
                throw new Exception('Gagal menyimpan data absensi. Silahkan lakukan absensi ulang.');
            }

            return response()->json(['success' => true, 'message' => 'Attendance recorded successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to record attendance.', 'error' => $e->getMessage()]);
        }
    }

    public function distribution()
    {
        return view('dashboard.map.distribution');
    }

    public function getDistribution()
    {
        $startHour = Carbon::now()->startOfDay();
        $endHour = Carbon::now()->endOfDay();

        return Attendance::select('kode_pegawai', 'longitude', 'latitude')
            ->with('pegawaiRelasi:kode_pegawai,full_name')
            ->whereBetween('created_at', [$startHour, $endHour])
            ->get()
            ->toJson();
    }

    public function todayAttendance()
    {
        return view('dashboard.map.today');
    }
}
