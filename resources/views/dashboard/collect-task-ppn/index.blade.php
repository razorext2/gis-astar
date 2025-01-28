@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="relative grid grid-cols-1 gap-6">

		<div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-[#18181b]">
			<ul class="flex flex-wrap text-center text-sm font-medium">
				<li>
					<a
						class="{{ Route::is('collect-task-ppn.index') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600"
						href="{{ route('collect-task-ppn.index') }}">Belum Tagih</a>
				</li>
				<li>
					<a
						class="{{ Route::is('collect-task-ppn.pending') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600"
						href="{{ route('collect-task-ppn.pending') }}">Tertunda</a>
				</li>
				<li>
					<a
						class="{{ Route::is('collect-task-ppn.onprogress') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600"
						href="{{ route('collect-task-ppn.onprogress') }}">Berjalan</a>
				</li>
				<li>
					<a
						class="{{ Route::is('collect-task-ppn.completed') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600"
						href="{{ route('collect-task-ppn.completed') }}">Selesai</a>
				</li>
			</ul>
		</div>

		@if (Auth::user()->can('collect-task-ppn-create') || Auth::user()->can('collect-task-ppn-assign'))
			<div class="inline-flex gap-4">

				@can('collect-task-ppn-create')
					<div>
						<form id="add-collect-task-ppn" action="{{ route('collect-task-ppn.create') }}"></form>
						<x-button.success id="add-button" form="add-collect-task-ppn" type="submit">
							<x-slot name="icon">
								<x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
							</x-slot>
							Tambah Data
						</x-button.success>
					</div>
				@endcan

				@can('collect-task-ppn-assign')
					<div>
						<form id="mass-assign-collect" action="{{ route('collect-task-ppn.mass-assign') }}"></form>
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
