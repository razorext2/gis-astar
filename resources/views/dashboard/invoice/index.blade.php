@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="relative grid grid-cols-1 gap-4">

		<div
			class="flex flex-col rounded-xl bg-white p-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">

			<span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
				Manajemen Invoice
			</span>

			<p class="text-base text-gray-600 dark:text-gray-400">
				Kamu dapat menambah invoice, mengubah nama invoice, dan menghapus data invoice.
			</p>

		</div>

		@can(['invoice-list', 'invoice-add'])
			<div class="max-w-xs">
				<x-button.link wire:navigate class="w-fit ring-1 ring-green-700 dark:bg-green-800 dark:text-white"
					href="{{ route('invoice.create') }}">
					<x-slot name="icon">
						<x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
					</x-slot>
					Tambah Invoice
				</x-button.link>
			</div>
		@endcan

		<div
			class="rounded-xl bg-white p-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">
			<livewire:table-refresher table-name="InvoiceTable" />
		</div>
	</div>
@endsection
