@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="relative grid grid-cols-1 rounded-xl bg-white py-2 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 lg:p-6">

		<div class="flex flex-col px-3 md:mb-2 lg:p-0">
			<div class="mb-2">
				<span class="text-xl font-semibold text-gray-900 dark:bg-[#18181b] dark:text-white">
					Cadangan Database
				</span>

				<p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
					Silahkan klik tombol cadangkan untuk membuat cadangan database baru.
				</p>
			</div>

			<div>
				<x-button.success class="getCollectorExcel max-h-10" id="new-backup" type="button">
					<x-slot name="icon">
						<x-icons.plus class="icon h-6 w-6 text-red-500 dark:text-white" />
					</x-slot>
					Buat cadangan
				</x-button.success>
			</div>
		</div>

		<livewire:table-refresher table-name="BackupTable" />
	</div>
@endsection
@push('script')
	@vite(['resources/js/backup/index.js']);
@endpush
