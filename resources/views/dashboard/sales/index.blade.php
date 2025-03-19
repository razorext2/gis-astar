@extends('dashboard.layoutsDash.app')
@section('content')
	<form id="add-form" action="{{ route('sales.create') }}"></form>
	<div class="relative grid grid-cols-1 gap-6">

		@can('sales-create')
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
				class="grid w-full grid-cols-2 gap-2 rounded-xl bg-white p-2 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 md:gap-4 md:p-6">

				{{-- filter --}}
				<div class="col-span-2 mb-4">
					<x-filter.filter-bar>
						@can('sales-approve')
							<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
								<x-filter.filter-input-text id="kode_pegawai" name="kode_pegawai" :text="'nama sales'">
									<x-icons.fingerprint class="h-4 w-4 text-gray-500 dark:text-gray-400" />
								</x-filter.filter-input-text>
							</div>
						@endcan

						<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
							<x-filter.filter-input-text id="title" name="title" :text="'judul laporan'">
								<x-icons.font-case class="h-4 w-4 text-gray-500 dark:text-gray-400" />
							</x-filter.filter-input-text>
						</div>

						<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
							<x-filter.filter-input-text id="customer_name" name="customer_name" :text="'nama customer'">
								<x-icons.font-case class="h-4 w-4 text-gray-500 dark:text-gray-400" />
							</x-filter.filter-input-text>
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.filter-input-select id="status" name="status" :options="['0' => 'Belum divalidasi', '1' => 'Disetujui', '2' => 'Ditolak']" default-option="Filter by status" />
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.date-range />
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.filter-input-select id="roles" name="roles" :options="['Sales' => 'Sales Medan', 'Sales-JKT' => 'Sales Jakarta']" default-option="Filter by roles" />
						</div>

					</x-filter.filter-bar>
				</div>
				{{-- end filter --}}

				{{-- subcontent --}}
				<div class="col-span-2" x-data="{ openRow: null }">
					<x-dashboard.table id="dataTable" :tablename="[
					    '0' => '#',
					    '1' => 'Aksi',
					    '2' => 'Pegawai',
					    '3' => 'Judul Laporan',
					    '4' => 'Customer',
					    '5' => 'Lokasi',
					    '6' => 'Created / Updated',
					]" />
				</div>

			</div>
		</div>
	</div>
@endsection
