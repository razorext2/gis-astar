@extends('dashboard.layoutsDash.app')
@section('content')
	<form id="add-dayoff" action="{{ route('dayoff.create') }}"></form>
	<div class="relative grid grid-cols-1 gap-6">

		@can('dayoff-create')
			<div class="max-w-xs">
				<x-button.success id="add-button" form="add-dayoff" type="submit">
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
						@can('dayoff-confirm')
							<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
								<x-filter.filter-input-text id="kode-pegawai" name="kode-pegawai" :text="'kode pegawai'">
									<x-icons.fingerprint class="h-4 w-4 text-gray-500 dark:text-gray-400" />
								</x-filter.filter-input-text>
							</div>
						@endcan

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.date-range />
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.filter-input-select id="dayoff-for" name="dayoff-for" :options="['Izin' => 'Izin', 'Sakit' => 'Sakit', 'Absen' => 'Absen', 'PC' => 'Pulang Cepat']"
								default-option="Filter by tipe permohonan" />
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.filter-input-select id="status" name="status" :options="['0' => 'Diajukan', '1' => 'Diterima', '2' => 'Ditolak', '3' => 'Dibatalkan']" default-option="Filter by status" />
						</div>

					</x-filter.filter-bar>
				</div>
				{{-- end filter --}}

				<div class="col-span-2" x-data="{ openRow: null }">
					<x-dashboard.table id="table-dayoff" :tablename="[
					    '0' => '#',
					    '1' => 'Aksi',
					    '2' => 'Pegawai',
					    '3' => 'Status / Tipe',
					    '4' => 'Jlh Hari',
					    '5' => 'Mulai / Selesai',
					]" />
				</div>

			</div>
		</div>
	</div>
@endsection
@push('script')
	<script>
		const dayoffIndex = "{{ route('dayoff.index') }}";
	</script>
	@vite(['resources/js/dayoff/index.js'])
@endpush
