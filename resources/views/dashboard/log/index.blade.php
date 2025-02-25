@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="relative grid grid-cols-1 gap-4 rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 lg:p-4">

		<div class="flex flex-col gap-4">
			<div>
				<span class="text-xl font-semibold text-gray-900 dark:text-white">
					Log Aktivitas
				</span>

				<p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
					Log aktivitas berisi semua aktivitas yang pengguna di sistem lakukan.
				</p>
			</div>
		</div>

		<livewire:table-refresher />
	</div>
@endsection
