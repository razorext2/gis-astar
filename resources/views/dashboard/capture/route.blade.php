@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="flex flex-col gap-2 rounded-xl border border-gray-200 bg-white p-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none md:p-6">

		<div class="w-full">
			<h2 class="w-full text-lg font-semibold text-gray-900 dark:text-white">Absensi baru khusus rute</h2>
			<p class="text-md text-gray-600 dark:text-gray-300"> Rasa stroberi </p>
		</div>

		@livewire('handler.attendance.route')
	</div>
@endsection
