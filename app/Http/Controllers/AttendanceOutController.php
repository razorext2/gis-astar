<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\AttendanceOut;
use Exception;

class AttendanceOutController extends Controller
{

    public function index()
    {
        return view('dashboard.attendanceOut.view');
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

            $absensi = AttendanceOut::create([
                'kode_pegawai' => $kodePegawai,
                'upl' => 0,
                'upl68' => 0,
                'uplm68' => 0,
                'upljam' => 0,
                'jenis' => 'Wajah',
                'waktuori' => now(),
                'status' => 1,
                'jam_keluar' => now(), // Menggunakan helper now() untuk mendapatkan waktu saat ini
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

            return response()->json(['success' => true, 'message' => 'Clock-out recorded successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to record attendance.', 'error' => $e->getMessage()]);
        }
    }
}
