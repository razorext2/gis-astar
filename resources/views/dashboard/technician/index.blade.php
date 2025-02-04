@extends('dashboard.layoutsDash.app')
@section('content')
	<form id="add-form" action="{{ route('technician.create') }}"></form>
	<div class="relative grid grid-cols-1 gap-6">

		@can('technician-create')
			<div class="max-w-xs">
				<x-button.success id="add-button" form="add-form" type="submit">
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
				<div class="col-span-2 mb-4">
					<x-filter.filter-bar>
						<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
							<x-filter.filter-input-text id="kode_pegawai" name="kode_pegawai" :text="'kode jari'">
								<x-icons.fingerprint class="h-4 w-4 text-gray-500 dark:text-gray-400" />
							</x-filter.filter-input-text>
						</div>

						<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
							<x-filter.filter-input-text id="no_vt" name="no_vt" :text="'no vt'">
								<x-icons.fingerprint class="h-4 w-4 text-gray-500 dark:text-gray-400" />
							</x-filter.filter-input-text>
						</div>

						<div class="col-span-2 mx-auto flex w-full items-center">
							<x-filter.filter-input-text id="title" name="title" :text="'judul laporan'">
								<x-icons.font-case class="h-4 w-4 text-gray-500 dark:text-gray-400" />
							</x-filter.filter-input-text>
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.filter-input-select id="status" name="status" :options="['0' => 'Belum di lengkapi', '1' => 'Disetujui', '2' => 'Diajukan', '3' => 'Ditolak']" default-option="Filter by status" />
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.date-range />
						</div>

					</x-filter.filter-bar>
				</div>
				{{-- end filter --}}

				{{-- subcontent --}}
				<div class="col-span-2" x-data="{ openRow: null }">
					<x-dashboard.table id="dataTable" :tablename="[
					    '0' => '#',
					    '1' => 'Aksi',
					    '2' => 'Kunjungan',
					    '3' => 'Customer',
					    '4' => 'Tools',
					    '5' => 'Created / Updated',
					]" />
				</div>

			</div>
		</div>
	</div>
@endsection
@push('script')
	@vite('resources/js/technician/index.js')
@endpush
