<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceOut;
use App\Models\Collector;
use App\Models\Pegawai;
use App\Models\Sales;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pegawai-list|pegawai-create|pegawai-edit|pegawai-delete|pegawai-timeline', ['only' => ['index', 'create', 'edit', 'destroy', 'timeline']]);
    }

    public function index()
    {
        return view('dashboard.pegawai.index');
    }

    public function create()
    {
        return view('dashboard.pegawai.add');
    }

    public function edit(Pegawai $pegawai)
    {
        return view('dashboard.pegawai.edit', compact('pegawai'));
    }

    public function storeImage(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'], // Maks 5MB
            'label' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        try {
            $kodePegawai = $request->input('label');
            $timestamp = getCurrentDate();

            // Menyimpan state ke session
            Session::put('current_date', $timestamp);

            $file = $request->file('image');
            $uploadDir = "labels/{$kodePegawai}/capturedImg";
            $imageName = "{$kodePegawai}{$timestamp}.png";

            // Menggunakan facade Storage disk public standar Laravel agar path konsisten
            $path = $file->storeAs($uploadDir, $imageName, 'public');

            if (! $path) {
                return response()->json(['error' => 'Gagal menyimpan file gambar di sistem penyimpanan.'], 500);
            }

            return response()->json([
                'imageUrl' => asset("storage/{$path}"),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan sistem saat mencoba menyimpan gambar.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function autocomplete(Request $request)
    {
        $search = $request->input('query'); // Mengambil input dari request

        // Cari nama pengguna berdasarkan input
        $users = Pegawai::select(['id', 'kode_pegawai', 'full_name'])
            ->where('full_name', 'LIKE', "%{$search}%")
            ->limit(5)
            ->get();

        return response()->json($users); // Kembalikan hasil sebagai JSON
    }

    public function showImages(Pegawai $pegawai)
    {
        $path = public_path('storage/'.$pegawai->storage);

        if (! is_dir($path)) {
            $images[] = asset('img/noImage.webp');
            $images[] = asset('img/noImage.webp');

            return $images;
        }

        $files = File::files($path);

        $images = [];

        foreach ($files as $file) {
            $extension = strtolower($file->getExtension());
            if (in_array($extension, ['png'])) {
                $images[] = $file->getFilename();
            }
        }

        return $images;
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::where('kode_pegawai', $id)->first();
        $pegawai->delete();

        return redirect()->back()->with('status', 'Berhasil menghapus data pegawai.');
    }

    public function getEmployeeByKodePegawai($kode_pegawai)
    {
        $pegawai = Pegawai::where('kode_pegawai', $kode_pegawai)->first();

        if ($pegawai) {
            return response()->json($pegawai);
        } else {
            return response()->json(['error' => 'Employee not found'], 404);
        }
    }

    public function getPegawaiByCode()
    {
        $data = Pegawai::where('kode_pegawai', Auth::user()->kode_pegawai)->pluck('kode_pegawai');

        return response()->json($data);
    }

    public function detail(Request $request, $id)
    {
        $pegawai = Pegawai::with('jabatanRelasi:id,nama_jabatan')->findOrFail($id);

        if ($request->has('period')) {
            $currentDate = Carbon::parse($request->query('period'));
        } else {
            $currentDate = Carbon::now();
        }

        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        // Create an array of dates with padding for the start day
        $dd = array_fill(0, $startOfMonth->dayOfWeek, null);
        $dd = array_merge($dd, iterator_to_array(CarbonPeriod::create($startOfMonth, $endOfMonth)->map(fn ($date) => $date->isoFormat('Y-MM-DD'))));

        // Get attendance data and images
        $attendanceData = Attendance::where('kode_pegawai', $pegawai->kode_pegawai)->get();
        $images = $this->showImages($pegawai);

        return view('dashboard.pegawai.details.personal-info', compact('pegawai', 'dd', 'images', 'attendanceData'));
    }

    public function attendance($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        return view('dashboard.pegawai.details.attendance', compact('pegawai'));
    }

    public function timeline($id, Request $request)
    {
        // Ambil tanggal dari query parameter, atau gunakan tanggal sekarang jika tidak ada
        if ($request->query('date')) {
            $date = Carbon::parse($request->query('date'))->isoFormat('YYYY-MM-DD');
        } else {
            $date = Carbon::today(); // Ambil tanggal dari query string
        }

        // Query untuk data Check-out
        $dataCheckout = AttendanceOut::query() // Ensure it's a query builder
            ->select('latitude', 'longitude', 'created_at', 'photoURL', 'jam_keluar', DB::raw("'Checkpoint' as type"), 'jam_keluar as time')
            ->whereDate('jam_keluar', $date)
            ->where('kode_pegawai', $id);

        // Query untuk data Check-in
        $dataCheckin = Attendance::query() // Ensure it's a query builder
            ->select('latitude', 'longitude', 'created_at', 'photoURL', 'jam_masuk', DB::raw("'Check-in' as type"), 'jam_masuk as time')
            ->whereDate('jam_masuk', $date)
            ->where('kode_pegawai', $id);

        // Gabungkan kedua query menggunakan `unionAll`
        $attendances = $dataCheckin->unionAll($dataCheckout)
            ->orderBy('created_at') // Urutkan berdasarkan waktu (created_at, bisa diganti dengan time jika perlu)
            ->get();

        if ($attendances->isNotEmpty()) {
            if ($attendances->count() > 1) {
                $attendances->last()->type = 'Check-out'; // Tandai data terakhir sebagai "Check-out"
            }

            $attendances->first()->type = 'Check-in'; // Tandai data pertama sebagai "Check-in"
        }

        // Mendapatkan informasi pegawai
        $pegawai = Pegawai::select('id', 'kode_pegawai', 'full_name')->where('kode_pegawai', $id)->firstOrFail();

        return view('dashboard.pegawai.details.timeline', compact('attendances', 'pegawai'));
    }

    public function reportCollectors($id, Request $request)
    {
        $date = $request->query('date') ?? Carbon::today()->format('Y-m-d');

        $pegawai = Pegawai::where('kode_pegawai', $id)->firstOrFail();
        $report = Collector::with('pegawaiRelasi')->where('kode_pegawai', $id)
            ->whereDate('assign_date', $date)
            ->get();

        // Kembalikan view dengan data $pegawai
        return view('dashboard.pegawai.details.laporan', compact('pegawai', 'report'));
    }

    public function reportSales($id, Request $request)
    {
        if ($request->query('date')) {
            $date = Carbon::parse($request->query('date'))->isoFormat('YYYY-MM-DD');
        } else {
            $date = Carbon::today(); // Ambil tanggal dari query string

        }

        $pegawai = Pegawai::where('kode_pegawai', $id)->firstOrFail();

        $report = Sales::where('kode_pegawai', $id)
            ->whereDate('created_at', $date)
            ->get();

        // Kembalikan view dengan data $pegawai
        return view('dashboard.pegawai.details.laporan-sales', compact('pegawai', 'report'));
    }
}
