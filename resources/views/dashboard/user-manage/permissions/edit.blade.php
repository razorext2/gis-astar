@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="space-y-6 xl:w-1/2">
		<div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 sm:p-6">

			<header class="flex flex-row gap-x-2">
				<x-button.link class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white"
					href="{{ route('permissions.index') }}" wire:navigate>
					<x-slot name="icon">
						<x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
					</x-slot>
					Kembali
				</x-button.link>
				<h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
					{{ __('Ubah Data Permission') }}
				</h2>
			</header>

			<div class="flex items-center justify-between">
				<p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
					{{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
				</p>

				@livewire('handler.permissions.delete', ['id' => $id])
			</div>

			@livewire('handler.permissions.update', ['id' => $id])

		</div>
	</div>
@endsection
