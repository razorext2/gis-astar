@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="relative grid grid-cols-1 gap-4">

		<div class="rounded-xl border border-gray-200 bg-white p-2 dark:border-gray-700 dark:bg-dark-primary md:p-6">

			{{-- desktop view --}}
			<div class="hidden items-center lg:flex">
				<ul class="flex flex-wrap gap-6 text-sm font-medium">
					<li>
						<a
							class="{{ Route::is('collect.index') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
							wire:navigate href="{{ route('collect.index') }}">Belum Dilengkapi</a>
					</li>
					<li>
						<a
							class="{{ Route::is('collect.submitted') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
							wire:navigate href="{{ route('collect.submitted') }}">Diajukan</a>
					</li>
					<li>
						<a
							class="{{ Route::is('collect.revision') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
							wire:navigate href="{{ route('collect.revision') }}">Perlu revisi</a>
					</li>
					<li>
						<a
							class="{{ Route::is('collect.approved') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
							wire:navigate href="{{ route('collect.approved') }}">Disetujui</a>
					</li>
					<li>
						<a
							class="{{ Route::is('collect.rejected') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
							wire:navigate href="{{ route('collect.rejected') }}">Ditolak</a>
					</li>
				</ul>

				<div class="absolute right-6 float-right">
					<x-button.success class="getCollectorExcel max-h-10" id="getCollectorExcel" type="button">
						<x-slot name="icon">
							<x-icons.angle-right class="icon h-6 w-6 text-red-500 dark:text-white" />
						</x-slot>
						Tarik Laporan
					</x-button.success>
				</div>
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
								class="{{ Route::is('collect.index') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} will-change-transformduration-300 inline-block w-full rounded-lg border-none p-3 text-sm transition-all ease-in-out hover:scale-105 hover:dark:bg-gray-500"
								href="{{ route('collect.index') }}">Belum Dilengkapi</a>
							</a>
						</li>
						<li>
							<a
								class="{{ Route::is('collect.submitted') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
								href="{{ route('collect.submitted') }}">Diajukan</a>
						</li>
						<li>
							<a
								class="{{ Route::is('collect.revision') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
								href="{{ route('collect.revision') }}">Perlu revisi</a>
						</li>
						<li>
							<a
								class="{{ Route::is('collect.approved') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
								href="{{ route('collect.approved') }}">Disetujui</a>
						</li>
						<li>
							<a
								class="{{ Route::is('collect.rejected') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
								href="{{ route('collect.rejected') }}">Ditolak</a>
						</li>
					</ul>
					<button
						class="getCollectorExcel flex w-full items-center rounded-lg bg-gray-50 p-3 text-center text-sm font-medium text-white transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:bg-green-100 dark:border-gray-600 dark:bg-green-700 dark:hover:bg-green-600"
						type="button">
						<x-slot name="icon">
							<x-icons.angle-right class="icon h-6 w-6 text-red-500 dark:text-white" />
						</x-slot>
						Tarik Laporan
					</button>
				</div>
			</div>
		</div>

		<div class="flex h-auto items-center justify-center">
			<div
				class="grid w-full grid-cols-2 gap-2 rounded-xl bg-white p-2 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 md:gap-4 md:p-6">

				{{-- filter --}}
				<div class="col-span-2 mb-4">
					<x-filter.filter-bar>
						<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
							<x-filter.filter-input-text id="no_sr" name="no_sr" :text="'no SR'">
								<x-icons.fingerprint class="h-4 w-4 text-gray-500 dark:text-gray-400" />
							</x-filter.filter-input-text>
						</div>

						<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
							<x-filter.filter-input-text id="kode_pegawai" name="kode_pegawai" :text="'kode jari pegawai'">
								<x-icons.fingerprint class="h-4 w-4 text-gray-500 dark:text-gray-400" />
							</x-filter.filter-input-text>
						</div>

						<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
							<x-filter.filter-input-text id="title" name="title" :text="'nama customer'">
								<x-icons.font-case class="h-4 w-4 text-gray-500 dark:text-gray-400" />
							</x-filter.filter-input-text>
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.filter-input-select id="bill_type" name="bill_type" :options="['idcnonppn' => 'IDC Non PPN', 'idcppn' => 'IDC PPN', 'idyppn' => 'IDY PPN']" default-option="Filter by tipe" />
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.date-range />
						</div>

					</x-filter.filter-bar>
				</div>
				{{-- end filter --}}

				{{-- subcontent --}}
				@yield('subcontent')

			</div>
		</div>
	</div>
@endsection
