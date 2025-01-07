@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="relative grid grid-cols-1 gap-6">

		<div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-[#18181b]">
			<ul class="flex flex-wrap text-center text-sm font-medium">
				<li>
					<a
						class="{{ Route::is('collect.index') ? 'text-red-600 border-b-2 hover:border-gray-300' : 'text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-gray-600 dark:hover:text-gray-300"
						href="{{ route('collect.index') }}">Belum Dilengkapi</a>
				</li>
				<li>
					<a
						class="{{ Route::is('collect.submitted') ? 'text-red-600 border-b-2 hover:border-gray-300' : 'text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-gray-600 dark:hover:text-gray-300"
						href="{{ route('collect.submitted') }}">Diajukan</a>
				</li>
				<li>
					<a
						class="{{ Route::is('collect.approved') ? 'text-red-600 border-b-2 hover:border-gray-300' : 'text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-gray-600 dark:hover:text-gray-300"
						href="{{ route('collect.approved') }}">Disetujui</a>
				</li>
				<li>
					<a
						class="{{ Route::is('collect.rejected') ? 'text-red-600 border-b-2 hover:border-gray-300' : 'text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-gray-600 dark:hover:text-gray-300"
						href="{{ route('collect.rejected') }}">Ditolak</a>
				</li>
			</ul>
		</div>

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
							<x-filter.filter-input-text id="title" name="title" :text="'nama customer'">
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
				@yield('subcontent')

			</div>
		</div>
	</div>
@endsection
