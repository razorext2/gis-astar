<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\AttendanceOut;
// use App\Models\Logabsensi;
use Illuminate\Support\Facades\Auth;

class AttendanceOutController extends Controller
{

    public function index()
    {
        if (Auth::check() && is_null(Auth::user()->kode_pegawai)) {

            $datas = AttendanceOut::with('pegawaiRelasi')->orderByDesc('jam_keluar')->get();
        } else {
            $datas = AttendanceOut::with('pegawaiRelasi')
                ->where('kode_pegawai', Auth::user()->kode_pegawai)
                ->orderByDesc('jam_keluar')
                ->get();
        }

        return view('dashboard.attendanceOut.view', compact('datas'));
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

            AttendanceOut::create([
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
            ]);

            return response()->json(['success' => true, 'message' => 'Clock-out recorded successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to record attendance.', 'error' => $e->getMessage()]);
        }
    }
}
