@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="relative grid grid-cols-1 gap-6">

		@can('announcement-create')
			<div class="max-w-xs">
				<x-button.success id="add-button" type="button">
					<x-slot name="icon">
						<x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
					</x-slot>
					Tambah Data
				</x-button.success>
			</div>
		@endcan

		<div class="flex h-auto items-center justify-center">
			<div
				class="grid w-full grid-cols-2 gap-2 rounded-xl bg-white p-2 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 md:gap-4 md:p-6">

				{{-- filter --}}
				<div class="col-span-2">
					<x-filter.filter-bar>

						<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
							<x-filter.filter-input-text id="title" name="title" :text="'judul'">
								<x-icons.fingerprint class="h-4 w-4 text-gray-500 dark:text-gray-400" />
							</x-filter.filter-input-text>
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.date-range />
						</div>

						<div class="col-span-2 mx-auto w-full items-center">
							<x-filter.filter-input-select id="status" name="status" :options="['0' => 'Tidak aktif', '1' => 'Aktif']" default-option="Filter by status" />
						</div>

					</x-filter.filter-bar>
				</div>
				{{-- end filter --}}

				<div class="col-span-2" x-data="{ openRow: null }">
					<x-dashboard.table id="dataTable" :tablename="[
					    '0' => '#',
					    '1' => 'Aksi',
					    '2' => 'Judul',
					    '3' => 'Status',
					    '4' => 'Deskripsi',
					    '5' => 'Created at',
					]" />
				</div>

			</div>
		</div>
	</div>
@endsection
@push('script')
	<script>
		const showData = "{{ route('announcement.index') }}";
	</script>
	@vite(['resources/js/announcement/index.js'])
@endpush
