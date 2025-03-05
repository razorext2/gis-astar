@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="relative grid grid-cols-1 gap-6">

		@can('driver-create')
			<div class="max-w-xs">
				<x-button.link class="w-fit ring-1 ring-green-700 dark:bg-green-800 dark:text-white"
					href="{{ route('driver.create') }}">
					<x-slot name="icon">
						<x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
					</x-slot>
					Tambah Data
				</x-button.link>
			</div>
		@endcan

		<div
			class="relative grid grid-cols-1 rounded-xl bg-white py-2 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 lg:p-6">

			<livewire:table-refresher table-name="DriverTable" />

		</div>
	</div>
@endsection