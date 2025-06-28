<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Jobs\ProcessFaceRecognition;
use App\Models\Attendance;
use App\Models\AttendanceOut;
use App\Models\Pegawai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'required|string',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Terjadi kegagalan.', $validator->errors()->first());
        }

        // check user
        $user = User::where('kode_pegawai', Auth::user()->kode_pegawai)
            ->whereDoesntHave('pegawai')
            ->first();

        if ($user !== null) {
            return new ApiResource(false, 'Terjadi kegagalan.', 'Akun pegawai untuk user ini tidak ditemukan.');
        }

        // check foto selfie
        $pegawai = Pegawai::where('kode_pegawai', Auth::user()->kode_pegawai)
            ->first();

        if ($pegawai->storage === null) {
            return new ApiResource(false, 'Terjadi kegagalan.', 'Foto selfie belum diatur.');
        }

        // inisialisasi kode pegawai
        $kode_pegawai = Auth::user()->kode_pegawai;
        $user_id = Auth::user()->id;

        // validasi kode pegawai
        if ($kode_pegawai === null) {
            return new ApiResource(false, 'Terjadi kegagalan.', 'Kode pegawai kosong');
        }

        try {
            // validasi request
            if (!$request->has('image') || empty($request->image)) {
                return new ApiResource(false, 'Terjadi kegagalan.', 'Image data is required.');
            }

            $img_path = "public/labels/{$kode_pegawai}/_temp/";
            $filename = $kode_pegawai . "_" . getCurrentDate();

            // simpan gambar sementara
            if (!$request->image->storeAs($img_path, $filename . ".png")) {
                return new ApiResource(false, 'Terjadi kegagalan.', 'Failed to save temporary image.');
            }

            // tambah data
            $data = Attendance::where('kode_pegawai', $kode_pegawai)
                ->whereDate('created_at', now()->toDateString())
                ->first();

            if ($data) {
                $out = AttendanceOut::create([
                    'kode_pegawai' => $kode_pegawai,
                    'upl' => 0,
                    'upl68' => 0,
                    'uplm68' => 0,
                    'upljam' => 0,
                    'jenis' => 'Wajah',
                    'waktuori' => now(),
                    'status' => 1,
                    'jam_keluar' => now(),
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                    'photoURL' => $filename,
                    'keterangan' => $request->keterangan,
                ]);

                // jalankan job
                ProcessFaceRecognition::dispatch('AttendanceOut', $out->id, $img_path, $user_id, $kode_pegawai, $filename . ".png");
            } else {
                $in = Attendance::create([
                    'kode_pegawai' => $kode_pegawai,
                    'upl' => 0,
                    'upl68' => 0,
                    'uplm68' => 0,
                    'upljam' => 0,
                    'jenis' => 'Wajah',
                    'waktuori' => now(),
                    'status' => 1,
                    'jam_masuk' => now(),
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                    'photoURL' => $filename,
                    'keterangan' => $request->keterangan,
                ]);

                // jalankan job
                ProcessFaceRecognition::dispatch('Attendance', $in->id, $img_path, $user_id, $kode_pegawai, $filename . ".png");
            }

            return new ApiResource(true, 'Absensi berhasil dilakukan.', 'Hasil verifikasi akan muncul dalam beberapa saat.');
        } catch (\Exception $e) {
            Log::error('Error in verify attendance: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id()
            ]);

            return new ApiResource(false, 'Terjadi kegagalan.', $e->getMessage());
        }
    }
}
