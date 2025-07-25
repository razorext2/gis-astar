@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="relative grid grid-cols-1 gap-6">

		<div
			class="rounded-xl border border-gray-200 bg-white p-4 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none">
			<ul class="flex flex-wrap text-center text-sm font-medium">
				<li>
					<a
						class="{{ Route::is('collect-idy-ppn.index') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600"
						href="{{ route('collect-idy-ppn.index') }}">Belum Tagih</a>
				</li>
				<li>
					<a
						class="{{ Route::is('collect-idy-ppn.pending') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600"
						href="{{ route('collect-idy-ppn.pending') }}">Tertunda</a>
				</li>
				<li>
					<a
						class="{{ Route::is('collect-idy-ppn.onprogress') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600"
						href="{{ route('collect-idy-ppn.onprogress') }}">Berjalan</a>
				</li>
				<li>
					<a
						class="{{ Route::is('collect-idy-ppn.completed') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600"
						href="{{ route('collect-idy-ppn.completed') }}">Selesai</a>
				</li>
			</ul>
		</div>

		@if (Auth::user()->can('collect-idy-ppn-create') || Auth::user()->can('collect-idy-ppn-assign'))
			<div class="inline-flex gap-4">

				@can('collect-idy-ppn-create')
					<div>
						<form id="add-collect-idy-ppn" action="{{ route('collect-idy-ppn.create') }}"></form>
						<x-button.success id="add-button" form="add-collect-idy-ppn" type="submit">
							<x-slot name="icon">
								<x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
							</x-slot>
							Tambah Data
						</x-button.success>
					</div>
				@endcan

				@can('collect-idy-ppn-assign')
					<div>
						<form id="mass-assign-collect" action="{{ route('collect-idy-ppn.mass-assign') }}"></form>
						<x-button.primary id="assign-button" form="mass-assign-collect" type="submit">
							<x-slot name="icon">
								<x-icons.file-circle-plus class="h-6 w-6 text-green-500 dark:text-white" />
							</x-slot>
							Mass Assign
						</x-button.primary>
					</div>
				@endcan

			</div>
		@endif

		@yield('subcontent')

	</div>
@endsection
