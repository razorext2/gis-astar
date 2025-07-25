@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="relative grid grid-cols-1 gap-6">

		<div
			class="relative grid grid-cols-1 rounded-xl bg-white py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">

			<div class="flex flex-col px-3 md:mb-2 lg:p-0">
				<div class="mb-2">
					<span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
						Manajemen Divisi
					</span>

					<p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
						Kamu dapat menambah divisi, mengubah nama divisi, dan menghapus data divisi.
					</p>
				</div>

				@can('divisi-create')
					<div class="max-w-xs">
						<x-button.link class="w-fit ring-1 ring-green-700 dark:bg-green-800 dark:text-white"
							href="{{ route('division.create') }}" wire:navigate>
							<x-slot name="icon">
								<x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
							</x-slot>
							Tambah Data
						</x-button.link>
					</div>
				@endcan

			</div>

			<livewire:table-refresher table-name="DivisionTable" />

		</div>
	</div>
@endsection
