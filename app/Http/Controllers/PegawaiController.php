<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Number;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Attendance;
use App\Models\AttendanceOut;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Golongan;
use App\Models\User;
use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\Collector;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;

class PegawaiController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pegawai-list', ['only' => ['index']]);
        $this->middleware('permission:pegawai-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pegawai-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pegawai-delete', ['only' => ['destroy']]);
        $this->middleware('permission:pegawai-timeline', ['only' => ['timeline']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            function cleanDate($dateString)
            {
                return preg_replace('/\s\(.+\)$/', '', $dateString);
            }
            $minDate = cleanDate($request->input('minDate'));
            $maxDate = cleanDate($request->input('maxDate'));

            $query = Pegawai::with('golonganRelasi', 'jabatanRelasi')
                ->select('id', 'kode_pegawai', 'nik_pegawai', 'full_name', 'no_telp', 'jabatan', 'golongan')->get();

            if ($minDate) {
                $query = $query->where('created_at', '>', Carbon::parse($minDate)->startOfDay());
            }
            if ($maxDate) {
                $query = $query->where('created_at', '<', Carbon::parse($maxDate)->endOfDay());
            }

            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    // $editUrl = route('pegawai.edit', $data->id);
                    $dataUrl = route('pegawai.detail', $data->id);
                    // $timelineUrl = route('pegawai.timeline', $data->id);
                    $actionButtons = '
                <div class="inline-flex text-center" role="group">
                    <a href="' . $dataUrl .
                        '"
                        class="mx-1 text-md font-medium rounded-lg focus:z-10 text-blue-500">
                         &#128203; <span class="hover:underline"> Detail </span>
                    </a>';
                    return $actionButtons;
                })
                ->addColumn('full_name_nik', function ($data) {
                    return '
                        <p class="text-base font-medium">' . $data->full_name . '</p>
                        <p class="text-md"> NIK: ' . $data->nik_pegawai . '</p>';
                })
                ->addColumn('nama_golongan', function ($data) {
                    return $data->golonganRelasi->nama_golongan ?? 'N/A';
                })
                ->addColumn('nama_jabatan', function ($data) {
                    return $data->jabatanRelasi->nama_jabatan ?? 'N/A';
                })
                ->editColumn('no_telp', function ($data) {
                    return $data->no_telp ?? 'N/A';
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'full_name_nik'])
                ->make(true);
        } else {
            return view('dashboard.pegawai.index');
        }
    }

    public function create()
    {
        $jabatan = Jabatan::all();
        $golongan = Golongan::all();
        $roles = Role::pluck('name', 'name')->all();
        return view('dashboard.pegawai.add', compact('jabatan', 'golongan', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_pegawai' => 'required',
            'nik_pegawai' => 'required',
            'full_name' => 'required',
            'nick_name' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'jabatan' => 'required',
            'golongan' => 'required',
            'tgl_lahir' => 'required',
        ]);

        $lastID = Pegawai::latest('id')->first();
        $newID = $lastID ? $lastID->id + 1 : 1;

        Pegawai::create([
            'id' => $newID,
            'kode_pegawai' => $request->input('kode_pegawai'),
            'nik_pegawai' => $request->input('nik_pegawai'),
            'full_name' => $request->input('full_name'),
            'nick_name' => $request->input('nick_name'),
            'no_telp' => $request->input('no_telp'),
            'alamat' => $request->input('alamat'),
            'jabatan' => $request->input('jabatan'),
            'golongan' => $request->input('golongan'),
            'tgl_lahir' => $request->input('tgl_lahir')
        ]);

        $makeUser = $request->input('make_user');
        if ($makeUser == 'y') {
            $user = User::create([
                'kode_pegawai' => $request->input('kode_pegawai'),
                'name' => $request->input('full_name'),
                'email' =>  strtolower($request->input('nick_name')) . $request->input('kode_pegawai') . '@indodacin.com',
                'password' => Hash::make($request->input('kode_pegawai')),
            ]);

            // assign ke role Employee
            // $user->assignRole(7);
            $user->assignRole($request->input('roles'));
        }

        $photo = $request->input('photo1');
        if (!is_null($photo)) {
            $this->saveImages($request);
        }

        return redirect()->route('pegawai.index')->with('status', 'Berhasil menambah data Pegawai');
    }

    public function edit(Pegawai $pegawai)
    {
        $jabatan = Jabatan::all();
        $golongan = Golongan::all();

        $images = $this->showImages($pegawai);

        return view('dashboard.pegawai.edit', compact('pegawai', 'jabatan', 'images', 'golongan'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $pegawai->update([
            'nik_pegawai' => $request->input('nik_pegawai'),
            'full_name' => $request->input('nama_lengkap'),
            'nick_name' => $request->input('nick_name'),
            'no_telp' => $request->input('no_telp'),
            'alamat' => $request->input('alamat'),
            'jabatan' => $request->input('jabatan'),
            'golongan' => $request->input('golongan'),
            'tgl_lahir' => $request->input('tgl_lahir')
        ]);

        $photo = $request->input('photo1');
        if (!is_null($photo)) {
            $request->validate([
                'kode_pegawai' => 'required|exists:tb_pegawai,kode_pegawai',
                'photo1' => 'required|string',
                'photo2' => 'required|string',
            ]);

            $this->saveImages($request);
        }

        return redirect()->route('pegawai.index')->with('status', 'Berhasil mengubah data Pegawai');
    }

    public function autocomplete(Request $request)
    {
        $search = $request->input('query'); // Mengambil input dari request

        // Cari nama pengguna berdasarkan input
        $users = Pegawai::select(['id', 'kode_pegawai', 'full_name'])
            ->where('full_name', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get();

        return response()->json($users); // Kembalikan hasil sebagai JSON
    }

    public function showImages(Pegawai $pegawai)
    {
        $path = public_path('storage/' . $pegawai->storage);
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

    public function getPegawai()
    {
        // cek data pegawai yang kolom storagenya tidak kosong
        $data = Pegawai::whereNotNull('storage')->pluck('kode_pegawai');
        return response()->json($data);
    }

    public function getPegawaiByKode()
    {
        $data = Pegawai::where('kode_pegawai', Auth::user()->kode_pegawai)->pluck('kode_pegawai');
        return response()->json($data);
    }

    public function getPegawaiImages($storage)
    {
        $sanitizedStorage = basename($storage);
        $directoryPath = public_path('storage/labels/' . $sanitizedStorage);

        if (!is_dir($directoryPath)) {
            return response()->json(['error' => 'Directory not found'], 404);
        }

        $images = glob($directoryPath . '\*.{png,jpg,jpeg,webp}', GLOB_BRACE);
        // dd($images);

        if (!empty($images)) {
            $relativeImagePaths = array_map(function ($path) use ($directoryPath) {
                return App::environment('production')
                    // ganti nanti disini juga
                    // ? str_replace(public_path(), '/attendance', $path)
                    ? str_replace(public_path(), '/dev', $path)
                    : str_replace(public_path(), '', $path);
            }, $images);

            // dd($relativeImagePaths);

            return response()->json($relativeImagePaths);
        }
    }

    public function storeImage(Request $request)
    {
        if ($request->hasFile('image') && $request->input('label')) {
            $kodePegawai = $request->input('label');
            $timestamp = getCurrentDate();
            Session::put('current_date', $timestamp);

            $image = $request->file('image');

            $uploadDir = 'labels/' . $kodePegawai . '/capturedImg';
            $imageName = $kodePegawai . $timestamp . '.png';
            $path = $image->move(public_path('storage/' . $uploadDir), $imageName);

            if ($path) {
                $imageUrl = asset('storage/' . $uploadDir . '/' . $imageName);
                return response()->json(['imageUrl' => $imageUrl]);
            } else {
                return response()->json(['error' => 'Failed to save image'], 500);
            }
        } else {
            return response()->json(['error' => 'No image or label received'], 400);
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

    public function checkAttendance(Request $request)
    {
        $kodePegawai = $request->input('kode_pegawai');
        $today = now()->startOfDay();

        $attendance = DB::table('tb_attendance')
            ->where('kode_pegawai', $kodePegawai)
            ->whereDate('jam_masuk', $today)
            ->first();

        return response()->json([
            'hasClockedIn' => $attendance ? true : false,
            'jam_masuk' => $attendance ? $attendance->jam_masuk : null,
        ]);
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

    public function photoRegistProcess(Request $request)
    {
        // Validate the request
        $request->validate([
            'kode_pegawai' => 'required|exists:tb_pegawai,kode_pegawai',
            'photo1' => 'required|string',
            'photo2' => 'required|string',
        ]);

        $this->saveImages($request);
        return redirect()->to(route('landing.page') . '/#Scan')->with('success', 'Data berhasil diperbarui!');
    }

    public function detail($id)
    {
        $pegawai = Pegawai::with('jabatanRelasi')->findOrFail($id);

        // Get the start and end dates for the current month and set locale for formatting
        $currentDate = Carbon::now();
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();
        $startOfMonthFormatted = $startOfMonth->locale('id')->isoFormat('MMMM Y');

        // Create an array of dates with padding for the start day
        $dd = array_fill(0, $startOfMonth->dayOfWeek, null);
        $dd = array_merge($dd, iterator_to_array(CarbonPeriod::create($startOfMonth, $endOfMonth)->map(fn($date) => $date->isoFormat('Y-MM-DD'))));

        // Get attendance data and images
        $attendanceData = Attendance::where('kode_pegawai', $pegawai->kode_pegawai)->get();
        $images = $this->showImages($pegawai);

        return view('dashboard.pegawai.details.personal-info', compact('pegawai', 'dd', 'startOfMonthFormatted', 'images', 'attendanceData'));
    }


    public function attendanceList($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('dashboard.pegawai.details.attendance-list', compact('pegawai'));
    }

    public function payrollInfo($id)
    {
        $pegawai = Pegawai::with('salaryRelasi')->findOrFail($id);
        $allowance = Allowance::where('kode_pegawai', $pegawai->kode_pegawai);
        $deduction = Deduction::where('kode_pegawai', $pegawai->kode_pegawai);

        if (request()->ajax()) {
            $tableType = request()->get('table'); // Retrieve 'allowance' or 'deduction'

            if ($tableType === 'allowance') {
                return Datatables::eloquent($allowance)
                    ->addColumn('actions', function ($data) {
                        return '<button class="text-sm text-blue-500 hover:underline mr-3" id="btn-edit-allowance" data-id="' . $data->id . '">
                                <span class="hover:underline"> Edit </span>
                            </button>
                            <a href="javascript:void(0)" id="btn-delete-allowance" data-id="' . $data->id . '" class="text-sm text-red-500 hover:underline">Hapus</a>
                            ';
                    })
                    ->editColumn('allowance_fee', function ($data) {
                        return Number::currency($data->allowance_fee, 'IDR', 'id');
                    })
                    ->editColumn('allowance_type', function ($data) {
                        return $data->allowance_type <= 100
                            ? $data->allowance_type . ' %'
                            : Number::currency($data->allowance_type, 'IDR', 'id');
                    })
                    ->editColumn('allowance_period', function ($data) {
                        return Carbon::parse($data->allowance_period)->locale('id')->isoFormat('MMMM YYYY');
                    })
                    ->rawColumns(['actions'])
                    ->orderColumn('allowance_name', 'allowance_name asc')
                    ->toJson();
            }

            if ($tableType === 'deduction') {
                return Datatables::eloquent($deduction)
                    ->addColumn('actions', function ($data) {
                        return '<button class="text-sm text-blue-500 hover:underline mr-3" id="btn-edit-deduction" data-id="' . $data->id . '">
                                <span class="hover:underline"> Edit </span>
                            </button>
                            <a href="javascript:void(0)" id="btn-delete-deduction" data-id="' . $data->id . '" class="text-sm text-red-500 hover:underline">Hapus</a>';
                    })
                    ->editColumn('deduction_fee', function ($data) {
                        return Number::currency($data->deduction_fee, 'IDR', 'id');
                    })
                    ->editColumn('deduction_type', function ($data) {
                        return $data->deduction_type <= 100
                            ? $data->deduction_type . ' %'
                            : Number::currency($data->deduction_type, 'IDR', 'id');
                    })
                    ->editColumn('deduction_period', function ($data) {
                        return Carbon::parse($data->deduction_period)->locale('id')->isoFormat('MMMM YYYY');
                    })
                    ->rawColumns(['actions'])
                    ->orderColumn('deduction_name', 'deduction_name asc')
                    ->toJson();
            }
        }

        $allowances = $allowance->get();
        $deductions = $deduction->get();
        return view('dashboard.pegawai.details.payroll-info', compact('pegawai', 'allowances', 'deductions'));
    }

    public function timeline($id, Request $request)
    {
        // Ambil tanggal dari query parameter, atau gunakan tanggal sekarang jika tidak ada
        // $date = $request->query('date') ? Carbon::parse($request->query('date'))->toDateString() : Carbon::now()->toDateString();
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
            $attendances->last()->type = 'Check-out'; // Tandai data terakhir sebagai "Check-out"
        }

        // Mendapatkan informasi pegawai
        $pegawai = Pegawai::select('id', 'kode_pegawai', 'full_name')->where('kode_pegawai', $id)->firstOrFail();


        return view('dashboard.pegawai.details.timeline', compact('attendances', 'pegawai'));
    }

    public function reportCollectors($id, Request $request)
    {
        if ($request->query('date')) {
            $date = Carbon::parse($request->query('date'))->isoFormat('YYYY-MM-DD');
        } else {
            $date = Carbon::today(); // Ambil tanggal dari query string

        }

        $pegawai = Pegawai::where('kode_pegawai', $id)->firstOrFail();
        $report = Collector::where('kode_pegawai', $id)
            ->whereDate('created_at', $date)
            ->get();

        // Kembalikan view dengan data $pegawai
        return view('dashboard.pegawai.details.laporan', compact('pegawai', 'report'));
    }

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
}
