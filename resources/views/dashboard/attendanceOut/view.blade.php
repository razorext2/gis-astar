@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="relative grid grid-cols-1 rounded-xl bg-white py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">

		<div class="flex flex-col px-3 lg:p-0">
			<div>
				<span class="text-xl font-semibold text-gray-900 dark:text-white">
					Absen Keluar
				</span>

				<p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
					Berisi semua data absensi keluar yang dilakukan oleh pegawai.
				</p>
			</div>
		</div>

		<livewire:table-refresher table-name="AttendanceOutTable" />
	@endsection
