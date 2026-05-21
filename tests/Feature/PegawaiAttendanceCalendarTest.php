<?php

/** Goal: Test employee detail attendance calendar synchronization with approved leave, Caller: PHPUnit, Deps: User, Pegawai, LeaveRequest, Attendance */

use App\Livewire\Components\Pegawai\AttendanceCalendarPopover;
use App\Models\Attendance;
use App\Models\LeaveRequest\LeaveRequest;
use App\Models\LeaveRequest\LeaveType;
use App\Models\Pegawai;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create(['kode_pegawai' => '12345678', 'is_active' => true]);
    $this->pegawai = Pegawai::create([
        'kode_pegawai' => '12345678',
        'nik_pegawai' => '123456789012',
        'full_name' => 'Test Employee',
    ]);

    $this->leaveType = LeaveType::firstOrCreate(
        ['code' => 'CT-TAHUNAN'],
        ['name' => 'Cuti Tahunan', 'is_anual_deduction' => true, 'default_days' => 12]
    );
});

it('displays calendar days matching approved leave ranges in amber when no attendance exists', function () {
    // Create approved leave from 2026-05-15 to 2026-05-17
    LeaveRequest::create([
        'user_id' => $this->user->id,
        'leave_type_id' => $this->leaveType->id,
        'start_date' => '2026-05-15',
        'end_date' => '2026-05-17',
        'return_date' => '2026-05-18',
        'total_days' => 3,
        'reason' => 'Liburan keluarga',
        'status' => 'approved',
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('pegawai.detail', ['pegawai' => $this->pegawai->id, 'period' => '2026-05']));

    $response->assertStatus(200);
    // Amber color component styling (!border-amber-400 or !from-amber-500)
    $response->assertSee('!border-amber-400');
    $response->assertSee('!from-amber-500');
});

it('displays calendar days in green (presence priority) when both attendance and approved leave exist on the same day', function () {
    // Create approved leave from 2026-05-15 to 2026-05-17
    LeaveRequest::create([
        'user_id' => $this->user->id,
        'leave_type_id' => $this->leaveType->id,
        'start_date' => '2026-05-15',
        'end_date' => '2026-05-17',
        'return_date' => '2026-05-18',
        'total_days' => 3,
        'reason' => 'Liburan keluarga',
        'status' => 'approved',
    ]);

    // Create attendance check-in on 2026-05-15
    Attendance::create([
        'kode_pegawai' => '12345678',
        'jam_masuk' => '2026-05-15 08:00:00',
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('pegawai.detail', ['pegawai' => $this->pegawai->id, 'period' => '2026-05']));

    $response->assertStatus(200);
    // Day 15 should have green button, Day 16 should have amber button
    $response->assertSee('!border-green-400');
    $response->assertSee('!border-amber-400');
});

it('renders the Livewire popover component with leave and attendance details', function () {
    // Create approved leave
    $leave = LeaveRequest::create([
        'user_id' => $this->user->id,
        'leave_type_id' => $this->leaveType->id,
        'start_date' => '2026-05-15',
        'end_date' => '2026-05-17',
        'return_date' => '2026-05-18',
        'total_days' => 3,
        'reason' => 'Liburan keluarga',
        'status' => 'approved',
    ]);

    // Create attendance check-in
    Attendance::create([
        'kode_pegawai' => '12345678',
        'jam_masuk' => '2026-05-15 08:00:00',
    ]);

    Livewire::test(AttendanceCalendarPopover::class, [
        'date' => '2026-05-15',
        'pegawaiId' => $this->pegawai->id,
        'kodePegawai' => $this->pegawai->kode_pegawai,
    ])
        ->assertSee('Liburan keluarga')
        ->assertSee('Cuti Tahunan')
        ->assertSee('08:00:00')
        ->assertSee('Pegawai Cuti (Disetujui)');
});

it('displays calendar days matching Sundays in red when no attendance exists', function () {
    // 2026-05-17 is a Sunday
    $response = $this->actingAs($this->user)
        ->get(route('pegawai.detail', ['pegawai' => $this->pegawai->id, 'period' => '2026-05']));

    $response->assertStatus(200);
    // Red color component styling (!border-red-400 or !from-red-500)
    $response->assertSee('!border-red-400');
    $response->assertSee('!from-red-500');
});

it('displays calendar days matching national holidays in red when no attendance exists', function () {
    // Create a holiday on 2026-05-20
    \App\Models\System\Holiday::create([
        'date' => '2026-05-20',
        'name' => 'Hari Kebangkitan Nasional',
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('pegawai.detail', ['pegawai' => $this->pegawai->id, 'period' => '2026-05']));

    $response->assertStatus(200);
    // Red color component styling (!border-red-400 or !from-red-500)
    $response->assertSee('!border-red-400');
    $response->assertSee('!from-red-500');
});

it('displays calendar days in green (presence priority) when attendance exists on a Sunday or holiday', function () {
    // Create a holiday on 2026-05-20
    \App\Models\System\Holiday::create([
        'date' => '2026-05-20',
        'name' => 'Hari Kebangkitan Nasional',
    ]);

    // Create attendance check-in on 2026-05-20
    Attendance::create([
        'kode_pegawai' => '12345678',
        'jam_masuk' => '2026-05-20 08:00:00',
    ]);

    $response = $this->actingAs($this->user)
        ->get(route('pegawai.detail', ['pegawai' => $this->pegawai->id, 'period' => '2026-05']));

    $response->assertStatus(200);
    $response->assertSee('!border-green-400');
});

it('renders the Livewire popover component with holiday and Sunday details', function () {
    // Create a holiday on 2026-05-20
    \App\Models\System\Holiday::create([
        'date' => '2026-05-20',
        'name' => 'Hari Kebangkitan Nasional',
    ]);

    // Test holiday popover
    Livewire::test(AttendanceCalendarPopover::class, [
        'date' => '2026-05-20',
        'pegawaiId' => $this->pegawai->id,
        'kodePegawai' => $this->pegawai->kode_pegawai,
    ])
        ->assertSee('Hari Libur Nasional')
        ->assertSee('Hari Kebangkitan Nasional');

    // Test Sunday popover (2026-05-17 is Sunday)
    Livewire::test(AttendanceCalendarPopover::class, [
        'date' => '2026-05-17',
        'pegawaiId' => $this->pegawai->id,
        'kodePegawai' => $this->pegawai->kode_pegawai,
    ])
        ->assertSee('Hari Minggu (Libur Pekan)');
});
