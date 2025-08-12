<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AllowanceController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceOutController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CaptureController;
use App\Http\Controllers\CollectController;
use App\Http\Controllers\CollectIdyPpnController;
use App\Http\Controllers\CollectTaskController;
use App\Http\Controllers\CollectTaskPpnController;
use App\Http\Controllers\DayoffController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\LoghistoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProxyController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TechnicianPointsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Report\CollectorReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// turn off for a while, redirect to dashboard
Route::middleware('throttle:high')->get('/', function () {
    // return view('home', ['title' => 'Take attendance']);
    return redirect('login');
})->name('landing.page');

Route::middleware('throttle:high')->get('photo-regist', function () {
    return view('regist', ['title' => 'Register your face.']);
})->name('photo.regist');

// route bisa diakses jika login
Route::middleware(['auth'])->group(function () {
    // notifikasi
    Route::get('notifications/{id}/mark-as-read', function ($id) {
        $notification = Auth::user()->unreadNotifications->find($id);
        $notification->markAsRead();
        return back()->with('success', 'Notification has readed');
    })->name('notification.mark-as-read');
    Route::get('notifications/fetch', [NotificationController::class, 'fetch'])->name('notification.fetch');

    // export
    Route::prefix('export')->as('')->group(function () {
        // laporan kolektor
        Route::get('collector/', [CollectorReportController::class, 'export'])->name('export.collector');

        Route::get('collector/{filename}', function (string $filename) {
            return Storage::download("export/$filename");
        })->name('export.collector.download');
        // end laporan kolektor

        // laporan sales
        Route::get('sales/{filename}', function (string $filename) {
            return Storage::download("export/$filename");
        })->name('export.sales.download');
    });

    Route::prefix('proxy')->as('')->group(function () {
        // fetchSR IDC NON PPN
        Route::get('idc/tagihan', [ProxyController::class, 'fetchIDCNon'])->name('fetch.idc.nonppn');

        // fetchSR IDC PPN
        Route::get('idc/ppn', [ProxyController::class, 'fetchIDCPpn'])->name('fetch.idc.ppn');

        // fetchSR IDY PPN
        Route::get('idy/ppn', [ProxyController::class, 'fetchIDYPpn'])->name('fetch.idy.ppn');

        // fetchVT
        Route::get('get/vt', [ProxyController::class, 'getVT'])->name('fetch.vt');
        Route::get('get/vt-db', [TechnicianController::class, 'getVTFromDB'])->name('fetch.vt-db');
    });

    // group ke rute dashboard.
    Route::prefix('dashboard')->as('')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('me', [ProfileController::class, 'show'])->name('profile.me');
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
        Route::get('capture/route', [CaptureController::class, 'route'])->name('capture.route');

        // route salesman
        Route::resource('sales', SalesController::class)->except(['store', 'update', 'destroy']);

        // route technician
        Route::resource('technician', TechnicianController::class);
        Route::get('technician/fetch/update/{id}', [TechnicianController::class, 'fetchUpdate'])->name('technician.fetch.update');

        // route collect 
        // tampilkan semua data where status = 0 (belum dilengkapi)
        Route::get('collect/show', [CollectController::class, 'showdata'])->name('collect.showdata');
        // tampilkan semua data where status = 1 (approved)
        Route::get('collect/approved', [CollectController::class, 'approved'])->name('collect.approved');
        // tampilkan semua data where status = 2 (diajukan)
        Route::get('collect/submitted', [CollectController::class, 'submitted'])->name('collect.submitted');
        // tampilkan semua data where status = 3 (ditolak)
        Route::get('collect/rejected', [CollectController::class, 'rejected'])->name('collect.rejected');
        // tampilkan semua data where status = 4 (perlu revisi)
        Route::get('collect/revision', [CollectController::class, 'revision'])->name('collect.revision');
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

        // route collect task ppn (idc ppn)
        // tampilkan semua data where assign_to = null
        Route::get('collect-task-ppn/show', [CollectTaskPpnController::class, 'showdata'])->name('collect-task-ppn.showdata');
        // tampilkan semua data where status = 1 (berjalan)
        Route::get('collect-task-ppn/on-progress', [CollectTaskPpnController::class, 'onProgress'])->name('collect-task-ppn.onprogress');
        // tampilkan semua data where status = 2 (selesai)
        Route::get('collect-task-ppn/completed', [CollectTaskPpnController::class, 'completed'])->name('collect-task-ppn.completed');
        // tampilkan semua data where status = 3 (tertunda)
        Route::get('collect-task-ppn/pending', [CollectTaskPpnController::class, 'pending'])->name('collect-task-ppn.pending');
        // route collect task
        Route::get('collect-task-ppn/autocomplete', [CollectTaskPpnController::class, 'autocomplete'])->name('collect-task-ppn.autocomplete');
        Route::get('collect-task-ppn/assign', [CollectTaskPpnController::class, 'assign'])->name('collect-task-ppn.assign');
        Route::get('collect-task-ppn/mass-assign', [CollectTaskPpnController::class, 'massAssign'])->name('collect-task-ppn.mass-assign');
        Route::resource('collect-task-ppn', CollectTaskPpnController::class)->except(['store', 'update', 'destroy']);

        // route collect idy ppn
        // tampilkan semua data where assign_to = null
        Route::get('collect-idy-ppn/show', [CollectIdyPpnController::class, 'showdata'])->name('collect-idy-ppn.showdata');
        // tampilkan semua data where status = 1 (berjalan)
        Route::get('collect-idy-ppn/on-progress', [CollectIdyPpnController::class, 'onProgress'])->name('collect-idy-ppn.onprogress');
        // tampilkan semua data where status = 2 (selesai)
        Route::get('collect-idy-ppn/completed', [CollectIdyPpnController::class, 'completed'])->name('collect-idy-ppn.completed');
        // tampilkan semua data where status = 3 (tertunda)
        Route::get('collect-idy-ppn/pending', [CollectIdyPpnController::class, 'pending'])->name('collect-idy-ppn.pending');
        // route collect idy
        Route::get('collect-idy-ppn/autocomplete', [CollectIdyPpnController::class, 'autocomplete'])->name('collect-idy-ppn.autocomplete');
        Route::get('collect-idy-ppn/assign', [CollectIdyPpnController::class, 'assign'])->name('collect-idy-ppn.assign');
        Route::get('collect-idy-ppn/mass-assign', [CollectIdyPpnController::class, 'massAssign'])->name('collect-idy-ppn.mass-assign');
        Route::resource('collect-idy-ppn', CollectIdyPpnController::class)->except(['store', 'update', 'destroy']);

        // route dayoff
        Route::post('dayoff/upload-image', [DayoffController::class, 'uploadImage'])->name('dayoff.uploadimage');
        Route::resource('dayoff', DayoffController::class)->except(['store', 'update', 'destroy']);

        // route announcement
        Route::resource('announcement', AnnouncementController::class)->only(['index']);

        // route permission
        Route::resource('permissions', PermissionController::class)
            ->only('index', 'create', 'edit');

        // route roles
        Route::resource('roles', RoleController::class)
            ->only('index', 'create', 'edit');

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

        // route driver
        Route::resource('driver', DriverController::class)
            ->only('index', 'show', 'create', 'edit');
        Route::get('driver/assign/add', [DriverController::class, 'assignAddView'])->name('driver.assign.add');
        Route::get('driver/assign/to/{id}', [DriverController::class, 'assignToView'])->name('driver.assign.to');
        Route::get('driver/assign/update/{id}', [DriverController::class, 'assignUpdateView'])->name('driver.assign.update');

        // route kuesioner
        Route::resource('kuesioner', QuestionnaireController::class)
            ->only('index', 'show', 'create', 'edit');

        // route pegawai
        Route::get('pegawai/autocomplete/', [PegawaiController::class, 'autocomplete'])->name('pegawai.autocomplete');
        Route::get('pegawai/{pegawai}/detail', [PegawaiController::class, 'detail'])->name('pegawai.detail');
        Route::get('pegawai/attendance', [PegawaiController::class, 'getAttendanceDate'])->name('pegawai.get.attendance.date');
        Route::get('pegawai/{pegawai}/payroll', [PegawaiController::class, 'payrollInfo'])->name('pegawai.payrollinfo');
        Route::get('pegawai/{pegawai}/attendance', [PegawaiController::class, 'attendance'])->name('pegawai.attendance');
        Route::get('pegawai/{pegawai}/timeline', [PegawaiController::class, 'timeline'])->name('pegawai.timeline');
        Route::get('pegawai/{pegawai}/collectors', [PegawaiController::class, 'reportCollectors'])->name('pegawai.collectors');
        Route::get('pegawai/{pegawai}/sales', [PegawaiController::class, 'reportSales'])->name('pegawai.sales');
        Route::resource('pegawai', PegawaiController::class);

        // route pegawai allowance & deductions
        Route::resource('pegawai/allowances', AllowanceController::class);
        Route::resource('pegawai/deductions', DeductionController::class);

        // backup
        Route::resource('backup', BackupController::class)->only('index');
        Route::get('backup/download/{id}', [BackupController::class, 'download'])->name('backup.download');

        // routes
        Route::get('routes/driver', [RouteController::class, 'driver'])->name('routes.driver');
        Route::get('routes/driver/{pegawai}', [RouteController::class, 'detailDriver'])->name('routes.driver.detail');

        Route::get('routes/collector', [RouteController::class, 'collector'])->name('routes.collector');
        Route::get('routes/collector/{pegawai}', [RouteController::class, 'detailCollector'])->name('routes.collector.detail');

        Route::get('routes/sales', [RouteController::class, 'sales'])->name('routes.sales');
        Route::get('routes/sales/{pegawai}', [RouteController::class, 'detailSales'])->name('routes.sales.detail');

        // points
        Route::get('points', [TechnicianPointsController::class, 'index'])->name('points.index');
        Route::get('points/withdraw', [TechnicianPointsController::class, 'redeem'])->name('points.redeem');
        Route::get('points/transactions', [TechnicianPointsController::class, 'transactions'])->name('technicianpoints.transactions');
        Route::get('points/transactions/{transaction_id}', [TechnicianPointsController::class, 'detail'])->name('technicianpoints.transactionDetail');

        // map distribution
        Route::get('map/distribution', [AttendanceController::class, 'distribution'])->name('map.distribution');

        // todays attendance
        Route::get('attendance/today', [AttendanceController::class, 'todayAttendance'])->name('today.attendance');

        // teams
        Route::resource('teams', TeamController::class)->only('index', 'create', 'edit');
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

// buat ping
Route::get('ping', function () {
    $targetUrl = 'https://indodacin.nusa.net.id/webmail/src/login.php';

    try {
        \Illuminate\Support\Facades\Http::timeout(5)->get($targetUrl);
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false], 500);
    }
})->name('ping.checker');
