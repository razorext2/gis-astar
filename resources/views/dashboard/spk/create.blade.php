@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="flex flex-col gap-4">
		<div
			class="flex flex-row items-center gap-2 rounded-xl bg-white px-3 py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:gap-4 lg:p-6">

			<div>
				<x-button.link href="{{ route('spk.index') }}" class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white"
					wire:navigate id="back-button">
					<x-slot name="icon">
						<x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
					</x-slot>
					Kembali
				</x-button.link>
			</div>

			<div>
				<span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
					Tambah SPK
				</span>

				<p class="text-sm text-gray-600 dark:text-gray-400 md:text-base">
					Manajemen SPK adalah feature yang diperuntukkan untuk Marketing dalam mengelola data SPK Customer.
				</p>
			</div>

		</div>

		@livewire('handler.spk.create')
	</div>
@endsection
