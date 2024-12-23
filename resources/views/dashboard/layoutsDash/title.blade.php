@php
	$titles = [
	    'dashboard' => 'Dashboard',
	    'pegawai.index' => 'Pegawai',
	    'pegawai.edit' => 'Edit Pegawai',
	    'pegawai.create' => 'Tambah Pegawai',
	    'pegawai.detail' => 'Detail Absensi',
	    'pegawai.timeline' => 'Linimasa',
	    'pegawai.collectors' => 'Laporan Rute',
	    'pegawai.payrollinfo' => 'Payroll',
	    'pegawai.attendancelist' => 'Attendance Summary',
	    'jabatan.index' => 'Jabatan',
	    'jabatan.create' => 'Tambah Jabatan',
	    'jabatan.edit' => 'Edit Jabatan',
	    'division.index' => 'Divisi',
	    'division.create' => 'Tambah Divisi',
	    'division.edit' => 'Edit Divisi',
	    'collect.index' => 'Laporan Kolektor',
	    'collect.create' => 'Tambah Laporan',
	    'collect.edit' => 'Edit Laporan',
	    'collect.show' => 'Detail Laporan',
	    'placement.index' => 'Penempatan',
	    'placement.create' => 'Tambah Penempatan',
	    'placement.edit' => 'Edit Penempatan',
	    'dayoff.index' => 'Pengajuan Off',
	    'dayoff.create' => 'Tambah Pengajuan Off',
	    'dayoff.edit' => 'Edit Pengajuan',
	    'dayoff.detail' => 'Detail Pengajuan',
	    'attendanceIn.index' => 'Absen Masuk',
	    'attendanceOut.index' => 'Absen Keluar',
	    'capture.index' => 'Rekam Absensi',
	    'profile.edit' => 'Profile - ' . Auth::user()->name,
	];

	$currentRoute = Route::currentRouteName();
	$pageTitle = $titles[$currentRoute] ?? 'Unknown Page';
@endphp

<div class="mb-6 mt-2 text-gray-800 dark:text-white">
	<h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
		{{ $pageTitle }}
	</h2>
</div>
