<div class="grid w-full gap-2 lg:grid-cols-2">

	@if ($data->count() > 0)
		@foreach ($data as $index => $row)
			@php
				$storage_path = "labels/{$row->pegawaiRelasi->kode_pegawai}/capturedImg/{$row->photoURL}.png";
				$img_check = Storage::disk('public')->exists($storage_path);
				$image_path = asset(sha1('libs') . '/' . $row->photoURL . '.png');
				$no_image_path = asset('assets/img/noImage.webp');
			@endphp

			<div wire:click="openModal({{ $row->id }})"
				class="relative flex cursor-pointer flex-col items-center rounded-lg border-gray-200 shadow-sm transition-transform duration-300 hover:scale-95 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-700 dark:hover:bg-gray-700 md:flex-row">

				@php $lateDuration = $this->getLateDuration($row->jam_masuk); @endphp
				@if ($lateDuration)
					<span class="absolute right-2 top-2 rounded-lg bg-red-800 px-2 py-1 text-xs text-white">
						+ {{ $lateDuration }}
					</span>
				@endif

				<img class="h-44 w-full rounded-t-lg object-cover md:h-44 md:w-48 md:rounded-none md:rounded-s-lg"
					src="{{ $img_check ? $image_path : $no_image_path }}" alt="">

				<div class="flex flex-col justify-between gap-y-1 p-4 leading-normal">
					<h5 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white md:text-xl">
						{{ $row->pegawaiRelasi->full_name }}
					</h5>
					<p class="text-sm text-gray-700 dark:text-gray-400">
						Melakukan <span class="text-green-400">checkin</span> pada pukul
						<span class="text-green-400">{{ \Carbon\Carbon::parse($row->jam_masuk)->format('H:i:s') }}</span>
					</p>
				</div>
			</div>
		@endforeach
	@else
		<p class="col-span-2 w-full text-center text-gray-800 dark:text-white"> Belum ada data. </p>
	@endif

	<div wire:show="showModal" wire:transition.duration.300ms
		class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
		@if ($showModal)
			<!-- Modal box -->
			<div class="mx-2 flex flex-col gap-2 rounded-xl bg-white p-4 shadow-2xl dark:bg-gray-800 sm:mx-0 md:w-1/3 lg:p-6">
				<h2 class="text-center text-2xl font-semibold text-gray-900 dark:text-white lg:text-3xl">Detail
				</h2>
				<div class="flex w-full flex-col gap-2 text-gray-800 dark:text-white">

					<div class="h-72 lg:h-96">
						<img onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}'"
							class="h-full w-full rounded-md object-cover"
							src="{{ asset(sha1('libs') . '/' . $attendance->photoURL . '.png') }}" alt="">
					</div>

					<p class="text-lg font-semibold lg:text-2xl">{{ $attendance->pegawaiRelasi->full_name }}</p>
					<p class="text-sm text-gray-700 dark:text-gray-400">Melakukan <span class="text-green-400">checkin</span> pada
						pukul
						<span class="text-green-400">{{ \Carbon\Carbon::parse($attendance->jam_masuk)->format('H:i:s') }}</span> di
						<span class="text-green-400">{{ $address }}</span>
					</p>

					<a class="flex flex-row"
						href="https://www.google.com/maps/search/?api=1&query={{ $attendance->latitude }},{{ $attendance->longitude }}"
						target="_blank">Lihat lokasi <x-icons.arrow-right class="ml-1 h-5 w-5 -rotate-45" /></a>

					<div class="flex justify-between">
						<p class="text-xs">Coord: {{ $attendance->latitude }}, {{ $attendance->longitude }} </p>
						<p class="text-xs">Created at: {{ $attendance->created_at }}</p>
					</div>
				</div>

				<div class="mt-4">
					<x-button.primary class="w-full justify-center" wire:click="set('showModal', false)">
						Ok
					</x-button.primary>
				</div>
			</div>
		@endif
	</div>
</div>
