@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="mb-16 flex flex-col text-gray-800 dark:text-white">
		<div
			class="relative flex flex-col gap-4 rounded-xl bg-white p-2 shadow-md ring-1 ring-gray-200 transition-all duration-500 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 md:p-4 lg:p-6">

			<div class="col-span-2 mb-4 flex w-full flex-row items-center gap-4">
				<div class="max-w-xs">
					<x-button.link wire:navigate href="{{ route('event.show', $participant->bigEventId->id) }}"
						class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white">
						<x-slot name="icon">
							<x-icons.angle-right class="h-6 w-6 rotate-180 text-red-500 dark:text-white" />
						</x-slot>
						Kembali
					</x-button.link>
				</div>

				<div class="w-full">
					<h1 class="text-lg font-semibold"> Detail Partisipan Event {{ ucwords($participant->bigEventId->name) }} </h1>
				</div>
			</div>

			<div class="col-span-2 grid grid-cols-2">
				<div
					class="col-span-2 rounded-xl border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:p-4">
					<p class="text-xs italic"> Nama Partisipan </p>
					<p class="font-semibold"> {{ ucwords($participant->userId->name) }}</p>
				</div>

			</div>

			<div class="col-span-2 flex flex-col gap-1">
				<div class="w-full">
					<h2 class="text-lg font-semibold">Riwayat Visitor</h2>
					<p class="text-gray-800 dark:text-gray-400"> Berikut adalah riwayat visitor yang mengakses API partisipan:
						{{ ucwords($participant->userId->name) }} </p>
				</div>

				<div class="flex flex-col rounded-xl bg-gray-50 dark:bg-dark-secondary">
					@forelse ($participant->bigEventVisitor as $row)
						<div
							class="{{ $loop->first ? 'rounded-t-xl' : '' }} {{ $loop->last ? 'rounded-b-xl' : '' }} grid grid-cols-3 gap-1 border-[1px] border-gray-600 p-2 lg:p-4">
							<p class="text-gray-800 dark:text-gray-400"> {{ $row->ip }} </p>
							<p class="text-gray-800 dark:text-gray-400"> {{ $row->ua }} </p>
							<p class="text-gray-800 dark:text-gray-400"> {{ $row->second_bucket }} </p>
						</div>
					@empty
						<p class="p-4 text-center italic text-red-500"> Belum ada yang mengunjungi link
							{{ ucwords($participant->userId->name) }} </p>
					@endforelse
				</div>

			</div>

		</div>
	</div>
@endsection
