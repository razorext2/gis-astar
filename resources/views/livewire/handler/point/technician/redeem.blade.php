<div class="flex flex-col">

	<livewire:utils.stepper :step="$step" key="technician-point-redeem-stepper.{{ $step }}" />

	<div class="flex justify-between py-2">
		@if ($step != 1)
			<x-button.link
				class="w-fit ring-1 ring-red-700 hover:bg-red-300 dark:bg-red-800 dark:text-white dark:ring-gray-700 dark:hover:bg-red-900"
				wire:navigate href="{{ route('points.redeem', ['step' => 1]) }}">
				<x-slot name="icon">
					<x-icons.angle-left class="icon h-6 w-6" />
				</x-slot>
				Kembali
			</x-button.link>
		@endif

		@if ($step == 2)
			<x-button.success class="w-fit" wire:click="openModal">
				<x-slot name="icon">
					<x-icons.angle-right class="icon h-6 w-6" />
				</x-slot>
				Lanjut
			</x-button.success>
		@endif
	</div>

	<div class="w-full">

		@if ($step == 1)
			<h3 class="text-lg font-semibold text-gray-900 dark:text-white">
				Pilih periode poin yang akan diredeem.
			</h3>
			<p class="text-xs text-gray-500 dark:text-gray-400 md:text-sm">
				Silahkan pilih quarter, tanggal mulai dan tanggal akhir dari poin yang akan diredeem.
			</p>
		@elseif($step == 2)
			<h3 class="text-lg font-semibold text-gray-900 dark:text-white">
				Validasi poin tiap teknisi.
			</h3>
			<p class="text-xs text-gray-500 dark:text-gray-400 md:text-sm">
				Cek terlebih dahulu setiap data poin yang didapatkan oleh teknisi sebelum melanjutkan.
			</p>
		@endif
	</div>

	@if ($step == 1)
		<form wire:submit.prevent="process" class="mt-4 grid gap-4 lg:grid-cols-2">
			@csrf
			<div class="col-span-2 flex flex-col">
				<x-input.select wire:model="quarter" id="quarter" name="quarter" :options="[
				    '1' => 'Kuarter 1',
				    '2' => 'Kuarter 2',
				    '3' => 'Kuarter 3',
				    '4' => 'Kuarter 4',
				]"
					defaultOption="Pilih quarter" />
				@error('quarter')
					<span class="mt-2 text-sm text-red-600">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div class="col-span-2 flex flex-col lg:col-span-1">
				<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="start_period">Periode
					awal:</label>
				<input
					class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
					type="date" name="start_period" wire:model="start_period">
				@error('start_period')
					<span class="mt-2 text-sm text-red-600">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div class="col-span-2 flex flex-col lg:col-span-1">
				<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="end_period">Periode akhir:</label>
				<input
					class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
					type="date" name="end_period" wire:model="end_period">
				@error('end_period')
					<span class="mt-2 text-sm text-red-600">
						{{ $message }}
					</span>
				@enderror
			</div>

			<div class="col-span-2">
				<x-button.primary class="mx-auto" type="submit" id="proceed-accumulation">
					<x-icons.loading wire:loading />
					<span wire:loading.remove>Akumulasikan</span>
				</x-button.primary>
			</div>
		</form>
	@endif

	@if ($step == 2)
		@if ($results->isNotEmpty())
			<livewire:handler.point.technician.step-two :results="$result" />
			@if ($showModal)
				<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
					<!-- Modal box -->
					<div class="flex max-w-lg flex-col gap-2 rounded-lg bg-white p-6 dark:bg-gray-800">
						<h2 class="text-lg font-semibold text-gray-900 dark:text-white">Konfirmasi Pengajuan</h2>
						<p class="overflow-y-auto border-y border-gray-900 py-1 text-gray-800 dark:border-gray-600 dark:text-white">
							Apakah anda yakin ingin melakukan redeem poin untuk semua teknisi dengan poin valid dari tanggal
							<b>{{ $start_period }}</b> sampai tanggal <b>{{ $end_period }}</b>?
						</p>
						<div class="mt-4 flex justify-end space-x-2">
							<x-button.success wire:click="validateData">Konfirmasi</x-button.success>
							<x-button.danger wire:click="closeModal">Batal</x-button.danger>
						</div>
					</div>
				</div>
			@endif
		@else
			<div class="text-center">
				<p class="mt-4 text-gray-800 dark:text-white">Tidak ada data ditemukan.</p>
				<a href="{{ route('points.redeem', ['step' => 1]) }}" class="text-blue-500 dark:text-blue-400">Kembali</a>
			</div>
		@endif
	@endif

	@if ($step == 3)
		<h3 class="mt-2 text-xl font-semibold text-gray-800 dark:text-white lg:text-2xl"> Summary </h3>
		@if ($results->isNotEmpty())
			<div class="mt-2 flex flex-col rounded-lg bg-gray-100 p-2 text-gray-800 dark:bg-gray-700 dark:text-white lg:p-4">
				<div class="flex items-center justify-between">
					<span class="font-semibold">No. Transaksi</span>
					<span class="text-right">{{ $results->first()->transaction_id ?? 'Transaksi tidak ditemukan' }}</span>
				</div>
				<div class="flex items-center justify-between">
					<span class="font-semibold">Kuartal</span>
					<span class="text-right">{{ $results->first()->year }} - {{ $results->first()->quartal }}</span>
				</div>
				<div class="flex items-center justify-between">
					<span class="font-semibold">Periode</span>
					<span class="text-right">
						{{ \Carbon\Carbon::parse($results->first()->from_date)->locale('id')->isoFormat('D MMM Y') }}
						<i class="text-xs not-italic">s/d</i>
						{{ \Carbon\Carbon::parse($results->first()->to_date)->locale('id')->isoFormat('D MMM Y') }}
					</span>
				</div>
				<p class="font-semibold"> Daftar Pegawai </p>
				<div class="pl-4">
					@foreach ($results as $item)
						<div class="flex justify-between">
							<span> ({{ $item->kode_pegawai }}) {{ $item->pegawai->full_name ?? 'Pegawai belum terdaftar disistem' }}</span>
							<span class="text-right">{{ $item->total_points ?? 0 }} Poin</span>
						</div>
					@endforeach
				</div>
				<div class="flex items-center justify-between">
					<span class="font-semibold"> Total Poin Redeem </span>
					<span class="text-right">{{ $results->sum('total_points') }} Poin</span>
				</div>
				<div class="flex items-center justify-between">
					<span class="font-semibold"> Diredeem Oleh </span>
					<span class="text-right">{{ $results->first()->redeemedby->name ?? 'xxx' }}</span>
				</div>
				<div class="flex items-center justify-between">
					@php
						$statusMap = [
						    0 => ['label' => 'Belum divalidasi', 'color' => 'bg-gray-500'],
						    1 => ['label' => 'Butuh konfirmasi', 'color' => 'bg-yellow-500'],
						    2 => ['label' => 'Diteruskan ke HRD', 'color' => 'bg-blue-500'],
						    3 => ['label' => 'Dikonfirmasi', 'color' => 'bg-green-500'],
						    4 => ['label' => 'Ditolak', 'color' => 'bg-red-500'],
						];

						$statusData = $statusMap[$results->first()->status] ?? [
						    'label' => 'Status tidak diketahui',
						    'color' => 'bg-gray-400',
						];
					@endphp

					<span class="font-semibold">Status</span>
					<span class="{{ $statusData['color'] }} rounded-md px-2 py-0.5 text-right">{{ $statusData['label'] }}</span>
				</div>
			</div>
			@if ($results->first()->status == 1)
				<div class="mt-4 flex items-center justify-end">
					<x-button.primary class="w-fit" wire:click="processRedeem('{{ $results->first()->transaction_id }}')">
						<x-slot name="icon">
							<x-icons.angle-right class="icon h-6 w-6" />
						</x-slot>
						Proses Redeem
					</x-button.primary>
				</div>
			@endif
		@else
			<div class="text-center">
				<p class="mt-4 text-gray-800 dark:text-white">Tidak ada data ditemukan.</p>
				<a href="{{ route('points.redeem', ['step' => 1]) }}" class="text-blue-500 dark:text-blue-400">Kembali</a>
			</div>
		@endif
	@endif
</div>
