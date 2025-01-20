@php
	$titles = [
	    'dashboard' => 'Dashboard',
	    'pegawai.*' => 'Pegawai',
	    'jabatan.*' => 'Jabatan',
	    'division.*' => 'Divisi',
	    'collect.*' => 'Laporan Kolektor',
	    'collect-task.*' => 'Tagihan IDC Non PPN',
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
	];

	// Temukan judul berdasarkan rute dengan wildcard
	$pageTitle =
	    collect($titles)->first(function ($title, $key) {
	        return Route::is($key); // Memeriksa wildcard
	    }) ?? 'Default Title';
@endphp

<div class="mb-6 mt-2 text-gray-800 dark:text-white">
	<h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
		{{ $pageTitle }}
	</h2>
</div>
