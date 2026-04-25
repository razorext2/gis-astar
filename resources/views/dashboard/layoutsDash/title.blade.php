@php
    $titles = [
        'dashboard' => 'Dashboard',
        'pegawai.*' => 'Pegawai',
        'jabatan.*' => 'Jabatan',
        'division.*' => 'Divisi',
        'collect.*' => 'Laporan Kolektor',
        'driver.*' => 'Laporan Driver',
        'collect-task.*' => 'Tagihan IDC Non PPN',
        'collect-task-ppn.*' => 'Tagihan IDC PPN',
        'collect-idy-ppn.*' => 'Tagihan IDY PPN',
        'placement.*' => 'Penempatan',
        'dayoff.*' => 'Pengajuan Off',
        'attendanceIn.*' => 'Absen Masuk',
        'attendanceOut.*' => 'Absen Keluar',
        'capture.*' => 'Rekam Absensi',
        'profile.*' => 'Profile',
        'log.*' => 'Log Aktivitas',
        'users.*' => 'Users',
        'roles.*' => 'Roles',
        'permissions.*' => 'Permissions',
        'notifications.*' => 'Pusat Notifikasi',
        'sales.*' => 'Laporan Sales',
        'technician.*' => 'Laporan Teknisi',
        'announcement.*' => 'Pusat Pengumuman',
        'backup.*' => 'Manajemen Cadangan',
        'golongan.*' => 'Manajemen Golongan',
        'points.*' => 'Poin Teknisi',
        'map.*' => 'Peta Sebaran',
        'kuesioner.*' => 'Kuesioner (Unused)',
        'today.attendance' => 'Absensi Hari Ini',
        'technicianpoints.*' => 'Transaksi Point',
        'routes.*' => 'Rute',
        'teams.*' => 'Tim Teknisi',
        'event.*' => 'Data Pameran',
        'invoice.*' => 'Invoice',
        'spk.*' => 'Manajemen SPK',
        'purchasing-request.*' => 'Manajemen PR',
        'production.*' => 'Laporan Produksi',
        'delivery.*' => 'Pengiriman',
        'billing.*' => 'Penagihan',
        'daily-report.*' => 'Laporan Kerja Harian',
        'report.*' => 'Laporan Kerja Harian',
        'server.overview' => 'Manajemen Server',
    ];

    // Temukan judul berdasarkan rute dengan wildcard
    $pageTitle =
        collect($titles)->first(function ($title, $key) {
            return Route::is($key); // Memeriksa wildcard
        }) ?? 'Default Title';
@endphp

<div class="mb-1 flex items-center gap-4 py-4">
    {{-- Signature Vertical Accent --}}
    <div class="h-8 w-1.5 rounded-full bg-red-600 shadow-[0_0_20px_rgba(220,38,38,0.4)] dark:bg-red-500"></div>

    <div>
        <h1 class="text-2xl font-black tracking-tight text-zinc-900 dark:text-white sm:text-4xl">
            {{ $pageTitle }}
        </h1>
    </div>
</div>
