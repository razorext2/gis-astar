@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="w-full rounded-xl border border-gray-200 bg-white p-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none md:p-6 lg:w-2/3 xl:w-1/2">
		<div class="flex flex-row justify-between">
			<div>
				<h2 class="w-full text-lg font-semibold text-gray-900 dark:text-white">Ubah tim</h2>
				<p class="text-md text-gray-600 dark:text-gray-300"> Silahkan ubah data tim berikut. </p>
			</div>

			<div>
				<x-button.link wire:navigate
					class="ring-1 ring-red-700 hover:bg-red-300 dark:bg-red-800 dark:text-white dark:ring-gray-700 dark:hover:bg-red-900"
					href="{{ route('teams.index') }}">
					<x-slot name="icon">
						<x-icons.angle-left class="icon h-6 w-6 text-red-500 dark:text-white" />
					</x-slot>
					Kembali
				</x-button.link>
			</div>

		</div>

		{{-- livewire index component --}}
		@livewire('handler.teams.edit', ['team_code' => $team_code])
	</div>
@endsection
