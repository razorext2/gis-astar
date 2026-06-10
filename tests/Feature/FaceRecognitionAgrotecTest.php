<?php

/** Goal: Test Agrotec Employee attendance redirects in proxy API and ProcessFaceRecognition job, Caller: pest, Deps: User, Role, Http */

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Employee-Agrotec', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);
});

test('proxy route redirects to insertAttendanceAgrotec for Employee-Agrotec user', function () {
    Http::fake([
        'https://indodacin.nusa.net.id/*' => Http::response(['status' => 'success'], 200),
    ]);

    Pegawai::create([
        'kode_pegawai' => '777',
        'nik_pegawai' => '777-NIK',
        'full_name' => 'Agrotec User',
    ]);

    $agrotecUser = User::factory()->create([
        'kode_pegawai' => '777',
        'is_active' => true,
    ]);
    $agrotecUser->assignRole('Employee-Agrotec');

    $response = $this->postJson('/api/proxy/server/attendance', [
        'kode_jari' => '777',
    ]);

    $response->assertSuccessful();

    Http::assertSent(function (\Illuminate\Http\Client\Request $request) {
        return str_contains($request->url(), 'tipe=insertAttendanceAgrotec') &&
               $request['kode_jari'] === '777';
    });
});

test('proxy route uses standard insertAttendance for regular employee', function () {
    Http::fake([
        'https://indodacin.nusa.net.id/*' => Http::response(['status' => 'success'], 200),
    ]);

    Pegawai::create([
        'kode_pegawai' => '888',
        'nik_pegawai' => '888-NIK',
        'full_name' => 'Regular User',
    ]);

    $regularUser = User::factory()->create([
        'kode_pegawai' => '888',
        'is_active' => true,
    ]);
    $regularUser->assignRole('Employee');

    $response = $this->postJson('/api/proxy/server/attendance', [
        'kode_jari' => '888',
    ]);

    $response->assertSuccessful();

    Http::assertSent(function (\Illuminate\Http\Client\Request $request) {
        return str_contains($request->url(), 'tipe=insertAttendance') &&
               !str_contains($request->url(), 'insertAttendanceAgrotec') &&
               $request['kode_jari'] === '888';
    });
});

test('SyncAttendanceToExternalServerJob routes correctly and syncs to external server', function () {
    Http::fake([
        'https://indodacin.nusa.net.id/*' => Http::response(['status' => 'success'], 200),
    ]);

    Pegawai::create([
        'kode_pegawai' => '999',
        'nik_pegawai' => '999-NIK',
        'full_name' => 'Agrotec User',
    ]);
    $user = User::factory()->create([
        'kode_pegawai' => '999',
        'is_active' => true,
    ]);
    $user->assignRole('Employee-Agrotec');

    $job = new \App\Jobs\SyncAttendanceToExternalServerJob(
        userId: $user->id,
        kodePegawai: '999',
        waktuOri: '2026-06-09 10:00:00',
        noVt: 'VT123',
        keterangan: 'None',
        lokasi: 'Medan',
    );
    $job->handle();

    Http::assertSent(function (\Illuminate\Http\Client\Request $request) {
        return str_contains($request->url(), 'tipe=insertAttendanceAgrotec') &&
               $request['kode_jari'] === '999' &&
               $request['waktu'] === '2026-06-09 10:00:00' &&
               $request['kodebarcode'] === 'VT123';
    });
});
