<?php

/** Goal: Main Web Routing File, Caller: ServiceProvider, Deps: Many Controllers, features/*.php */

use App\Http\Controllers\InvoiceController;
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
    // subrektion
    Route::post('/push-subscribe', [\App\Http\Controllers\PushController::class, 'subscribe']);

    // notifikasi
    Route::get('notifications/{id}/mark-as-read', function ($id) {
        $notification = Auth::user()->unreadNotifications->find($id);
        $notification->markAsRead();

        return back()->with('success', 'Notification has readed');
    })->name('notification.mark-as-read');
    Route::get('notifications/fetch', [\App\Http\Controllers\NotificationController::class, 'fetch'])->name('notification.fetch');

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
        Route::get('glances/{id}', [\App\Http\Controllers\ProxyController::class, 'fetchGlances'])->name('proxy.glances');

        // fetchSR IDC NON PPN
        Route::get('idc/tagihan', [\App\Http\Controllers\ProxyController::class, 'fetchIDCNon'])->name('fetch.idc.nonppn');

        // fetchSR IDC PPN
        Route::get('idc/ppn', [\App\Http\Controllers\ProxyController::class, 'fetchIDCPpn'])->name('fetch.idc.ppn');

        // fetchSR IDY PPN
        Route::get('idy/ppn', [\App\Http\Controllers\ProxyController::class, 'fetchIDYPpn'])->name('fetch.idy.ppn');

        // fetchVT
        Route::get('get/vt', [\App\Http\Controllers\ProxyController::class, 'getVT'])->name('fetch.vt');
        Route::get('get/vt-db', [\App\Http\Controllers\TechnicianController::class, 'getVTFromDB'])->name('fetch.vt-db');

        // github commit
        Route::get('commit', function () {
            $response = Illuminate\Support\Facades\Http::withToken(env('GITHUB_TOKEN'))
                ->get('https://api.github.com/repos/razorext2/faceAttendanceV2/commits');

            $commits = $response->json();

            return $commits;
        });
    });

    // group ke rute dashboard.
    Route::prefix('dashboard')->as('')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
        Route::get('chatbot', \App\Livewire\Chatbot\Chatbot::class)->name('chatbot.index');
        Route::get('me', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.me');
        Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

        // notifikasi
        Route::resource('notifications', \App\Http\Controllers\NotificationController::class)->only(['index']);
        Route::get('notifications/mark-all-as-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');

        // attendanceIn
        Route::get('attendanceIn', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('attendanceIn.index');

        // attendanceOut
        Route::get('attendanceOut', [\App\Http\Controllers\AttendanceOutController::class, 'index'])->name('attendanceOut.index');

        // log
        Route::get('log', [\App\Http\Controllers\LoghistoryController::class, 'index'])->name('log.index');

        // record attendance
        Route::get('capture', [\App\Http\Controllers\CaptureController::class, 'index'])->name('capture.index');
        Route::get('capture/route', [\App\Http\Controllers\CaptureController::class, 'route'])->name('capture.route');

        // route salesman
        Route::resource('sales', \App\Http\Controllers\SalesController::class)->except(['store', 'update', 'destroy']);

        // route technician
        Route::resource('technician', \App\Http\Controllers\TechnicianController::class);
        Route::get('technician/fetch/update/{id}', [\App\Http\Controllers\TechnicianController::class, 'fetchUpdate'])->name('technician.fetch.update');

        // route collect
        // tampilkan semua data where status = 0 (belum dilengkapi)
        Route::get('collect/show', [\App\Http\Controllers\CollectController::class, 'showdata'])->name('collect.showdata');
        // tampilkan semua data where status = 1 (approved)
        Route::get('collect/approved', [\App\Http\Controllers\CollectController::class, 'approved'])->name('collect.approved');
        // tampilkan semua data where status = 2 (diajukan)
        Route::get('collect/submitted', [\App\Http\Controllers\CollectController::class, 'submitted'])->name('collect.submitted');
        // tampilkan semua data where status = 3 (ditolak)
        Route::get('collect/rejected', [\App\Http\Controllers\CollectController::class, 'rejected'])->name('collect.rejected');
        // tampilkan semua data where status = 4 (perlu revisi)
        Route::get('collect/revision', [\App\Http\Controllers\CollectController::class, 'revision'])->name('collect.revision');
        // route kolektor
        Route::resource('collect', \App\Http\Controllers\CollectController::class)->except(['store', 'update', 'destroy']);

        // route collect task
        // tampilkan semua data where assign_to = null
        Route::get('collect-task/show', [\App\Http\Controllers\CollectTaskController::class, 'showdata'])->name('collect-task.showdata');
        // tampilkan semua data where status = 1 (berjalan)
        Route::get('collect-task/on-progress', [\App\Http\Controllers\CollectTaskController::class, 'onProgress'])->name('collect-task.onprogress');
        // tampilkan semua data where status = 2 (selesai)
        Route::get('collect-task/completed', [\App\Http\Controllers\CollectTaskController::class, 'completed'])->name('collect-task.completed');
        // tampilkan semua data where status = 3 (tertunda)
        Route::get('collect-task/pending', [\App\Http\Controllers\CollectTaskController::class, 'pending'])->name('collect-task.pending');
        // route collect task
        Route::get('collect-task/autocomplete', [\App\Http\Controllers\CollectTaskController::class, 'autocomplete'])->name('collect-task.autocomplete');
        Route::get('collect-task/assign', [\App\Http\Controllers\CollectTaskController::class, 'assign'])->name('collect-task.assign');
        Route::resource('collect-task', \App\Http\Controllers\CollectTaskController::class)->except(['store', 'update', 'destroy']);

        // route collect task ppn (idc ppn)
        // tampilkan semua data where assign_to = null
        Route::get('collect-task-ppn/show', [\App\Http\Controllers\CollectTaskPpnController::class, 'showdata'])->name('collect-task-ppn.showdata');
        // tampilkan semua data where status = 1 (berjalan)
        Route::get('collect-task-ppn/on-progress', [\App\Http\Controllers\CollectTaskPpnController::class, 'onProgress'])->name('collect-task-ppn.onprogress');
        // tampilkan semua data where status = 2 (selesai)
        Route::get('collect-task-ppn/completed', [\App\Http\Controllers\CollectTaskPpnController::class, 'completed'])->name('collect-task-ppn.completed');
        // tampilkan semua data where status = 3 (tertunda)
        Route::get('collect-task-ppn/pending', [\App\Http\Controllers\CollectTaskPpnController::class, 'pending'])->name('collect-task-ppn.pending');
        // route collect task
        Route::get('collect-task-ppn/autocomplete', [\App\Http\Controllers\CollectTaskPpnController::class, 'autocomplete'])->name('collect-task-ppn.autocomplete');
        Route::get('collect-task-ppn/assign', [\App\Http\Controllers\CollectTaskPpnController::class, 'assign'])->name('collect-task-ppn.assign');
        Route::resource('collect-task-ppn', \App\Http\Controllers\CollectTaskPpnController::class)->except(['store', 'update', 'destroy']);

        // route collect idy ppn
        // tampilkan semua data where assign_to = null
        Route::get('collect-idy-ppn/show', [\App\Http\Controllers\CollectIdyPpnController::class, 'showdata'])->name('collect-idy-ppn.showdata');
        // tampilkan semua data where status = 1 (berjalan)
        Route::get('collect-idy-ppn/on-progress', [\App\Http\Controllers\CollectIdyPpnController::class, 'onProgress'])->name('collect-idy-ppn.onprogress');
        // tampilkan semua data where status = 2 (selesai)
        Route::get('collect-idy-ppn/completed', [\App\Http\Controllers\CollectIdyPpnController::class, 'completed'])->name('collect-idy-ppn.completed');
        // tampilkan semua data where status = 3 (tertunda)
        Route::get('collect-idy-ppn/pending', [\App\Http\Controllers\CollectIdyPpnController::class, 'pending'])->name('collect-idy-ppn.pending');
        // route collect idy
        Route::get('collect-idy-ppn/autocomplete', [\App\Http\Controllers\CollectIdyPpnController::class, 'autocomplete'])->name('collect-idy-ppn.autocomplete');
        Route::get('collect-idy-ppn/assign', [\App\Http\Controllers\CollectIdyPpnController::class, 'assign'])->name('collect-idy-ppn.assign');
        Route::resource('collect-idy-ppn', \App\Http\Controllers\CollectIdyPpnController::class)->except(['store', 'update', 'destroy']);

        // route announcement
        Route::resource('announcement', \App\Http\Controllers\AnnouncementController::class)->only(['index']);

        // route permission
        Route::resource('permissions', \App\Http\Controllers\PermissionController::class)
            ->only('index', 'create', 'edit');

        // route roles
        Route::resource('roles', \App\Http\Controllers\RoleController::class)
            ->only('index', 'create', 'edit');

        // route users
        Route::resource('users', \App\Http\Controllers\UserController::class)->except('store', 'update');

        // route golongan
        Route::resource('golongan', \App\Http\Controllers\GolonganController::class);

        // route placement
        Route::resource('placement', \App\Http\Controllers\PlacementController::class);

        // route division
        Route::resource('division', \App\Http\Controllers\DivisionController::class);

        // route jabatan
        Route::resource('jabatan', \App\Http\Controllers\JabatanController::class);

        // route libur nasional
        Route::get('system/holidays', [\App\Http\Controllers\System\HolidayController::class, 'index'])->name('system.holidays.index');

        // route driver
        Route::resource('driver', \App\Http\Controllers\DriverController::class)
            ->only('index', 'show', 'create', 'edit');
        Route::get('driver/assign/add', [\App\Http\Controllers\DriverController::class, 'assignAddView'])->name('driver.assign.add');
        Route::get('driver/assign/to/{id}', [\App\Http\Controllers\DriverController::class, 'assignToView'])->name('driver.assign.to');
        Route::get('driver/assign/update/{id}', [\App\Http\Controllers\DriverController::class, 'assignUpdateView'])->name('driver.assign.update');

        // route pegawai
        Route::get('pegawai/autocomplete/', [\App\Http\Controllers\PegawaiController::class, 'autocomplete'])->name('pegawai.autocomplete');
        Route::get('pegawai/{pegawai}/detail', [\App\Http\Controllers\PegawaiController::class, 'detail'])->name('pegawai.detail');
        Route::get('pegawai/attendance', [\App\Http\Controllers\PegawaiController::class, 'getAttendanceDate'])->name('pegawai.get.attendance.date');
        Route::get('pegawai/{pegawai}/attendance', [\App\Http\Controllers\PegawaiController::class, 'attendance'])->name('pegawai.attendance');
        Route::get('pegawai/{pegawai}/timeline', [\App\Http\Controllers\PegawaiController::class, 'timeline'])->name('pegawai.timeline');
        Route::get('pegawai/{pegawai}/collectors', [\App\Http\Controllers\PegawaiController::class, 'reportCollectors'])->name('pegawai.collectors');
        Route::get('pegawai/{pegawai}/sales', [\App\Http\Controllers\PegawaiController::class, 'reportSales'])->name('pegawai.sales');
        Route::resource('pegawai', \App\Http\Controllers\PegawaiController::class)->except('store', 'update');

        // backup
        Route::resource('backup', \App\Http\Controllers\BackupController::class)->only('index');
        Route::get('backup/download/{id}', [\App\Http\Controllers\BackupController::class, 'download'])->name('backup.download');

        // server overview
        Route::get('server-overview', [\App\Http\Controllers\ServerOverviewController::class, 'index'])->name('server.overview')->middleware('permission:manage-server');

        // routes
        Route::get('routes/driver', [\App\Http\Controllers\RouteController::class, 'driver'])->name('routes.driver');
        Route::get('routes/driver/{pegawai}', [\App\Http\Controllers\RouteController::class, 'detailDriver'])->name('routes.driver.detail');

        Route::get('routes/collector', [\App\Http\Controllers\RouteController::class, 'collector'])->name('routes.collector');
        Route::get('routes/collector/{pegawai}', [\App\Http\Controllers\RouteController::class, 'detailCollector'])->name('routes.collector.detail');

        Route::get('routes/sales', [\App\Http\Controllers\RouteController::class, 'sales'])->name('routes.sales');
        Route::get('routes/sales/{pegawai}', [\App\Http\Controllers\RouteController::class, 'detailSales'])->name('routes.sales.detail');

        // points
        Route::get('points', [\App\Http\Controllers\TechnicianPointsController::class, 'index'])->name('points.index');
        Route::get('points/withdraw', [\App\Http\Controllers\TechnicianPointsController::class, 'redeem'])->name('points.redeem');
        Route::get('points/transactions', [\App\Http\Controllers\TechnicianPointsController::class, 'transactions'])->name('technicianpoints.transactions');
        Route::get('points/transactions/{transaction_id}', [\App\Http\Controllers\TechnicianPointsController::class, 'detail'])->name('technicianpoints.transactionDetail');

        // map distribution
        Route::get('map/distribution', [\App\Http\Controllers\AttendanceController::class, 'distribution'])->name('map.distribution');

        // todays attendance
        Route::get('attendance/today', [\App\Http\Controllers\AttendanceController::class, 'todayAttendance'])->name('today.attendance');

        // teams
        Route::resource('teams', \App\Http\Controllers\TeamController::class)->only('index', 'create', 'edit');

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
        Route::get('event/{event}/participant/{participant}', [\App\Http\Controllers\BigEventController::class, 'participantDetails'])->name('event.participant.show');
        Route::delete('event/{event}/participant/{participant}', [\App\Http\Controllers\BigEventController::class, 'participantDelete'])->name('event.participant.delete');
        Route::resource('event', \App\Http\Controllers\BigEventController::class);

        Route::prefix('spk')->as('')->group(function () {
            // 1. spk purchasing request
            Route::resource('purchasing-request', \App\Http\Controllers\Spk\PurchasingRequestController::class)->only('index', 'edit', 'show');

            // 2. spk spk
            Route::get('generate/pdf/{id}', [\App\Http\Controllers\Spk\SpkController::class, 'generatePdf'])->name('spk.generate.pdf');
            Route::get('stream/pdf/spk', [\App\Http\Controllers\Spk\SpkController::class, 'streamPdf'])->name('spk.pdf');
            Route::get('download/{id}', [\App\Http\Controllers\Spk\SpkController::class, 'download'])->name('spk.download');
            Route::get('attachment/download/{path}', [\App\Http\Controllers\Spk\SpkController::class, 'attachmentDownload'])
                ->where('path', '.*')
                ->name('spk.attachment.download');
            Route::resource('spk', \App\Http\Controllers\Spk\SpkController::class)->only('index', 'create', 'show', 'edit');

            // 3. spk produksi
            Route::get('production/{production}/packing-list/create', [\App\Http\Controllers\Spk\ProductionController::class, 'packingListCreate'])->name('production.packing-list.add');
            Route::get('production/{production}/packing-list/kits/{idbarang}/create', [\App\Http\Controllers\Spk\ProductionController::class, 'packingListKits'])->name('production.packing-list.kits.add');
            Route::get('stream/pdf/packing-list', [\App\Http\Controllers\Spk\ProductionController::class, 'streamPackingListPdf'])->name('packing-list.pdf');
            Route::get('production/{id}/history/create', [\App\Http\Controllers\Spk\ProductionHistoriesController::class, 'create'])->name('production.history.add');
            Route::resource('production', \App\Http\Controllers\Spk\ProductionController::class)->only('index', 'show');

            // 4. penagihan
            Route::get('billing', [\App\Http\Controllers\Spk\SpkController::class, 'billingIndex'])->name('billing.index');
            Route::get('billing/{id}/update', [\App\Http\Controllers\Spk\SpkController::class, 'billingEdit'])->name('billing.edit');

            // 5. delivery
            Route::get('delivery', [\App\Http\Controllers\Spk\SpkController::class, 'deliveryIndex'])->name('delivery.index');
            Route::get('delivery/{id}/update', [\App\Http\Controllers\Spk\SpkController::class, 'deliveryEdit'])->name('delivery.edit');

            // 6. laporan harian
            Route::get('daily-report', [\App\Http\Controllers\Spk\DailyReportController::class, 'index'])->name('daily-report.index');
            Route::get('daily-report/assign', [\App\Http\Controllers\Spk\DailyReportController::class, 'assign'])->name('daily-report.assign');
            Route::get('daily-report/{id}/index', [\App\Http\Controllers\Spk\DailyReportController::class, 'daily'])->name('daily-report.daily');
            Route::get('daily-report/{id}/customer-assignment', [\App\Http\Controllers\Spk\DailyReportController::class, 'customerAssignment'])->name('daily-report.daily.customer-assignment');
            Route::get('daily-report/{id}/{hourly}/detail', [\App\Http\Controllers\Spk\DailyReportController::class, 'hourly'])->name('daily-report.hourly');
            Route::get('stream/pdf/laporan-harian/{assignmentId}', [\App\Http\Controllers\Spk\DailyReportController::class, 'streamLaporanHarianPdf'])->name('daily-report.pdf.stream');
            Route::get('stream/pdf/laporan-harian/download/{id}', [\App\Http\Controllers\Spk\DailyReportController::class, 'downloadDailyReportPdf'])->name('daily-report.pdf.download');
        });

        // 6.1 laporan harian no spk
        Route::get('daily-report/general', [\App\Http\Controllers\Spk\DailyReportController::class, 'general'])->name('report.general.index');
        Route::get('daily-report/general/assign', [\App\Http\Controllers\Spk\DailyReportController::class, 'generalAssign'])->name('report.general.assign');
        Route::get('daily-report/general/{id}/index', [\App\Http\Controllers\Spk\DailyReportController::class, 'generalDaily'])->name('report.general.daily');
        Route::get('daily-report/general/{id}/customer-assignment', [\App\Http\Controllers\Spk\DailyReportController::class, 'generalCustomerAssignment'])->name('report.general.customer-assignment');
        Route::get('daily-report/general/{id}/{hourly}/detail', [\App\Http\Controllers\Spk\DailyReportController::class, 'generalHourly'])->name('report.general.hourly');

        // route pengajuan cuti
        require __DIR__.'/features/leave-request.php';

        // route laporan export
        require __DIR__.'/features/report.php';
    });
});

require __DIR__.'/auth.php';

// api for get pegawai data
Route::get('api/getPegawai/{id}', [\App\Http\Controllers\PegawaiController::class, 'getPegawaiByCode']);
Route::post('api/saveImage', [\App\Http\Controllers\PegawaiController::class, 'storeImage']);

// absen
Route::post('store-attendance', [\App\Http\Controllers\AttendanceController::class, 'storeAttendance']);
Route::post('store-attendance-out', [\App\Http\Controllers\AttendanceOutController::class, 'storeAttendance']);

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
        \Illuminate\Support\Facades\Http::timeout(5)->get($targetUrl);

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
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
