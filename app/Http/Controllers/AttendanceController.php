<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('dashboard.attendanceIn.view');
    }

    public function storeAttendance(Request $request)
    {
        try {
            // Strictly enforce Auth identity to prevent client-side spoofing
            if (! Auth::check()) {
                throw new Exception('Anda belum login atau sesi telah berakhir.');
            }

            $kodePegawai = Auth::user()->kode_pegawai;

            if ($request->has('longitude') && $request->input('longitude') !== 'null') {
                $longitude = $request->input('longitude');
                $latitude = $request->input('latitude');
            } else {
                $longitude = null;
                $latitude = null;
            }

            // Validasi file gambar dari request
            if (! $request->hasFile('image')) {
                throw new Exception('Gambar tidak ditemukan dalam request.');
            }

            $file = $request->file('image');
            $timestamp = now()->timestamp;
            $photoURL = $kodePegawai.$timestamp;

            $uploadDir = "labels/{$kodePegawai}/capturedImg";
            $imageName = "{$photoURL}.png";

            // Simpan gambar secara lokal dahulu
            $path = $file->storeAs($uploadDir, $imageName, 'public');

            if (! $path) {
                throw new Exception('Gagal menyimpan file gambar di sistem penyimpanan.');
            }

            // Gunakan Transaction untuk rollback jika gagal database
            \Illuminate\Support\Facades\DB::beginTransaction();

            $absensi = Attendance::create([
                'kode_pegawai' => $kodePegawai,
                'upl' => 0,
                'upl68' => 0,
                'uplm68' => 0,
                'upljam' => 0,
                'jenis' => 'Wajah',
                'waktuori' => now(),
                'status' => 1,
                'jam_masuk' => now(), // Memastikan penggunaan server time
                'longitude' => $longitude,
                'latitude' => $latitude,
                'photoURL' => $photoURL,
                'created_at' => now(),
                'verified' => 1,
                'verified_by' => 'System',
                'distance' => 0,
            ]);

            if (! $absensi || ! $absensi->exists) {
                throw new Exception('Gagal menyimpan data absensi.');
            }

            \Illuminate\Support\Facades\DB::commit();

            return response()->json(['success' => true, 'message' => 'Attendance recorded successfully.', 'imageUrl' => asset("storage/{$path}")]);
        } catch (Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();

            // Hapus gambar jika database gagal dan gambar terlanjur disave
            if (isset($path) && \Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
            }

            return response()->json(['success' => false, 'message' => 'Failed to record attendance. '.$e->getMessage()]);
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
