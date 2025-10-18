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
use Illuminate\Support\Facades\DB;
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
        // validasi input awal
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'keterangan' => 'required|string|min:10',
            'status' => 'required|integer',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
            'timezone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Terjadi kegagalan.', $validator->errors()->first());
        }

        $user = Auth::user();
        $kode_pegawai = $user->kode_pegawai;
        $user_id = $user->id;
        $no_vt = '';

        // cek user tanpa relasi pegawai
        if (User::where('kode_pegawai', $kode_pegawai)->whereDoesntHave('pegawai')->exists()) {
            return new ApiResource(false, 'Terjadi kegagalan.', 'Akun pegawai untuk user ini tidak ditemukan.');
        }

        // cek apakah pegawai sudah punya foto selfie
        $pegawai = Pegawai::where('kode_pegawai', $kode_pegawai)->first();
        if (!$pegawai || !$pegawai->storage) {
            return new ApiResource(false, 'Terjadi kegagalan.', 'Foto selfie belum diatur.');
        }

        if (!$request->has('image') || empty($request->image)) {
            return new ApiResource(false, 'Terjadi kegagalan.', 'Image data is required.');
        }

        DB::beginTransaction();

        try {
            // simpan foto sementara
            $img_path = "public/labels/{$kode_pegawai}/_temp/";
            $filename = $kode_pegawai . "_" . getCurrentDate();

            if (!$request->image->storeAs($img_path, $filename . ".png")) {
                return new ApiResource(false, 'Terjadi kegagalan.', 'Gagal menyimpan gambar.');
            }

            // cek apakah absen masuk sudah dilakukan
            $existing = Attendance::where('kode_pegawai', $kode_pegawai)
                ->where('status', 1)
                ->whereDate('created_at', now()->toDateString())
                ->first();

            $isKeluar = $existing ? true : false;
            $modelClass = $isKeluar ? AttendanceOut::class : Attendance::class;
            $absenType = $isKeluar ? 'AttendanceOut' : 'Attendance';
            $jamField = $isKeluar ? 'jam_keluar' : 'jam_masuk';
            $waktuori = Carbon::now($request->timezone);

            // data absensi
            $absenData = [
                'kode_pegawai' => $kode_pegawai,
                'upl' => 0,
                'upl68' => 0,
                'uplm68' => 0,
                'upljam' => 0,
                'jenis' => 'Wajah',
                'waktuori' => $waktuori,
                'timezone' => $request->timezone,
                'status' => 0, // status = pending/diajukan
                $jamField => now(),
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'photoURL' => $filename,
                'keterangan' => $request->keterangan,
                'position_status' => $request->status,
            ];

            if (preg_match('/\bVT\s*-?\s*(\d+)\b/i', $request->keterangan, $m)) {
                $no_vt = 'VT-' . $m[1];  // vt123123123 → VT-123123123
            }

            // simpan data absen (masuk/keluar)
            $absen = $modelClass::create($absenData);

            if (!$absen || !$absen->exists) {
                DB::rollBack();
                return new ApiResource(false, 'Terjadi kegagalan.', 'Gagal menyimpan data absensi. Silahkan lakukan absensi ulang.');
            }

            DB::commit();

            // kirim ke job pengenalan wajah
            ProcessFaceRecognition::dispatch(
                $absenType,
                $absen->id,
                $img_path,
                $user_id,
                $kode_pegawai,
                $filename . '.png',
                $no_vt
            );

            return new ApiResource(true, 'Verifikasi absensi sedang diproses...', 'Silahkan menunggu beberapa saat.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in verify attendance: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => $user_id
            ]);

            return new ApiResource(false, 'Terjadi kegagalan.', $e->getMessage());
        }
    }

    protected function formatNomorDokumen($input)
    {
        // Hapus spasi di awal/akhir
        $input = trim($input);

        // Hilangkan semua spasi di dalam input
        $input = preg_replace('/\s+/', '', $input);

        // Pastikan format menjadi VT-XXXXX
        // Ganti 'VT' diikuti angka langsung menjadi 'VT-' + angka
        $input = preg_replace('/^VT-?(\d+)$/i', 'VT-$1', $input);

        return strtoupper($input); // pastikan huruf besar
    }
}
