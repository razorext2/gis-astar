@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="relative grid grid-cols-1 gap-4">

		<div
			class="rounded-xl border border-gray-200 bg-white p-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none md:p-6">
			{{-- desktop view --}}
			<div class="hidden items-center lg:flex">
				<ul class="flex flex-wrap gap-6 text-sm font-medium">
					<li>
						<a
							class="{{ Route::is('driver.index') && !Request::query('status') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
							wire:navigate href="{{ route('driver.index') }}">Semua Laporan</a>
					</li>

					@can('driver-approve')
						<li>
							<a
								class="{{ Route::is('driver.index') && Request::query('status') && Request::query('status') == 'notassigned' ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
								wire:navigate href="{{ route('driver.index', ['status' => 'notassigned']) }}">Belum di Assign</a>
						</li>
					@endcan

					<li>
						<a
							class="{{ Route::is('driver.index') && Request::query('status') && Request::query('status') == 'notupdated' ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
							wire:navigate href="{{ route('driver.index', ['status' => 'notupdated']) }}">Belum Diupdate(SR)</a>
					</li>

					<li>
						<a
							class="{{ Route::is('driver.index') && Request::query('status') && Request::query('status') == 'unapproved' ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
							wire:navigate href="{{ route('driver.index', ['status' => 'unapproved']) }}">Belum Disetujui</a>
					</li>
					<li>
						<a
							class="{{ Route::is('driver.index') && Request::query('status') && Request::query('status') == 'needrevision' ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
							wire:navigate href="{{ route('driver.index', ['status' => 'needrevision']) }}">Perlu Revisi</a>
					</li>
					<li>
						<a
							class="{{ Route::is('driver.index') && Request::query('status') && Request::query('status') == 'approved' ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
							wire:navigate href="{{ route('driver.index', ['status' => 'approved']) }}">Disetujui</a>
					</li>
					<li>
						<a
							class="{{ Route::is('driver.index') && Request::query('status') && Request::query('status') == 'rejected' ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
							wire:navigate href="{{ route('driver.index', ['status' => 'rejected']) }}">Ditolak</a>
					</li>
				</ul>
			</div>

			{{-- mobile view --}}
			<div class="lg:hidden" id="sub-navbar" x-data="{ open: false }">
				{{-- button --}}
				<button
					class="flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 p-2.5 font-medium text-gray-500 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800"
					type="button" @click="open = ! open">
					<span>Menu...</span>
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
								class="{{ Route::is('driver.index') && !Request::query('status') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} will-change-transformduration-300 inline-block w-full rounded-lg border-none p-3 text-sm transition-all ease-in-out hover:scale-105 hover:dark:bg-gray-500"
								href="{{ route('driver.index') }}">Semua Laporan</a>
						</li>

						@can('driver-approve')
							<li>
								<a
									class="{{ Route::is('driver.index') && Request::query('status') == 'notassigned' ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
									href="{{ route('driver.index', ['status' => 'notassigned']) }}">Belum di Assign</a>
							</li>
						@endcan

						<li>
							<a
								class="{{ Route::is('driver.index') && Request::query('status') == 'notupdated' ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
								href="{{ route('driver.index', ['status' => 'notupdated']) }}">Belum di Update (SR)</a>
						</li>

						<li>
							<a
								class="{{ Route::is('driver.index') && Request::query('status') == 'needrevision' ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
								href="{{ route('driver.index', ['status' => 'needrevision']) }}">Perlu Revisi</a>
						</li>
						<li>
							<a
								class="{{ Route::is('driver.index') && Request::query('status') == 'approved' ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
								href="{{ route('driver.index', ['status' => 'approved']) }}">Disetujui</a>
						</li>
						<li>
							<a
								class="{{ Route::is('driver.index') && Request::query('status') == 'rejected' ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
								href="{{ route('driver.index', ['status' => 'rejected']) }}">Ditolak</a>
						</li>
					</ul>
				</div>

			</div>
		</div>

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
			class="relative grid grid-cols-1 rounded-xl bg-white py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">

			<livewire:table-refresher table-name="DriverTable" />

		</div>
	</div>
@endsection
