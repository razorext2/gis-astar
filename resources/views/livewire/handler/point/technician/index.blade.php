<div class="flex flex-col gap-4">

	<div id="filter-bar" x-data="{ open: false }">
		<h2>
			<button
				class="flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 p-2.5 font-medium text-gray-500 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800"
				type="button" @click="open = ! open">
				<span>Filter data...</span>
				<svg class="h-3 w-3 shrink-0 transform transition-transform duration-300" aria-hidden="true"
					:class="{ 'rotate-180 ': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
				</svg>
			</button>
		</h2>

		{{-- body --}}
		<div x-show="open" x-transition:enter="transition ease-out duration-300"
			x-transition:enter-start="opacity-0 -translate-y-5" x-transition:enter-end="opacity-100 "
			x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 "
			x-transition:leave-end="opacity-0 -translate-y-5">

			<div class="mt-4 grid grid-cols-2 gap-2 lg:grid-cols-3">
				<div>
					<x-input.basic id="kodepegawai" maxlength="10" name="kodepegawai" wire:model.live.throttle.150ms="kodepegawai"
						placeholder="Cari kode pegawai...">
						Kode pegawai:
					</x-input.basic>
				</div>

				<div>
					<x-input.basic id="name" maxlength="30" name="name" wire:model.live.throttle.150ms="name"
						placeholder="Cari nama pegawai...">
						Nama pegawai:
					</x-input.basic>
				</div>

				<div>
					<x-input.basic id="no_vt" maxlength="10" name="no_vt" wire:model.live.throttle.150ms="no_vt"
						placeholder="Cari nomor kunjungan...">
						Nomor kunjungan:
					</x-input.basic>
				</div>

				<div>
					<x-input.select id="is_redeemed" name="is_redeemed" wire:model.change="is_redeemed"
						placeholder="Cari status redeem..." defaultOption="Semua" :options="['0' => 'Belum di redeem', '1' => 'Sudah di redeem']" :textLabel="__('Status redeem:')" />
				</div>

				<div>
					<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
						for="from_date">{{ __('Tanggal awal:') }}
					</label>
					<input
						class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
						type="date" id="from_date" name="from_date" wire:model.live="from_date" placeholder="Cari tanggal awal...">
				</div>

				<div>
					<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
						for="to_date">{{ __('Tanggal akhir:') }}
					</label>
					<input
						class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
						type="date" id="to_date" name="to_date" wire:model.live="to_date" placeholder="Cari tanggal akhir...">
				</div>
			</div>

		</div>
	</div>

	<div class="inline-flex gap-2 text-xs">
		@if (isset($kodepegawai))
			<p class="rounded-lg bg-gray-200 px-2 py-0.5 text-gray-500 dark:bg-gray-800 dark:text-gray-300">
				Kode pegawai: <b class="text-green-500">{{ $kodepegawai }}</b>
			</p>
		@endif

		@if (isset($name))
			<p class="rounded-lg bg-gray-200 px-2 py-0.5 text-gray-500 dark:bg-gray-800 dark:text-gray-300">
				Nama : <b class="text-green-500">{{ $name }}</b>
			</p>
		@endif

		@if (isset($no_vt))
			<p class="rounded-lg bg-gray-200 px-2 py-0.5 text-gray-500 dark:bg-gray-800 dark:text-gray-300">
				No. VT: <b class="text-green-500">{{ $no_vt }}</b>
			</p>
		@endif

		@if (isset($is_redeemed))
			<p class="rounded-lg bg-gray-200 px-2 py-0.5 text-gray-500 dark:bg-gray-800 dark:text-gray-300">
				Status: <b class="text-green-500">{{ $is_redeemed == 0 ? 'Belum di redeem' : 'Sudah di redeem' }}</b>
			</p>
		@endif

		@if (isset($from_date))
			<p class="rounded-lg bg-gray-200 px-2 py-0.5 text-gray-500 dark:bg-gray-800 dark:text-gray-300">
				Dari: <b class="text-green-500">{{ $from_date }}</b>
			</p>
		@endif

		@if (isset($to_date))
			<p class="rounded-lg bg-gray-200 px-2 py-0.5 text-gray-500 dark:bg-gray-800 dark:text-gray-300">
				Sampai: <b class="text-green-500">{{ $to_date }}</b>
			</p>
		@endif
	</div>

	{{ $pointData->onEachSide(1)->links() }}
	<ol class="relative ml-2 border-s border-gray-200 dark:border-gray-700">
		@foreach ($pointData as $point)
			<li class="mb-10 ms-8">
				<div class="flex flex-col gap-y-1">
					<span
						class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-green-100 ring-4 ring-green-200 dark:bg-green-900 dark:ring-green-700">
						<x-icons.wallet class="h-4 w-4 text-green-800 dark:text-green-300" />
					</span>
					<h3 class="flex items-center text-lg font-semibold text-gray-900 dark:text-white">
						{{ auth()->user()->can('technician-approve') ? 'Mendapatkan poin' : 'Poin didapatkan' }}
						<span
							class="me-2 ms-3 rounded-lg bg-green-100 px-2.5 py-0.5 text-sm font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
							+ {{ $point->point }}
						</span>
					</h3>
					<span class="{{ $point->is_redeemed ? 'text-green-500' : 'text-red-500' }} -mt-2 text-sm">
						{{ $point->is_redeemed ? 'Sudah di redeem' : 'Belum di redeem' }}
					</span>
					<time class="block text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
						Pukul
						{{ $point->updated_at->format('H:i:s, d M Y') }}
					</time>
					<p class="text-base font-normal text-gray-500 dark:text-gray-400">
						{{ auth()->user()->can('technician-approve') ? $point->pegawai->full_name ?? 'Teknisi' : 'Anda' }}
						({{ $point->kode_pegawai }})
						mendapatkan poin dari laporan kunjungan dengan kode <b class="text-green-500">{{ $point->from_vt }}</b> yang
						telah disetujui.
					</p>
				</div>
			</li>
		@endforeach

		@if ($pointData->count() == 0)
			<p class="text-center text-gray-500 dark:text-gray-400">Data tidak ditemukan</p>
		@endif

	</ol>
	{{ $pointData->onEachSide(1)->links() }}
</div>
