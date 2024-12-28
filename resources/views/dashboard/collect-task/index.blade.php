@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="relative grid grid-cols-1 gap-6">

		<div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-[#18181b]">
			<ul class="flex flex-wrap text-center text-sm font-medium">
				<li>
					<a
						class="{{ Route::is('collect-task.index') ? 'text-red-600 border-b-2 hover:border-gray-300' : 'text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-gray-600 dark:hover:text-gray-300"
						href="#">Belum Tagih</a>
				</li>
				<li>
					<a
						class="{{ Route::is('pegawai.attendancelist') ? 'text-red-600 border-b-2 hover:border-gray-300' : 'text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-gray-600 dark:hover:text-gray-300"
						href="#">Berjalan</a>
				</li>
				<li>
					<a
						class="{{ Route::is('pegawai.attendancelist') ? 'text-red-600 border-b-2 hover:border-gray-300' : 'text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-gray-600 dark:hover:text-gray-300"
						href="#">Selesai</a>
				</li>
			</ul>
		</div>

		@if (Auth::user()->can('collect-task-create') || Auth::user()->can('collect-task-assign'))
			<div class="inline-flex gap-4">

				@can('collect-task-create')
					<div>
						<form id="add-collect-task" action="{{ route('collect-task.create') }}"></form>
						<x-button.success id="add-button" form="add-collect-task" type="submit">
							<x-slot name="icon">
								<x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
							</x-slot>
							Tambah Data
						</x-button.success>
					</div>
				@endcan

				@can('collect-task-assign')
					<div>
						<form id="assign-task" action="{{ route('collect-task.assign') }}"></form>
						<x-button.primary id="assign-button" form="assign-task" type="submit">
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
