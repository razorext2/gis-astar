@extends('dashboard.layoutsDash.app')
@section('content')
	{{-- <form id="add-collector" action="{{ route('collect.create') }}"></form> --}}
	<div class="relative grid grid-cols-1 gap-6">

		{{-- @can('collect-create')
			<div class="max-w-xs">
				<x-button.success id="add-button" form="add-collector" type="submit">
					<x-slot name="icon">
						<x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
					</x-slot>
					Tambah Data
				</x-button.success>
			</div>
		@endcan --}}

		<div class="flex h-auto items-center justify-center">
			<div
				class="grid w-full grid-cols-2 gap-2 rounded-xl bg-white p-2 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 md:gap-4 md:p-6">

				{{-- filter --}}
				<div class="col-span-2 mb-4">
					<x-filter.filter-bar>
						@can('collect-approve')
							<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
								<x-filter.filter-input-text id="no_sr" name="no_sr" :text="'no SR'">
									<x-icons.fingerprint class="h-4 w-4 text-gray-500 dark:text-gray-400" />
								</x-filter.filter-input-text>
							</div>
						@endcan

						<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
							<x-filter.filter-input-text id="customer_name" name="customer_name" :text="'nama customer'">
								<x-icons.font-case class="h-4 w-4 text-gray-500 dark:text-gray-400" />
							</x-filter.filter-input-text>
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.filter-input-select id="status" name="status" :options="['0' => 'Pending', '1' => 'Approved', '2' => 'Rejected']" default-option="Filter by status" />
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.date-range />
						</div>

					</x-filter.filter-bar>
				</div>
				{{-- end filter --}}

				<div class="col-span-2" x-data="{ openRow: null }">
					<x-dashboard.table id="table-collector" :tablename="[
					    '0' => '#',
					    '1' => 'Aksi',
					    '2' => 'No SR',
					    '3' => 'Customer',
					    '4' => 'Detail Tagihan',
					    '5' => 'Tanggal Penagihan',
					]" />
				</div>
			</div>
		</div>
	</div>
@endsection
@push('script')
	<script>
		const collectIndex = "{{ route('collect.index') }}";
	</script>
	@vite(['resources/js/collect/index.js'])
@endpush
