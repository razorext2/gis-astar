<?php

use App\Http\Controllers\DayoffController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceOutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\LoghistoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CaptureController;
use App\Http\Controllers\AllowanceController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\CollectController;
use App\Http\Controllers\CollectTaskController;
use App\Http\Controllers\Report\CollectorReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

// breeze for regist, verif, login and logout
// Route::get('/foo', function () {
//     Artisan::call('storage:link');
// });

// landing page
// turn off for a while, redirect to dashboard
Route::get('/', function () {
    return view('home', ['title' => 'Take attendance']);
    // return redirect('login');
})->name('landing.page');

Route::get('photo-regist', function () {
    return view('regist', ['title' => 'Register your face.']);
})->name('photo.regist');

// route bisa diakses jika login
Route::middleware('auth')->group(function () {
    // notifikasi
    Route::get('notifications/{id}/mark-as-read', function ($id) {
        $notification = Auth::user()->unreadNotifications->find($id);
        $notification->markAsRead();
        return back()->with('success', 'Notification has readed');
    })->name('notification.mark-as-read');

    // export
    Route::prefix('export')->as('')->group(function () {
        // laporan kolektor
        Route::get('collector/', [CollectorReportController::class, 'export'])->name('export.collector');

        Route::get('collector/{filename}', function (String $filename) {
            return Storage::download("export/$filename");
        })->name('export.collector.download');
        // end laporan kolektor
    });

    Route::prefix('proxy')->as('')->group(function () {
        // fetchSR IDC NON PPN
        Route::get('fetchSR', function (Request $request) {
            $no_sr = $request->query('no_sr');

            if (!$no_sr) {
                return response()->json([
                    'error' => 'No. SR is required.'
                ], 400);
            }

            $url = "https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchSR&NomorPermintaanJual=" . $no_sr;

            try {
                $response = Http::get($url);

                if ($response->successful()) {
                    return $response->json(); // Return the JSON response directly
                }

                return response()->json([
                    'error' => 'Failed to fetch data from external API.',
                    'status' => $response->status(),
                    'body' => $response->body()
                ], $response->status());
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while processing the request.',
                    'message' => $e->getMessage()
                ], 500);
            }
        });

        // fetchSR IDC PPN

        // fetchSR IDY NON PPN

        // fetchSR IDY PPN
    });

    // group ke rute dashboard.
    Route::prefix('dashboard')->as('')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // notifikasi
        Route::resource('notifications', NotificationController::class)->only(['index']);
        Route::get('notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');

        // attendanceIn
        Route::get('attendanceIn', [AttendanceController::class, 'index'])->name('attendanceIn.index');

        // attendanceOut
        Route::get('attendanceOut', [AttendanceOutController::class, 'index'])->name('attendanceOut.index');

        // log
        Route::get('log', [LoghistoryController::class, 'index'])->name('log.index');

        // record attendance
        Route::get('capture', [CaptureController::class, 'index'])->name('capture.index');

        // route collect 
        // tampilkan semua data where status = 0 (belum dilengkapi)
        Route::get('collect/show', [CollectController::class, 'showdata'])->name('collect.showdata');
        // tampilkan semua data where status = 1 (approved)
        Route::get('collect/approved', [CollectController::class, 'approved'])->name('collect.approved');
        // tampilkan semua data where status = 2 (diajukan)
        Route::get('collect/submitted', [CollectController::class, 'submitted'])->name('collect.submitted');
        // tampilkan semua data where status = 3 (ditolak)
        Route::get('collect/rejected', [CollectController::class, 'rejected'])->name('collect.rejected');
        // route kolektor
        Route::resource('collect', CollectController::class)->except(['store', 'update', 'destroy']);

        // route collect task
        // tampilkan semua data where assign_to = null
        Route::get('collect-task/show', [CollectTaskController::class, 'showdata'])->name('collect-task.showdata');
        // tampilkan semua data where status = 1 (berjalan)
        Route::get('collect-task/on-progress', [CollectTaskController::class, 'onProgress'])->name('collect-task.onprogress');
        // tampilkan semua data where status = 2 (selesai)
        Route::get('collect-task/completed', [CollectTaskController::class, 'completed'])->name('collect-task.completed');
        // tampilkan semua data where status = 3 (tertunda)
        Route::get('collect-task/pending', [CollectTaskController::class, 'pending'])->name('collect-task.pending');
        // route collect task
        Route::get('collect-task/autocomplete', [CollectTaskController::class, 'autocomplete'])->name('collect-task.autocomplete');
        Route::get('collect-task/assign', [CollectTaskController::class, 'assign'])->name('collect-task.assign');
        Route::get('collect-task/mass-assign', [CollectTaskController::class, 'massAssign'])->name('collect-task.mass-assign');
        Route::resource('collect-task', CollectTaskController::class)->except(['store', 'update', 'destroy']);

        // route dayoff
        Route::post('dayoff/upload-image', [DayoffController::class, 'uploadImage'])->name('dayoff.uploadimage');
        Route::resource('dayoff', DayoffController::class)->except(['store', 'update', 'destroy']);

        // route permission
        Route::resource('permissions', PermissionController::class);

        // route roles
        Route::resource('roles', RoleController::class);

        // route users
        Route::resource('users', UserController::class);

        // route golongan
        Route::resource('golongan', GolonganController::class);

        // route placement
        Route::resource('placement', PlacementController::class);

        // route division
        Route::resource('division', DivisionController::class);

        // route jabatan
        Route::resource('jabatan', JabatanController::class);

        // route pegawai
        Route::get('pegawai/autocomplete/', [PegawaiController::class, 'autocomplete'])->name('pegawai.autocomplete');
        Route::get('pegawai/{pegawai}/detail', [PegawaiController::class, 'detail'])->name('pegawai.detail');
        Route::get('pegawai/attendance', [PegawaiController::class, 'getAttendanceDate'])->name('pegawai.get.attendance.date');
        Route::get('pegawai/{pegawai}/attendance', [PegawaiController::class, 'attendanceList'])->name('pegawai.attendancelist');
        Route::get('pegawai/{pegawai}/payroll', [PegawaiController::class, 'payrollInfo'])->name('pegawai.payrollinfo');
        Route::get('pegawai/{pegawai}/timeline', [PegawaiController::class, 'timeline'])->name('pegawai.timeline');
        Route::get('pegawai/{pegawai}/collectors', [PegawaiController::class, 'reportCollectors'])->name('pegawai.collectors');
        Route::resource('pegawai', PegawaiController::class);

        // route pegawai allowance & deductions
        Route::resource('pegawai/allowances', AllowanceController::class);
        Route::resource('pegawai/deductions', DeductionController::class);
    });
});

require __DIR__ . '/auth.php';

// api for get pegawai data
Route::get('api/getPegawai/{id}', [PegawaiController::class, 'getPegawaiByCode']);
Route::post('api/saveImage', [PegawaiController::class, 'storeImage']);

// absen
Route::post('store-attendance', [AttendanceController::class, 'storeAttendance']);
Route::post('store-attendance-out', [AttendanceOutController::class, 'storeAttendance']);

// route untuk manipulasi url pemanggilan foto
$libs = sha1('libs');

Route::get('/' . $libs . '/{filename}', function ($filename) {
    $directories = Storage::directories('public/labels');

    $filePath = null;

    foreach ($directories as $directory) {
        $fullpath = $directory . '/capturedImg/' . $filename;

        if (Storage::exists($fullpath)) {
            $filePath = $fullpath;
            break;
        }
    }

    if ($filePath) {
        return Storage::response($filePath);
    } else {
        abort(404);
    }
})->where('filename', '.*');
