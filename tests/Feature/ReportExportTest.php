<?php

/** Goal: Feature tests untuk fitur Laporan Export, Caller: pest, Deps: User, Permission, ReportExportJob */

use App\Jobs\ExportReportJob;
use App\Livewire\Handler\Report\ExportAbsensi;
use App\Livewire\Handler\Report\ExportCuti;
use App\Livewire\Handler\Report\ExportDriver;
use App\Livewire\Handler\Report\ExportInvoice;
use App\Livewire\Handler\Report\ExportKolektor;
use App\Livewire\Handler\Report\ExportPiutang;
use App\Livewire\Handler\Report\ExportSales;
use App\Livewire\Handler\Report\ExportSpk;
use App\Models\CollectTask;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    $allPermissions = [
        'attendance-approve', 'leave-view-all', 'collect-approve',
        'invoice-add', 'spk-create', 'driver-approve', 'sales-approve',
    ];

    foreach ($allPermissions as $perm) {
        Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
    }

    $this->adminUser = User::factory()->create(['is_active' => true]);
    $this->adminUser->givePermissionTo($allPermissions);
});

/*
|--------------------------------------------------------------------------
| Route Access Tests
|--------------------------------------------------------------------------
*/

$reportRoutes = [
    ['report.export.absensi', 'attendance-approve'],
    ['report.export.cuti', 'leave-view-all'],
    ['report.export.piutang', 'collect-approve'],
    ['report.export.kolektor', 'collect-approve'],
    ['report.export.invoice', 'invoice-add'],
    ['report.export.spk', 'spk-create'],
    ['report.export.driver', 'driver-approve'],
    ['report.export.sales', 'sales-approve'],
];

foreach ($reportRoutes as [$route, $permission]) {
    $routeName = str_replace('report.export.', '', $route);

    it("can access laporan {$routeName} page with permission", function () use ($route) {
        $this->actingAs($this->adminUser)
            ->get(route($route))
            ->assertSuccessful();
    });

    it("cannot access laporan {$routeName} page without permission", function () use ($route) {
        $userWithoutPerm = User::factory()->create(['is_active' => true]);

        $response = $this->actingAs($userWithoutPerm)
            ->get(route($route));

        expect($response->status())->toBeIn([302, 403]);
    });
}

/*
|--------------------------------------------------------------------------
| Livewire Component Tests
|--------------------------------------------------------------------------
*/

$components = [
    ['ExportAbsensi', ExportAbsensi::class],
    ['ExportCuti', ExportCuti::class],
    ['ExportPiutang', ExportPiutang::class],
    ['ExportKolektor', ExportKolektor::class],
    ['ExportInvoice', ExportInvoice::class],
    ['ExportSpk', ExportSpk::class],
    ['ExportDriver', ExportDriver::class],
    ['ExportSales', ExportSales::class],
];

foreach ($components as [$name, $class]) {
    it("{$name} can render with default dates", function () use ($class) {
        $this->actingAs($this->adminUser);

        Livewire::test($class)
            ->assertSet('fromDate', now()->startOfWeek()->toDateString())
            ->assertSet('toDate', now()->startOfWeek()->addDays(5)->toDateString())
            ->assertSet('exportFormat', 'xlsx')
            ->assertStatus(200);
    });

    it("{$name} can set quick date periods", function () use ($class) {
        $this->actingAs($this->adminUser);

        Livewire::test($class)
            ->call('showDaily')
            ->assertSet('fromDate', now()->startOfDay()->toDateString())
            ->call('showWeekly')
            ->assertSet('fromDate', now()->startOfWeek()->toDateString())
            ->call('showMonthly')
            ->assertSet('fromDate', now()->startOfMonth()->toDateString())
            ->call('showYearly')
            ->assertSet('fromDate', now()->startOfYear()->toDateString());
    });

    it("{$name} dispatches export job on valid submit", function () use ($class) {
        Queue::fake();
        $this->actingAs($this->adminUser);

        Livewire::test($class)
            ->set('fromDate', '2026-01-01')
            ->set('toDate', '2026-01-31')
            ->call('export');

        Queue::assertPushed(ExportReportJob::class);
    });

    it("{$name} validates required dates", function () use ($class) {
        $this->actingAs($this->adminUser);

        Livewire::test($class)
            ->set('fromDate', '')
            ->set('toDate', '')
            ->call('export')
            ->assertHasErrors(['fromDate', 'toDate']);
    });
}

it('can successfully run ExportReportJob and send notification for absensi', function () {
    \Illuminate\Support\Facades\Notification::fake();
    \Illuminate\Support\Facades\Event::fake();
    \Illuminate\Support\Facades\Storage::fake();

    $pegawai = \App\Models\Pegawai::create([
        'kode_pegawai' => 315,
        'full_name' => 'Oky',
        'nick_name' => 'Oky',
        'nik_pegawai' => '123456',
    ]);

    $attendance = \App\Models\Attendance::create([
        'kode_pegawai' => 315,
        'jam_masuk' => now(),
        'jenis' => 'WFO',
        'status' => 1,
        'verified' => 1,
    ]);

    $job = new ExportReportJob(
        userId: $this->adminUser->id,
        reportType: 'absensi',
        fromDate: now()->startOfMonth()->toDateString(),
        toDate: now()->endOfMonth()->toDateString(),
        filterBy: 'kode_pegawai',
        filterValue: '315',
        exportFormat: 'xlsx'
    );

    $job->handle();

    \Illuminate\Support\Facades\Notification::assertSentTo(
        $this->adminUser,
        \App\Notifications\ReportExportCompleted::class
    );
});

it('can successfully run ExportReportJob for check-out and standalone filters', function () {
    \Illuminate\Support\Facades\Notification::fake();
    \Illuminate\Support\Facades\Event::fake();
    \Illuminate\Support\Facades\Storage::fake();

    $pegawai = \App\Models\Pegawai::create([
        'kode_pegawai' => 315,
        'full_name' => 'Oky',
        'nick_name' => 'Oky',
        'nik_pegawai' => '123456',
    ]);

    $attendanceOut = \App\Models\AttendanceOut::create([
        'kode_pegawai' => 315,
        'jam_keluar' => now(),
        'jenis' => 'WFO',
        'status' => 1,
        'verified' => 1,
        'position_status' => 2, // Stand By
    ]);

    $job = new ExportReportJob(
        userId: $this->adminUser->id,
        reportType: 'absensi',
        fromDate: now()->startOfMonth()->toDateString(),
        toDate: now()->endOfMonth()->toDateString(),
        filterBy: 'kode_pegawai',
        filterValue: '315',
        exportFormat: 'xlsx',
        additionalFilters: [
            'attendance_type' => 'keluar',
            'position_status' => 2,
            'verified' => 1,
        ]
    );

    $job->handle();

    \Illuminate\Support\Facades\Notification::assertSentTo(
        $this->adminUser,
        \App\Notifications\ReportExportCompleted::class
    );
});

it('can successfully run ExportReportJob for combined check-in and check-out', function () {
    \Illuminate\Support\Facades\Notification::fake();
    \Illuminate\Support\Facades\Event::fake();
    \Illuminate\Support\Facades\Storage::fake();

    $pegawai = \App\Models\Pegawai::create([
        'kode_pegawai' => 315,
        'full_name' => 'Oky',
        'nick_name' => 'Oky',
        'nik_pegawai' => '123456',
    ]);

    $attendanceIn = \App\Models\Attendance::create([
        'kode_pegawai' => 315,
        'jam_masuk' => now()->subHours(8),
        'jenis' => 'WFO',
        'status' => 1,
        'verified' => 1,
    ]);

    $attendanceOut = \App\Models\AttendanceOut::create([
        'kode_pegawai' => 315,
        'jam_keluar' => now(),
        'jenis' => 'WFO',
        'status' => 1,
        'verified' => 1,
    ]);

    $job = new ExportReportJob(
        userId: $this->adminUser->id,
        reportType: 'absensi',
        fromDate: now()->startOfMonth()->toDateString(),
        toDate: now()->endOfMonth()->toDateString(),
        filterBy: 'kode_pegawai',
        filterValue: '315',
        exportFormat: 'xlsx',
        additionalFilters: [
            'attendance_type' => 'semua',
        ]
    );

    $job->handle();

    \Illuminate\Support\Facades\Notification::assertSentTo(
        $this->adminUser,
        \App\Notifications\ReportExportCompleted::class
    );
});

it('ExportCuti supports user search, select, and remove user', function () {
    $this->actingAs($this->adminUser);

    $user = User::factory()->create(['name' => 'John Doe', 'kode_pegawai' => '12345']);

    Livewire::test(ExportCuti::class)
        ->set('userSearchQuery', 'John')
        ->assertSee('John Doe')
        ->call('selectUser', $user->id, 'John Doe', '12345')
        ->assertSet('selectedUsers', [
            ['id' => $user->id, 'name' => 'John Doe', 'kode_pegawai' => '12345'],
        ])
        ->call('removeUser', $user->id)
        ->assertSet('selectedUsers', []);
});

it('can successfully run ExportReportJob for cuti with date_type leave_date and status', function () {
    \Illuminate\Support\Facades\Notification::fake();
    \Illuminate\Support\Facades\Event::fake();
    \Illuminate\Support\Facades\Storage::fake();

    $leaveType = \App\Models\LeaveRequest\LeaveType::firstOrCreate(
        ['code' => 'CT-TAHUNAN'],
        ['name' => 'Cuti Tahunan', 'is_anual_deduction' => true, 'default_days' => 12]
    );

    $user = User::factory()->create(['name' => 'Jane Doe', 'kode_pegawai' => '67890']);

    $leave = \App\Models\LeaveRequest\LeaveRequest::create([
        'user_id' => $user->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => now()->startOfMonth()->addDays(5)->toDateString(),
        'end_date' => now()->startOfMonth()->addDays(10)->toDateString(),
        'return_date' => now()->startOfMonth()->addDays(11)->toDateString(),
        'total_days' => 6,
        'reason' => 'Family holiday',
        'status' => 'approved',
    ]);

    $job = new ExportReportJob(
        userId: $this->adminUser->id,
        reportType: 'cuti',
        fromDate: now()->startOfMonth()->toDateString(),
        toDate: now()->endOfMonth()->toDateString(),
        filterBy: 'user_id',
        filterValue: (string) $user->id,
        exportFormat: 'xlsx',
        additionalFilters: [
            'date_type' => 'leave_date',
            'status' => 'approved',
            'role_id' => null,
        ]
    );

    $job->handle();

    \Illuminate\Support\Facades\Notification::assertSentTo(
        $this->adminUser,
        \App\Notifications\ReportExportCompleted::class
    );
});

it('ExportPiutang filters users dynamically by role depending on filterBy', function () {
    $this->actingAs($this->adminUser);

    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Collector', 'guard_name' => 'web']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Piutang', 'guard_name' => 'web']);

    $collectorUser = User::factory()->create(['name' => 'Collector User']);
    $collectorUser->assignRole('Collector');

    $piutangUser = User::factory()->create(['name' => 'Piutang User']);
    $piutangUser->assignRole('Piutang');

    Livewire::test(ExportPiutang::class)
        ->set('filterBy', 'assign_to')
        ->assertSee('Collector User')
        ->assertDontSee('Piutang User')
        ->set('filterBy', 'assign_by')
        ->assertSee('Piutang User')
        ->assertDontSee('Collector User');
});

it('can successfully run ExportReportJob for piutang with date_type assign_date, sr_type and bill_status', function () {
    \Illuminate\Support\Facades\Notification::fake();
    \Illuminate\Support\Facades\Event::fake();
    \Illuminate\Support\Facades\Storage::fake();

    $user = User::factory()->create(['name' => 'Collector Person', 'kode_pegawai' => '555']);

    $task = CollectTask::create([
        'no_sr' => 'SR-999',
        'sr_type' => 'AT',
        'sr_date' => now()->toDateString(),
        'customer_name' => 'John Doe Customer',
        'customer_address' => 'Sudirman Road',
        'total_bill' => 5000000,
        'remaining_bill' => 5000000,
        'assign_to' => '555',
        'assign_by' => '1',
        'assign_date' => now()->toDateString(),
        'bill_status' => 1,
    ]);

    $job = new ExportReportJob(
        userId: $this->adminUser->id,
        reportType: 'piutang',
        fromDate: now()->startOfMonth()->toDateString(),
        toDate: now()->endOfMonth()->toDateString(),
        filterBy: 'assign_to',
        filterValue: '555',
        exportFormat: 'xlsx',
        additionalFilters: [
            'date_type' => 'assign_date',
            'sr_type' => 'AT',
            'bill_status' => 1,
        ]
    );

    $job->handle();

    \Illuminate\Support\Facades\Notification::assertSentTo(
        $this->adminUser,
        \App\Notifications\ReportExportCompleted::class
    );
});

it('can successfully run ExportReportJob for kolektor with additional filters', function () {
    \Illuminate\Support\Facades\Notification::fake();
    \Illuminate\Support\Facades\Event::fake();
    \Illuminate\Support\Facades\Storage::fake();

    $user = User::factory()->create(['name' => 'Collector User', 'kode_pegawai' => '777']);

    $collector = \App\Models\Collector::create([
        'no_sr' => 'SR-100',
        'bill_type' => 'idcppn',
        'kode_pegawai' => '777',
        'title' => 'Test Collector Report',
        'location' => 'Test Location',
        'longitude' => '0',
        'latitude' => '0',
        'status' => 1,
        'have_paid' => 2,
        'payment_type' => 1,
        'payment_amount' => 1000000,
        'filled_by' => $user->id,
        'assign_date' => now()->toDateString(),
    ]);

    $job = new ExportReportJob(
        userId: $this->adminUser->id,
        reportType: 'kolektor',
        fromDate: now()->startOfMonth()->toDateString(),
        toDate: now()->endOfMonth()->toDateString(),
        filterBy: 'kode_pegawai',
        filterValue: '777',
        exportFormat: 'xlsx',
        additionalFilters: [
            'bill_type' => 'idcppn',
            'have_paid' => 2,
            'status' => 1,
        ]
    );

    $job->handle();

    \Illuminate\Support\Facades\Notification::assertSentTo(
        $this->adminUser,
        \App\Notifications\ReportExportCompleted::class
    );
});

it('ExportSpk has extended filter options', function () {
    $this->actingAs($this->adminUser);

    Livewire::test(ExportSpk::class)
        ->assertSee('Dibuat Oleh')
        ->assertSee('Assign Ke')
        ->assertSee('Tipe Tagihan')
        ->assertSee('Tipe Timbangan')
        ->assertSee('Status SPK')
        ->assertSee('Status Approval');
});

it('can successfully run ExportReportJob for SPK with tipe_tagihan and status = 0', function () {
    \Illuminate\Support\Facades\Notification::fake();
    \Illuminate\Support\Facades\Event::fake();
    \Illuminate\Support\Facades\Storage::fake();

    $spk = \App\Models\Spk\SpkMain::create([
        'nomor_order' => 'ORD-TEST-001',
        'tipe_tagihan' => 'idcppn',
        'tipe_timbangan' => 'timbangan jembatan',
        'tipe_bayar' => 'Bon',
        'company_name' => 'Test Company',
        'tgl_cetak' => now()->toDateString(),
        'tgl_kirim' => 'SEGERA',
        'keterangan' => 'Test Keterangan',
        'customer' => ['nama' => 'Test Customer'],
        'products' => [],
        'status' => 0,
        'status_approval' => 0,
        'added_by' => $this->adminUser->id,
    ]);

    $job = new ExportReportJob(
        userId: $this->adminUser->id,
        reportType: 'spk',
        fromDate: now()->startOfMonth()->toDateString(),
        toDate: now()->endOfMonth()->toDateString(),
        filterBy: null,
        filterValue: null,
        exportFormat: 'xlsx',
        additionalFilters: [
            'tipe_tagihan' => 'idcppn',
            'status' => '0',
        ]
    );

    $job->handle();

    \Illuminate\Support\Facades\Notification::assertSentTo(
        $this->adminUser,
        \App\Notifications\ReportExportCompleted::class
    );
});

it('ExportSpk dispatches export job with additional filters', function () {
    Queue::fake();
    $this->actingAs($this->adminUser);

    Livewire::test(ExportSpk::class)
        ->set('fromDate', '2026-01-01')
        ->set('toDate', '2026-01-31')
        ->set('tipeTagihan', 'idcppn')
        ->set('status', '0')
        ->call('export');

    Queue::assertPushed(ExportReportJob::class, function (ExportReportJob $job) {
        return ($job->additionalFilters['tipe_tagihan'] ?? null) === 'idcppn'
            && ($job->additionalFilters['status'] ?? null) === '0';
    });
});

it('ExportDriver has extended filter options', function () {
    $this->actingAs($this->adminUser);

    Livewire::test(ExportDriver::class)
        ->assertSee('Di-assign Oleh')
        ->assertSee('Tipe Tagihan')
        ->assertSee('Tipe Kunjungan')
        ->assertSee('Driver')
        ->assertSee('Status Validasi')
        ->assertSee('Status Pengantaran');
});

it('can successfully run ExportReportJob for Driver with additional filters', function () {
    \Illuminate\Support\Facades\Notification::fake();
    \Illuminate\Support\Facades\Event::fake();
    \Illuminate\Support\Facades\Storage::fake();

    $this->adminUser->update(['kode_pegawai' => '999']);

    $driver = \App\Models\Driver::create([
        'kode_pegawai' => '999',
        'title' => 'Test Driver Report',
        'lokasi' => 'Test Location',
        'keterangan' => 'Test Description',
        'longitude' => '100.0',
        'latitude' => '10.0',
        'status' => 1,
        'no_sr' => 'SR-123',
        'tipe_tagihan' => 'idcppn',
        'tipe_kunjungan' => 'ATRBRG',
        'status_pengantaran' => 2,
    ]);

    $job = new ExportReportJob(
        userId: $this->adminUser->id,
        reportType: 'driver',
        fromDate: now()->startOfMonth()->toDateString(),
        toDate: now()->endOfMonth()->toDateString(),
        filterBy: null,
        filterValue: null,
        exportFormat: 'xlsx',
        additionalFilters: [
            'tipe_tagihan' => 'idcppn',
            'tipe_kunjungan' => 'ATRBRG',
            'kode_pegawai' => '999',
            'status' => '1',
            'status_pengantaran' => '2',
        ]
    );

    $job->handle();

    \Illuminate\Support\Facades\Notification::assertSentTo(
        $this->adminUser,
        \App\Notifications\ReportExportCompleted::class
    );
});

it('ExportDriver dispatches export job with additional filters', function () {
    Queue::fake();
    $this->actingAs($this->adminUser);

    Livewire::test(ExportDriver::class)
        ->set('fromDate', '2026-01-01')
        ->set('toDate', '2026-01-31')
        ->set('tipeTagihan', 'idcppn')
        ->set('tipeKunjungan', 'ATRBRG')
        ->set('kodePegawai', '999')
        ->set('status', '1')
        ->set('statusPengantaran', '2')
        ->call('export');

    Queue::assertPushed(ExportReportJob::class, function (ExportReportJob $job) {
        return ($job->additionalFilters['tipe_tagihan'] ?? null) === 'idcppn'
            && ($job->additionalFilters['tipe_kunjungan'] ?? null) === 'ATRBRG'
            && ($job->additionalFilters['kode_pegawai'] ?? null) === '999'
            && ($job->additionalFilters['status'] ?? null) === '1'
            && ($job->additionalFilters['status_pengantaran'] ?? null) === '2';
    });
});
