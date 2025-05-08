@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="flex w-full flex-col gap-4 rounded-xl border border-gray-200 bg-white p-2 dark:border-gray-700 dark:bg-dark-primary md:p-6">
		<div>
			<h2 class="w-full text-lg font-semibold text-gray-900 dark:text-white">Absensi Hari Ini</h2>
			<p class="text-md text-gray-600 dark:text-gray-300"> Berikut adalah absensi hari ini tanggal
				{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
			</p>
		</div>
		<livewire:handler.attendance.today />
	</div>
@endsection 