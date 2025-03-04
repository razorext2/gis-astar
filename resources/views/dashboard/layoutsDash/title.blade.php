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
	    'profile.*' => 'Profile - ' . Auth::user()->name,
	    'log.*' => 'Log Aktivitas',
	    'users.*' => 'Users',
	    'roles.*' => 'Roles',
	    'permissions.*' => 'Permissions',
	    'notifications.*' => 'Pusat Notifikasi',
	    'sales.*' => 'Laporan Sales',
	    'technician.*' => 'Laporan Teknisi',
	    'announcement.*' => 'Pusat Pengumuman',
	    'backup.*' => 'Manajemen Cadangan',
	];

	// Temukan judul berdasarkan rute dengan wildcard
	$pageTitle =
	    collect($titles)->first(function ($title, $key) {
	        return Route::is($key); // Memeriksa wildcard
	    }) ?? 'Default Title';
@endphp

<div class="py-6 text-gray-800 dark:text-white">
	<h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
		{{ $pageTitle }}
	</h2>
</div>
