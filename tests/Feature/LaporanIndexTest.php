<?php

use App\Livewire\Handler\Laporan\Index;
use App\Models\DetailRujukan;
use App\Models\Pasien;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use App\Models\Rute;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Permission::firstOrCreate(['name' => 'rujukan-list']);

    $role = Role::firstOrCreate(['name' => 'Dokter']);
    $role->syncPermissions(['rujukan-list']);

    $this->user = User::factory()->create();
    $this->user->assignRole($role);

    $this->actingAs($this->user);
});

it('renders laporan index page for authorized user', function () {
    $response = $this->get(route('laporan.index'));
    $response->assertStatus(200);
    $response->assertSee('Laporan');
    $response->assertSee('Laporan Riwayat Rujukan');
    $response->assertSee('Laporan Data Pasien');
});

it('can switch tabs between rujukan and pasien', function () {
    Livewire::test(Index::class)
        ->assertSet('activeTab', 'rujukan')
        ->assertSee('Total Rujukan')
        ->call('setTab', 'pasien')
        ->assertSet('activeTab', 'pasien')
        ->assertSee('Total Pasien')
        ->call('setTab', 'rujukan')
        ->assertSet('activeTab', 'rujukan');
});

it('filters rujukan report by search and status', function () {
    $pasien = Pasien::factory()->create(['nama' => 'Ahmad Rujukan Laporan']);
    $rs = RumahSakit::factory()->create(['nama_rumah_sakit' => 'RS Khusus Mata']);

    Rujukan::create([
        'no_rujukan' => 'RJK-TEST-999',
        'id_pasien' => $pasien->id_pasien,
        'id_rumah_sakit' => $rs->id_rumah_sakit,
        'id_user' => $this->user->id,
        'tanggal_rujukan' => now(),
        'status' => 'disetujui',
    ]);

    Livewire::test(Index::class)
        ->set('rujukanSearch', 'RJK-TEST-999')
        ->assertSee('RJK-TEST-999')
        ->assertSee('Ahmad Rujukan Laporan')
        // When status filter doesn't match, table row (patient name) should not appear
        ->set('rujukanStatus', 'ditolak')
        ->assertDontSee('Ahmad Rujukan Laporan')
        ->set('rujukanStatus', 'disetujui')
        ->assertSee('Ahmad Rujukan Laporan');
});

it('resets rujukan filters correctly', function () {
    Livewire::test(Index::class)
        ->set('rujukanSearch', 'Keyword')
        ->set('rujukanStatus', 'pending')
        ->set('rujukanDateFrom', '2026-01-01')
        ->call('resetRujukanFilter')
        ->assertSet('rujukanSearch', '')
        ->assertSet('rujukanStatus', '')
        ->assertSet('rujukanDateFrom', '');
});

it('filters pasien report by search, gender, and coordinate status', function () {
    $pasien1 = Pasien::factory()->create([
        'nama' => 'Dewi Lestari',
        'jenis_kelamin' => 'perempuan',
        'latitude' => 3.595,
        'longitude' => 98.674,
    ]);

    $pasien2 = Pasien::factory()->create([
        'nama' => 'Bambang Sudirman',
        'jenis_kelamin' => 'laki_laki',
        'latitude' => null,
        'longitude' => null,
    ]);

    Livewire::test(Index::class)
        ->call('setTab', 'pasien')
        ->set('pasienSearch', 'Dewi Lestari')
        ->assertSee('Dewi Lestari')
        ->assertDontSee('Bambang Sudirman')
        ->set('pasienSearch', '')
        ->set('pasienGender', 'laki_laki')
        ->assertSee('Bambang Sudirman')
        ->assertDontSee('Dewi Lestari')
        ->set('pasienGender', '')
        ->set('pasienCoordStatus', 'with')
        ->assertSee('Dewi Lestari')
        ->assertDontSee('Bambang Sudirman');
});

it('can export rujukan report as CSV', function () {
    $pasien = Pasien::factory()->create(['nama' => 'Pasien Export']);
    $rs = RumahSakit::factory()->create(['nama_rumah_sakit' => 'RS Export']);

    $rujukan = Rujukan::create([
        'no_rujukan' => 'RJK-CSV-123',
        'id_pasien' => $pasien->id_pasien,
        'id_rumah_sakit' => $rs->id_rumah_sakit,
        'id_user' => $this->user->id,
        'tanggal_rujukan' => now(),
        'status' => 'selesai',
    ]);

    $rute = Rute::create([
        'nama_rute' => 'Rute Test',
        'jarak' => 5.25,
        'waktu_tempuh' => 15,
        'polyline' => '[]',
    ]);

    DetailRujukan::create([
        'id_rujukan' => $rujukan->id_rujukan,
        'id_rute' => $rute->id_rute,
        'jarak' => 5.25,
        'waktu_tempuh' => 15,
        'estimasi_biaya' => 50000,
        'metode' => 'A*',
    ]);

    Livewire::test(Index::class)
        ->set('rujukanSearch', 'RJK-CSV-123')
        ->call('exportRujukanCsv')
        ->assertFileDownloaded();
});

it('can export pasien report as CSV', function () {
    Pasien::factory()->create([
        'nama' => 'Pasien CSV Test',
        'nik' => '1234567890123456',
    ]);

    Livewire::test(Index::class)
        ->call('setTab', 'pasien')
        ->set('pasienSearch', 'Pasien CSV Test')
        ->call('exportPasienCsv')
        ->assertFileDownloaded();
});

it('dispatches open-print-window event with correct url for rujukan tab', function () {
    Livewire::test(Index::class)
        ->set('rujukanSearch', 'RJK-TEST')
        ->set('rujukanStatus', 'pending')
        ->call('openPrint')
        ->assertDispatched('open-print-window', fn (string $name, array $params) => str_contains($params['url'], 'tab=rujukan') &&
            str_contains($params['url'], 'search=RJK-TEST') &&
            str_contains($params['url'], 'status=pending'));
});

it('dispatches open-print-window event with correct url for pasien tab', function () {
    Livewire::test(Index::class)
        ->call('setTab', 'pasien')
        ->set('pasienGender', 'laki_laki')
        ->call('openPrint')
        ->assertDispatched('open-print-window', fn (string $name, array $params) => str_contains($params['url'], 'tab=pasien') &&
            str_contains($params['url'], 'gender=laki_laki'));
});

it('renders laporan print page for rujukan tab', function () {
    $pasien = Pasien::factory()->create(['nama' => 'Pasien Print Test']);
    $rs = RumahSakit::factory()->create(['nama_rumah_sakit' => 'RS Print']);

    Rujukan::create([
        'no_rujukan' => 'RJK-PRINT-001',
        'id_pasien' => $pasien->id_pasien,
        'id_rumah_sakit' => $rs->id_rumah_sakit,
        'id_user' => $this->user->id,
        'tanggal_rujukan' => now(),
        'status' => 'disetujui',
    ]);

    $response = $this->get(route('laporan.print', ['tab' => 'rujukan']));
    $response->assertStatus(200);
    $response->assertSee('RJK-PRINT-001');
    $response->assertSee('Pasien Print Test');
});

it('renders laporan print page for pasien tab', function () {
    Pasien::factory()->create(['nama' => 'Pasien Print Cek']);

    $response = $this->get(route('laporan.print', ['tab' => 'pasien']));
    $response->assertStatus(200);
    $response->assertSee('Pasien Print Cek');
    $response->assertSee('Laporan Data Pasien');
});

it('filters data on print page by search and date', function () {
    $rs = RumahSakit::factory()->create();

    $pasien1 = Pasien::factory()->create(['nama' => 'Ahmad Cetak']);
    $pasien2 = Pasien::factory()->create(['nama' => 'Budi Cetak']);

    Rujukan::create([
        'no_rujukan' => 'RJK-PRINT-A',
        'id_pasien' => $pasien1->id_pasien,
        'id_rumah_sakit' => $rs->id_rumah_sakit,
        'id_user' => $this->user->id,
        'tanggal_rujukan' => now(),
        'status' => 'selesai',
    ]);

    Rujukan::create([
        'no_rujukan' => 'RJK-PRINT-B',
        'id_pasien' => $pasien2->id_pasien,
        'id_rumah_sakit' => $rs->id_rumah_sakit,
        'id_user' => $this->user->id,
        'tanggal_rujukan' => now(),
        'status' => 'ditolak',
    ]);

    // Filter by status
    $response = $this->get(route('laporan.print', ['tab' => 'rujukan', 'status' => 'selesai']));
    $response->assertStatus(200);
    $response->assertSee('RJK-PRINT-A');
    $response->assertDontSee('RJK-PRINT-B');
});
