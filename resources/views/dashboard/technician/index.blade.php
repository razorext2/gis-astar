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

		<div class="rounded-xl border border-gray-200 bg-white p-2 dark:border-gray-700 dark:bg-[#18181b] md:p-6">

			{{-- desktop view --}}
			<div class="hidden items-center lg:flex">
				<ul class="flex flex-wrap gap-6 text-sm font-medium">
					<li>
						<a
							class="{{ Route::is('technician.index') && !Request::query('status') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
							href="{{ route('technician.index') }}">Belum Update</a>
					</li>
					<li>
						<a
							class="{{ Route::is('technician.index') && Request::query('status') == 1 ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
							href="{{ route('technician.index', ['status' => 1]) }}">Sudah Update</a>
					</li>
				</ul>
			</div>

			{{-- mobile view --}}
			<div class="lg:hidden" id="sub-navbar" x-data="{ open: false }">
				{{-- button --}}
				<button
					class="flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 p-2.5 font-medium text-gray-500 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800"
					type="button" @click="open = ! open">
					<span>Actions...</span>
					<svg class="h-3 w-3 shrink-0 transform transition-transform duration-300" aria-hidden="true"
						:class="{ 'rotate-180 ': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
					</svg>
				</button>

				{{-- list --}}
				<div class="mt-2 grid w-full gap-2 md:mt-4 md:gap-4" x-show="open" x-transition>
					<ul class="rounded-lg bg-white text-gray-700 shadow dark:bg-gray-800 dark:text-gray-200">
						<li>
							<a
								class="{{ Route::is('technician.index') && !Request::query('status') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} will-change-transformduration-300 inline-block w-full rounded-lg border-none p-3 text-sm transition-all ease-in-out hover:scale-105 hover:dark:bg-gray-500"
								href="{{ route('technician.index') }}">Belum Update</a>
							</a>
						</li>
						<li>
							<a
								class="{{ Route::is('technician.index') && Request::query('status') == 1 ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
								href="{{ route('technician.index', ['status' => 1]) }}">Sudah Update</a>
						</li>
					</ul>

				</div>
			</div>
		</div>

		<div class="flex h-auto items-center justify-center">
			<div
				class="grid w-full grid-cols-2 gap-2 rounded-xl bg-white p-2 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 md:gap-4 md:p-6">

				{{-- filter --}}
				<div class="col-span-2 mb-4">
					<x-filter.filter-bar>

						<div class="col-span-2 w-full">

							<div class="grid grid-cols-3 gap-2 md:gap-4">
								<div class="col-span-3 w-full lg:col-span-1">
									<x-input.basic id="kode_pegawai" name="kode_pegawai" placeholder="Cari kode jari..." required
										:labels="false" />
								</div>
								<div class="col-span-3 w-full lg:col-span-1">
									<x-input.basic id="customer_name" name="customer_name" placeholder="Cari nama customer..." required
										:labels="false" />
								</div>

								<div class="col-span-3 w-full lg:col-span-1">
									<x-input.basic id="no_vt" name="no_vt" placeholder="Cari nomor kunjungan..." required :labels="false" />
								</div>
							</div>

						</div>

						<div class="col-span-2 w-full lg:col-span-1">
							<x-input.select id="total_data" name="total_data" :labels="false" :options="[
							    '10' => '10',
							    '50' => '50',
							    '100' => '100',
							    '500' => '500',
							    '1000' => '1000',
							    '2500' => '2500',
							    '5000' => '5000',
							    '10000' => '10000',
							]" default-option="Total data">
							</x-input.select>
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
