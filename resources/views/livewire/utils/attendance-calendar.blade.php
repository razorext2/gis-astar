<div class="flex flex-col gap-4">
	<div class="w-full">
		<header class="flex flex-col">
			<h2 class="text-xl font-medium text-gray-900 dark:text-white">
				<span class="!text-md text-gray-700 dark:text-gray-300">Periode: </span>

				<span id="choosenPeriod">
					{{ Request::query('period') ? \Carbon\Carbon::parse(Request::query('period'))->locale('id')->isoFormat('MMMM YYYY') : \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }}
				</span>

			</h2>
			<p class="text-sm text-gray-700 dark:text-gray-300">
				Informasi absensi pegawai untuk periode yang dipilih. Data ini mencakup clockin dan clockout setiap hari.
			</p>
		</header>
	</div>

	<div
		class="grid grid-cols-7 gap-2 rounded-xl border border-gray-200 p-4 text-center dark:border-gray-700 dark:bg-dark-secondary">
		<!-- Nama-nama hari -->
		<span class="font-medium text-gray-900 dark:text-white">Min</span>
		<span class="font-medium text-gray-900 dark:text-white">Sen</span>
		<span class="font-medium text-gray-900 dark:text-white">Sel</span>
		<span class="font-medium text-gray-900 dark:text-white">Rab</span>
		<span class="font-medium text-gray-900 dark:text-white">Kam</span>
		<span class="font-medium text-gray-900 dark:text-white">Jum</span>
		<span class="font-medium text-gray-900 dark:text-white">Sab</span>

		<!-- Looping untuk menampilkan tanggal -->
		@foreach ($dates as $date)
			@if ($date)
				@php
					$hasData = $attendanceData->contains(function ($attendance) use ($date) {
					    return \Carbon\Carbon::parse($attendance->jam_masuk)->isSameDay($date);
					});
				@endphp
				<div>
					<button
						class="{{ $hasData
						    ? 'bg-green-500 hover:bg-green-600 text-white dark:bg-green-800 dark:hover:bg-green-900 dark:text-white'
						    : 'bg-gray-200 text-gray-400 hover:bg-gray-300 dark:bg-transparent dark:text-gray-300' }} h-full w-full cursor-pointer rounded-lg border border-gray-200 p-2 dark:border-gray-700"
						type="button" wire:click="showAttendance('{{ $date }}')">
						{{ \Carbon\Carbon::parse($date)->isoFormat('D') }}
					</button>
				</div>
			@else
				<div></div>
			@endif
		@endforeach
	</div>

	<span class="text-gray-800 dark:text-white" wire:target="showAttendance" wire:loading>Memuat data...</span>

	<ul class="w-full space-y-2">
		@if (collect($clockIn)->isNotEmpty())
			@foreach ($clockIn as $row)
				<li
					class="flex w-full flex-col items-center gap-0 rounded-lg border border-gray-200 bg-white shadow-md hover:bg-gray-100 dark:border-gray-700 dark:bg-dark-secondary dark:shadow-none dark:hover:bg-gray-700 sm:gap-2 md:flex-row">
					<img class="h-24 w-full rounded-t-lg object-cover md:w-20 md:rounded-none md:rounded-s-lg"
						onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}'"
						src="{{ asset('storage/labels/' . auth()->user()->kode_pegawai . '/capturedImg/' . $row->photoURL . '.png') }}"
						alt="">
					<div class="flex flex-col p-2 text-left leading-normal">
						<h5 class="font-semi-bold text-wrap text-sm tracking-tight text-gray-900 dark:text-white">
							Melakukan <i class="text-green-500 dark:text-green-400">clockin</i> pukul
							{{ \Carbon\Carbon::parse($row->jam_masuk)->locale('id')->isoFormat('HH:mm:ss dddd, D MMMM YYYY') }}
						</h5>
						<p class="font-normal text-gray-700 dark:text-gray-400">
							<x-dashboard.location-w-coordinate :lat="$row->latitude" :long="$row->longitude" />
						</p>
					</div>
				</li>
			@endforeach
			@foreach ($clockOut as $row)
				<li
					class="flex w-full flex-col items-center gap-0 rounded-lg border border-gray-200 bg-white shadow-md hover:bg-gray-100 dark:border-gray-700 dark:bg-dark-secondary dark:shadow-none dark:hover:bg-gray-700 sm:gap-2 md:flex-row">
					<img class="h-24 w-full rounded-t-lg object-cover md:w-20 md:rounded-none md:rounded-s-lg"
						onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}'"
						src="{{ asset('storage/labels/' . auth()->user()->kode_pegawai . '/capturedImg/' . $row->photoURL . '.png') }}"
						alt="">
					<div class="flex flex-col p-2 text-left leading-normal">
						<h5 class="font-semi-bold text-wrap text-sm tracking-tight text-gray-900 dark:text-white">
							Melakukan <i class="text-red-500 dark:text-red-400">clockout</i> pukul
							{{ \Carbon\Carbon::parse($row->jam_keluar)->locale('id')->isoFormat('HH:mm:ss dddd, D MMMM YYYY') }}
						</h5>
						<p class="font-normal text-gray-700 dark:text-gray-400">
							<x-dashboard.location-w-coordinate :lat="$row->latitude" :long="$row->longitude" />
						</p>
					</div>
				</li>
			@endforeach
		@else
			<li
				class="flex w-full flex-col items-center gap-0 rounded-lg border border-gray-200 bg-white shadow-md hover:bg-gray-100 dark:border-gray-700 dark:bg-dark-secondary dark:shadow-none dark:hover:bg-gray-700 sm:gap-2 md:flex-row">
				<div class="flex flex-col p-2 text-left leading-normal">
					<h5 class="font-semi-bold text-wrap text-sm tracking-tight text-gray-900 dark:text-white">
						Tidak ada data absensi
					</h5>
				</div>
			</li>
		@endif
	</ul>
</div>
