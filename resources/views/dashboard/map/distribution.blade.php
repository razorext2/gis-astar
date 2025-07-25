@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="flex w-full flex-col gap-4 rounded-xl border border-gray-200 bg-white p-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none md:p-6">
		<h2 class="w-full text-lg font-semibold text-gray-900 dark:text-white">Peta Penyebaran Teknisi</h2>

		<div id="map" class="z-0 h-96 w-full rounded-lg ring-1 ring-gray-200 dark:ring-0 lg:h-[560px]"></div>
	</div>
@endsection
