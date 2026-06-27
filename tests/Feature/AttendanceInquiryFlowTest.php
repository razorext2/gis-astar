<?php

/** Goal: Test Attendance Inquiry creation, form validation, and HRD approval/rejection flows, Caller: pest, Deps: AttendanceInquiry, Livewire, Roles/Permissions */

use App\Models\Pegawai;
use App\Models\User;
use App\Models\AttendanceInquiry\AttendanceInquiry;
use App\Models\Attendance;
use App\Models\AttendanceOut;
use App\Livewire\Handler\AttendanceInquiry\Create;
use App\Livewire\Handler\AttendanceInquiry\ApprovalCenterShow;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    // Setup roles
    Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'HRD', 'guard_name' => 'web']);

    // Setup permissions
    Permission::firstOrCreate(['name' => 'attendance-inquiry-create', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'attendance-inquiry-approve-hrd', 'guard_name' => 'web']);

    Role::where('name', 'Employee')->first()->givePermissionTo('attendance-inquiry-create');
    Role::where('name', 'HRD')->first()->givePermissionTo('attendance-inquiry-approve-hrd');

    // Create Employee Pegawai record
    Pegawai::create([
        'kode_pegawai' => '12345',
        'nik_pegawai' => 'NIK-12345',
        'full_name' => 'John Employee',
    ]);

    // Create Employee User
    $this->employee = User::factory()->create([
        'kode_pegawai' => '12345',
        'name' => 'John Employee',
        'is_active' => true,
    ]);
    $this->employee->assignRole('Employee');

    // Create HRD User
    $this->hrd = User::factory()->create([
        'kode_pegawai' => '54321',
        'name' => 'Jane HRD',
        'is_active' => true,
    ]);
    $this->hrd->assignRole('HRD');
});

test('employee can submit attendance inquiry', function () {
    Storage::fake('public');

    $file1 = UploadedFile::fake()->image('error_log.png');
    $file2 = UploadedFile::fake()->image('selfie.png');

    $this->actingAs($this->employee);

    Livewire::test(Create::class)
        ->set('type_absen', 'in')
        ->set('position_status', 3) // onsite
        ->set('waktu_absen', '2026-06-27T10:00')
        ->set('keterangan', 'Kamera bermasalah saat clock in di pagi hari')
        ->set('no_vt', 'VT-1002')
        ->set('longitude', '98.67')
        ->set('latitude', '3.59')
        ->set('bukti', [$file1, $file2])
        ->call('save');

    // Assert database has inquiry
    $inquiry = AttendanceInquiry::first();
    expect($inquiry)->not->toBeNull()
        ->and($inquiry->kode_pegawai)->toBe('12345')
        ->and($inquiry->type_absen)->toBe('in')
        ->and($inquiry->status)->toBe('pending')
        ->and($inquiry->no_vt)->toBe('VT-1002')
        ->and(count($inquiry->bukti))->toBe(2);

    // Assert files are stored
    Storage::disk('public')->assertExists($inquiry->bukti[0]);
    Storage::disk('public')->assertExists($inquiry->bukti[1]);
});

test('submitting inquiry fails validation if required fields are missing', function () {
    $this->actingAs($this->employee);

    Livewire::test(Create::class)
        ->set('keterangan', '') // empty (required)
        ->set('bukti', []) // empty (required)
        ->call('save')
        ->assertHasErrors(['keterangan' => 'required', 'bukti' => 'required']);

    expect(AttendanceInquiry::count())->toBe(0);
});

test('hrd can approve employee attendance inquiry and trigger sync job', function () {
    Queue::fake();

    // Create a pending inquiry
    $inquiry = AttendanceInquiry::create([
        'kode_pegawai' => '12345',
        'type_absen' => 'in',
        'position_status' => 3,
        'longitude' => '98.67',
        'latitude' => '3.59',
        'waktu_absen' => '2026-06-27 10:00:00',
        'keterangan' => 'Kamera bermasalah saat clock in di pagi hari',
        'no_vt' => 'VT-1002',
        'bukti' => ['bukti-inquiries/dummy.png'],
        'status' => 'pending',
    ]);

    $this->actingAs($this->hrd);

    Livewire::test(ApprovalCenterShow::class, ['inquiry' => $inquiry])
        ->call('approve');

    // Assert status updated to approved
    $inquiry->refresh();
    expect($inquiry->status)->toBe('approved')
        ->and($inquiry->acted_by)->toBe($this->hrd->id);

    // Assert attendance record created in tb_attendance
    $attendance = Attendance::where('kode_pegawai', '12345')->first();
    expect($attendance)->not->toBeNull()
        ->and($attendance->jam_masuk->format('Y-m-d H:i:s'))->toBe('2026-06-27 10:00:00')
        ->and($attendance->position_status)->toBe(3)
        ->and($attendance->verified_by)->toBe('Jane HRD');

    // Assert sync job dispatched
    Queue::assertDispatched(\App\Jobs\SyncAttendanceToExternalServerJob::class, function ($job) {
        return $job->kodePegawai === '12345' &&
               $job->noVt === 'VT-1002' &&
               $job->waktuOri === '2026-06-27 10:00:00';
    });
});

test('hrd can reject employee attendance inquiry with a reason', function () {
    // Create a pending inquiry
    $inquiry = AttendanceInquiry::create([
        'kode_pegawai' => '12345',
        'type_absen' => 'out',
        'position_status' => 2,
        'longitude' => '98.67',
        'latitude' => '3.59',
        'waktu_absen' => '2026-06-27 18:00:00',
        'keterangan' => 'Gagal input absensi keluar',
        'bukti' => ['bukti-inquiries/dummy.png'],
        'status' => 'pending',
    ]);

    $this->actingAs($this->hrd);

    Livewire::test(ApprovalCenterShow::class, ['inquiry' => $inquiry])
        ->set('rejection_reason', 'Foto bukti tidak jelas dan blur.')
        ->call('reject');

    // Assert status updated to rejected
    $inquiry->refresh();
    expect($inquiry->status)->toBe('rejected')
        ->and($inquiry->rejection_reason)->toBe('Foto bukti tidak jelas dan blur.')
        ->and($inquiry->acted_by)->toBe($this->hrd->id);

    // Assert no attendance_out record was created
    expect(AttendanceOut::where('kode_pegawai', '12345')->count())->toBe(0);
});
