@extends('dashboard.layoutsDash.app')
@section('content')
	<form id="add-collector" action="{{ route('collect.create') }}"></form>
	<div class="relative grid grid-cols-1 gap-6">

		@can('collect-create')
			<div class="max-w-xs">
				<x-button.success id="add-button" form="add-collector" type="submit">
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

				<div class="col-span-2" x-data="{ openRow: null }">

					<x-dashboard.table id="table-collector" :tablename="[
					    '0' => '#',
					    '1' => 'Aksi',
					    '2' => 'Nama Pegawai',
					    '3' => 'Judul',
					    '4' => 'Lokasi',
					    '5' => 'Tanggal Laporan',
					]" />

				</div>
			</div>
		</div>
	</div>
@endsection
@push('script')
	<script>
		let kode_pegawai = "{{ Auth::user()->kode_pegawai }}";
		const permissionDelete = @json(auth()->user()->can('collect-delete'));

		if (!kode_pegawai) {
			src = "{{ route('collectors.index') }}";
		} else {
			src = "{{ route('collect.index') }}";
		}
	</script>
	@vite(['resources/js/collect/index.js'])
@endpush
