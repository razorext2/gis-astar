@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="flex w-full flex-col gap-4 rounded-xl border border-gray-200 bg-white p-2 dark:border-gray-700 dark:bg-dark-primary md:p-6">
		<h2 class="w-full text-lg font-semibold text-gray-900 dark:text-white">KATAKAN PETA</h2>

		<div id="map" class="h-96 w-full lg:h-[560px]"></div>
	</div>
@endsection
