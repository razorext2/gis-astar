<?php

/** Goal: Main Web Routing File, Caller: ServiceProvider, Deps: Many Controllers, features/*.php */

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceOutController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BigEventController;
use App\Http\Controllers\CaptureController;
use App\Http\Controllers\CollectController;
use App\Http\Controllers\CollectIdyPpnController;
use App\Http\Controllers\CollectTaskController;
use App\Http\Controllers\CollectTaskPpnController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\LoghistoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProxyController;
use App\Http\Controllers\PushController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ServerOverviewController;
use App\Http\Controllers\Spk\DailyReportController;
use App\Http\Controllers\Spk\ProductionController;
use App\Http\Controllers\Spk\ProductionHistoriesController;
use App\Http\Controllers\Spk\PurchasingRequestController;
use App\Http\Controllers\Spk\SpkController;
use App\Http\Controllers\System\HolidayController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TechnicianPointsController;
use App\Http\Controllers\UserController;
use App\Livewire\Chatbot\Chatbot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// Route::get('/company', function () {
//     return view('company', ['title' => 'PT. Indodacin Presisi Utama']);
// })->name('company.profile');

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
    // subrektion
    Route::post('/push-subscribe', [PushController::class, 'subscribe']);

    // notifikasi
    Route::get('notifications/{id}/mark-as-read', function ($id) {
        $notification = Auth::user()->unreadNotifications->find($id);
        $notification->markAsRead();

        return back()->with('success', 'Notification has readed');
    })->name('notification.mark-as-read');
    Route::get('notifications/fetch', [NotificationController::class, 'fetch'])->name('notification.fetch');

    // export
    Route::prefix('export')->as('')->group(function () {
        // laporan poin teknisi
        Route::get('point/{filename}', function (string $filename) {
            $path = "export/point/{$filename}";
            abort_unless(Storage::exists($path), 404);

            return Storage::download($path);
        })->where('filename', '[a-zA-Z0-9\-_.]+')->name('export.point.download');

        // laporan report (generic)
        Route::get('report/{filename}', function (string $filename) {
            $path = "export/report/{$filename}";
            abort_unless(Storage::exists($path), 404);

            return Storage::download($path);
        })->where('filename', '[a-zA-Z0-9\-_.]+')->name('export.report.download');
    });

    Route::prefix('proxy')->as('')->group(function () {
        // fetchGlances
        Route::get('glances/{id}', [ProxyController::class, 'fetchGlances'])->name('proxy.glances');

        // fetchSR IDC NON PPN
        Route::get('idc/tagihan', [ProxyController::class, 'fetchIDCNon'])->name('fetch.idc.nonppn');

        // fetchSR IDC PPN
        Route::get('idc/ppn', [ProxyController::class, 'fetchIDCPpn'])->name('fetch.idc.ppn');

        // fetchSR IDY PPN
        Route::get('idy/ppn', [ProxyController::class, 'fetchIDYPpn'])->name('fetch.idy.ppn');

        // fetchVT
        Route::get('get/vt', [ProxyController::class, 'getVT'])->name('fetch.vt');
        Route::get('get/vt-db', [TechnicianController::class, 'getVTFromDB'])->name('fetch.vt-db');

        // github commit
        Route::get('commit', function () {
            $response = Http::withToken(env('GITHUB_TOKEN'))
                ->get('https://api.github.com/repos/razorext2/faceAttendanceV2/commits');

            $commits = $response->json();

            return $commits;
        });
    });

    // group ke rute dashboard.
    Route::prefix('dashboard')->as('')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('chatbot', Chatbot::class)->name('chatbot.index')->middleware('permission:ai-chatbot');
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
        Route::resource('collect-idy-ppn', CollectIdyPpnController::class)->except(['store', 'update', 'destroy']);

        // route announcement
        Route::resource('announcement', AnnouncementController::class)->only(['index', 'create', 'edit']);

        // route permission
        Route::resource('permissions', PermissionController::class)
            ->only('index', 'create', 'edit');

        // route roles
        Route::resource('roles', RoleController::class)
            ->only('index', 'create', 'edit');

        // route users
        Route::resource('users', UserController::class)->except('store', 'update');

        // route golongan
        Route::resource('golongan', GolonganController::class);

        // route placement
        Route::resource('placement', PlacementController::class);

        // route division
        Route::resource('division', DivisionController::class);

        // route jabatan
        Route::resource('jabatan', JabatanController::class);

        // route libur nasional
        Route::get('system/holidays', [HolidayController::class, 'index'])->name('system.holidays.index');

        // route driver
        Route::resource('driver', DriverController::class)
            ->only('index', 'show', 'create', 'edit');
        Route::get('driver/assign/add', [DriverController::class, 'assignAddView'])->name('driver.assign.add');
        Route::get('driver/assign/to/{id}', [DriverController::class, 'assignToView'])->name('driver.assign.to');
        Route::get('driver/assign/update/{id}', [DriverController::class, 'assignUpdateView'])->name('driver.assign.update');

        // route pegawai
        Route::get('pegawai/autocomplete/', [PegawaiController::class, 'autocomplete'])->name('pegawai.autocomplete');
        Route::get('pegawai/{pegawai}/detail', [PegawaiController::class, 'detail'])->name('pegawai.detail');
        Route::get('pegawai/attendance', [PegawaiController::class, 'getAttendanceDate'])->name('pegawai.get.attendance.date');
        Route::get('pegawai/{pegawai}/attendance', [PegawaiController::class, 'attendance'])->name('pegawai.attendance');
        Route::get('pegawai/{pegawai}/timeline', [PegawaiController::class, 'timeline'])->name('pegawai.timeline');
        Route::get('pegawai/{pegawai}/collectors', [PegawaiController::class, 'reportCollectors'])->name('pegawai.collectors');
        Route::get('pegawai/{pegawai}/sales', [PegawaiController::class, 'reportSales'])->name('pegawai.sales');
        Route::resource('pegawai', PegawaiController::class)->except('store', 'update');

        // backup
        Route::resource('backup', BackupController::class)->only('index');
        Route::get('backup/download/{id}', [BackupController::class, 'download'])->name('backup.download');

        // server overview
        Route::get('server-overview', [ServerOverviewController::class, 'index'])->name('server.overview')->middleware('permission:manage-server');

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

        // invoice
        Route::prefix('invoice')->group(function () {
            // semua
            Route::prefix('all')->name('invoice.all.')->group(function () {
                Route::get('/', [InvoiceController::class, 'index'])->name('index');
                Route::get('/create', [InvoiceController::class, 'create'])->name('create');
                Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
                Route::get('/add/{id}', [InvoiceController::class, 'addDetails'])->name('addDetails');
            });

            // cust langsung
            Route::prefix(prefix: 'cust')->name('invoice.cust.')->group(function () {
                Route::get('/', [InvoiceController::class, 'index'])->name('index');
                Route::get('/create', [InvoiceController::class, 'create'])->name('create');
                Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
                Route::get('/add/{id}', [InvoiceController::class, 'addDetails'])->name('addDetails');
            });

            // medan
            Route::prefix('medan')->name('invoice.medan.')->group(function () {
                Route::get('/', [InvoiceController::class, 'index'])->name('index');
                Route::get('/create', [InvoiceController::class, 'create'])->name('create');
                Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
                Route::get('/add/{id}', [InvoiceController::class, 'addDetails'])->name('addDetails');
            });

            // pku
            Route::prefix('pku')->name('invoice.pku.')->group(function () {
                Route::get('/', [InvoiceController::class, 'indexPku'])->name('index');
                Route::get('/create', [InvoiceController::class, 'create'])->name('create');
                Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
                Route::get('/{id}/add', [InvoiceController::class, 'addDetails'])->name('addDetails');
            });

            // jkt
            Route::prefix('jkt')->name('invoice.jkt.')->group(function () {
                Route::get('/', [InvoiceController::class, 'indexJkt'])->name('index');
                Route::get('/create', [InvoiceController::class, 'create'])->name('create');
                Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
                Route::get('/{id}/add', [InvoiceController::class, 'addDetails'])->name('addDetails');
            });
        });

        // ini untuk event
        Route::get('event/{event}/participant/{participant}', [BigEventController::class, 'participantDetails'])->name('event.participant.show');
        Route::delete('event/{event}/participant/{participant}', [BigEventController::class, 'participantDelete'])->name('event.participant.delete');
        Route::resource('event', BigEventController::class);

        Route::prefix('spk')->as('')->group(function () {
            // 1. spk purchasing request
            Route::resource('purchasing-request', PurchasingRequestController::class)->only('index', 'edit', 'show');
            Route::get('purchasing-request/{id}/edit-pr', [PurchasingRequestController::class, 'editPr'])->name('purchasing-request.edit-pr');

            // 2. spk spk
            Route::get('generate/pdf/{id}', [SpkController::class, 'generatePdf'])->name('spk.generate.pdf');
            Route::get('stream/pdf/spk', [SpkController::class, 'streamPdf'])->name('spk.pdf');
            Route::get('download/{id}', [SpkController::class, 'download'])->name('spk.download');
            Route::get('attachment/download/{path}', [SpkController::class, 'attachmentDownload'])
                ->where('path', '.*')
                ->name('spk.attachment.download');
            Route::resource('spk', SpkController::class)->only('index', 'create', 'show', 'edit');

            // 3. spk produksi
            Route::get('production/{production}/packing-list/create', [ProductionController::class, 'packingListCreate'])->name('production.packing-list.add');
            Route::get('production/{production}/packing-list/kits/{idbarang}/create', [ProductionController::class, 'packingListKits'])->name('production.packing-list.kits.add');
            Route::get('stream/pdf/packing-list', [ProductionController::class, 'streamPackingListPdf'])->name('packing-list.pdf');
            Route::get('production/{id}/history/create', [ProductionHistoriesController::class, 'create'])->name('production.history.add');
            Route::resource('production', ProductionController::class)->only('index', 'show');

            // 4. penagihan
            Route::get('billing', [SpkController::class, 'billingIndex'])->name('billing.index');
            Route::get('billing/{id}/update', [SpkController::class, 'billingEdit'])->name('billing.edit');

            // 5. delivery
            Route::get('delivery', [SpkController::class, 'deliveryIndex'])->name('delivery.index');
            Route::get('delivery/{id}/update', [SpkController::class, 'deliveryEdit'])->name('delivery.edit');

            // 6. laporan harian
            Route::get('daily-report', [DailyReportController::class, 'index'])->name('daily-report.index');
            Route::get('daily-report/assign', [DailyReportController::class, 'assign'])->name('daily-report.assign');
            Route::get('daily-report/{id}/index', [DailyReportController::class, 'daily'])->name('daily-report.daily');
            Route::get('daily-report/{id}/customer-assignment', [DailyReportController::class, 'customerAssignment'])->name('daily-report.daily.customer-assignment');
            Route::get('daily-report/{id}/{hourly}/detail', [DailyReportController::class, 'hourly'])->name('daily-report.hourly');
            Route::get('stream/pdf/laporan-harian/{assignmentId}', [DailyReportController::class, 'streamLaporanHarianPdf'])->name('daily-report.pdf.stream');
            Route::get('stream/pdf/laporan-harian/download/{id}', [DailyReportController::class, 'downloadDailyReportPdf'])->name('daily-report.pdf.download');
        });

        // 6.1 laporan harian no spk
        Route::get('daily-report/general', [DailyReportController::class, 'general'])->name('report.general.index');
        Route::get('daily-report/general/assign', [DailyReportController::class, 'generalAssign'])->name('report.general.assign');
        Route::get('daily-report/general/{id}/index', [DailyReportController::class, 'generalDaily'])->name('report.general.daily');
        Route::get('daily-report/general/{id}/customer-assignment', [DailyReportController::class, 'generalCustomerAssignment'])->name('report.general.customer-assignment');
        Route::get('daily-report/general/{id}/{hourly}/detail', [DailyReportController::class, 'generalHourly'])->name('report.general.hourly');

        // route pengajuan cuti
        require __DIR__.'/features/leave-request.php';

        // route inquiry absensi
        require __DIR__.'/features/attendance-inquiry.php';

        // route laporan export
        require __DIR__.'/features/report.php';
    });
});

require __DIR__.'/auth.php';

// api for get pegawai data
Route::get('api/getPegawai/{id}', [PegawaiController::class, 'getPegawaiByCode']);
Route::post('api/saveImage', [PegawaiController::class, 'storeImage']);

// absen
Route::post('store-attendance', [AttendanceController::class, 'storeAttendance']);
Route::post('store-attendance-out', [AttendanceOutController::class, 'storeAttendance']);

// route untuk manipulasi url pemanggilan foto
$libs = sha1('libs');

Route::get('/'.$libs.'/{filename}', function ($filename) {
    $directories = Storage::directories('public/labels');

    $filePath = null;

    foreach ($directories as $directory) {
        $fullpath = $directory.'/capturedImg/'.$filename;

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
        Http::timeout(5)->get($targetUrl);

        return response()->json(['success' => true]);
    } catch (Exception $e) {
        return response()->json(['success' => false], 500);
    }
})->name('ping.checker');

// offline page
Route::get('/offline', function () {
    return view('vendor.laravelpwa.offline');
});

// stream gambar
Route::get('/file/{path}', function ($path) {
    abort_unless(Storage::exists($path), 404);

    return Storage::response($path);
})->where('path', '.*')->name('file.show');
