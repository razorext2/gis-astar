@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="w-full rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 md:p-6">

		<header class="mb-4 flex items-center justify-between">
			<p class="text-lg font-semibold text-gray-900 dark:text-white lg:text-xl">
				Riwayat Poin Masuk
			</p>

			@can('point-redeem')
				<x-button.link class="text-sm text-green-500 ring-1 ring-green-500 hover:bg-green-300 dark:bg-green-800 md:text-base"
					href="{{ route('points.redeem', ['step' => 1]) }}" wire:navigate>
					<x-slot name="icon">
						<x-icons.plus class="icon h-6 w-6 text-green-500 dark:text-white" />
					</x-slot>
					Redeem
				</x-button.link>
			@endcan
		</header>

		@livewire('handler.point.technician.index')
	</div>
@endsection
