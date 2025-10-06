@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="mb-16 flex flex-col text-gray-800 dark:text-white">
		<div
			class="relative flex flex-col gap-4 rounded-xl bg-white p-2 shadow-md ring-1 ring-gray-200 transition-all duration-500 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 md:p-4 lg:p-6">

			<div class="col-span-2 mb-4 flex w-full flex-row items-center gap-4">
				<div class="max-w-xs">
					<x-button.link wire:navigate href="{{ route('event.index') }}"
						class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white">
						<x-slot name="icon">
							<x-icons.angle-right class="h-6 w-6 rotate-180 text-red-500 dark:text-white" />
						</x-slot>
						Kembali
					</x-button.link>
				</div>

				<div class="w-full">
					<h1 class="text-lg font-semibold"> Detail Event {{ ucwords($event->name) }} </h1>
				</div>
			</div>

			<div class="col-span-2 grid grid-cols-2">
				<div
					class="col-span-2 rounded-t-xl border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:rounded-tr-xl lg:p-4">
					<p class="text-xs italic"> Nama Event </p>
					<p class="font-semibold"> {{ ucwords($event->name) }}</p>
				</div>

				<div
					class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:rounded-tr-none lg:p-4">
					<p class="text-xs italic">Lokasi Event Diselenggarakan</p>
					<p class="font-semibold"> {{ $event->location }}</p>
				</div>

				<div
					class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:p-4">
					<p class="text-xs italic">Tanggal Event </p>
					<p class="font-semibold"> {{ $event->start_date }} - {{ $event->end_date }}</p>
				</div>

				<div
					class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:p-4">
					<p class="text-xs italic"> Deskripsi </p>
					<p class="font-semibold"> {{ $event->description }}</p>
				</div>

				<div
					class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-bl-xl lg:p-4">
					<p class="text-xs italic"> Ditambah Pada </p>
					<p class="font-semibold"> {{ $event->created_at }}</p>
				</div>

				<div
					class="col-span-2 rounded-b-xl border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-bl-none lg:p-4">
					<p class="text-xs italic"> Diupdate Pada </p>
					<p class="font-semibold"> {{ $event->updated_at }}</p>
				</div>

			</div>

			<div class="col-span-2 flex flex-col gap-1">
				<div class="w-full">
					<h2 class="text-lg font-semibold">Daftar Partisipan</h2>
					<p class="text-gray-800 dark:text-gray-400"> Berikut adalah partisipan yang aktif pada event ini </p>
				</div>

				{{-- form create partisipan --}}
				@livewire('handler.big-event-participant.create', ['big_event_id' => $event->id])

				{{-- table partisipan --}}
				@livewire('big-event-participant-table', ['id' => $event->id])
			</div>

		</div>
	</div>
@endsection
