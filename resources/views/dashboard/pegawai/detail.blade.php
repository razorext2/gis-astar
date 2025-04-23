@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="mb-8 rounded-xl border border-gray-200 bg-white p-6 py-4 dark:border-gray-700 dark:bg-dark-primary">
		<div class="w-full">
			<div class="flex flex-row items-center gap-x-4">
				<div class="max-w-xs">
					<x-button.link class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white" href="{{ route('pegawai.index') }}"
						wire:navigate>
						<x-slot name="icon">
							<x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
						</x-slot>
						Kembali
					</x-button.link>
				</div>
				<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
					<ul class="flex flex-wrap text-center text-sm font-medium" role="tablist">
						<li role="presentation">
							<a
								class="{{ Route::is('pegawai.detail') ? 'text-red-600 border-b-2 hover:border-gray-300' : 'text-gray-400' }} inline-block rounded-t-lg p-4 hover:text-gray-600 dark:hover:text-gray-300"
								href="{{ route('pegawai.detail', $pegawai->id) }}">Profile</a>
						</li>
						<li role="presentation">
							<a
								class="{{ Route::is('pegawai.payrollinfo') ? 'text-red-600 border-b-2 hover:border-gray-300' : 'text-gray-400' }} inline-block rounded-t-lg p-4 hover:text-gray-600 dark:hover:text-gray-300"
								href="{{ route('pegawai.payrollinfo', $pegawai->id) }}">Payroll</a>
						</li>
						<li role="presentation">
							<a
								class="{{ Route::is('pegawai.timeline') ? 'text-red-600 border-b-2 hover:border-gray-300' : 'text-gray-400' }} inline-block rounded-t-lg p-4 hover:text-gray-600 dark:hover:text-gray-300"
								href="{{ route('pegawai.timeline', $pegawai->kode_pegawai) }}">Timeline</a>
						</li>

						@if ($pegawai->userRelasi->hasRole('Collector'))
							<li role="presentation">
								<a
									class="{{ Route::is('pegawai.collectors') ? 'text-red-600 border-b-2 hover:border-gray-300' : 'text-gray-400' }} inline-block rounded-t-lg p-4 hover:text-gray-600 dark:hover:text-gray-300"
									href="{{ route('pegawai.collectors', $pegawai->kode_pegawai) }}">Laporan Kolektor</a>
							</li>
						@endif

						@if ($pegawai->userRelasi->hasRole(['Sales', 'Sales-JKT']))
							<li role="presentation">
								<a
									class="{{ Route::is('pegawai.sales') ? 'text-red-600 border-b-2 hover:border-gray-300' : 'text-gray-400' }} inline-block rounded-t-lg p-4 hover:text-gray-600 dark:hover:text-gray-300"
									href="{{ route('pegawai.sales', $pegawai->kode_pegawai) }}">Laporan Sales</a>
							</li>
						@endif
					</ul>

				</div>

			</div>
		</div>
	</div>

	<div id="mainContent">
		@yield('menus')
	</div>
@endsection
