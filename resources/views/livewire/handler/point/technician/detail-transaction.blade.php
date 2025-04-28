<div>
	<div class="mt-2 flex flex-col gap-1 rounded-lg bg-gray-100 p-2 text-gray-800 dark:bg-gray-700 dark:text-white lg:p-4">
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
					<span>{{ $item->pegawai->full_name ?? 'Pegawai belum terdaftar disistem' }}</span>
					<span class="text-right">{{ $item->total_points ?? 0 }}</span>
				</div>
			@endforeach
		</div>
		<div class="flex items-center justify-between">
			<span class="font-semibold"> Total Poin Redeem </span>
			<span class="text-right">{{ $results->sum('total_points') }}</span>
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

	@can('point-approve')
		@if ($results->first()->status == 2)
			<div class="mt-4 flex items-center justify-end">
				<x-button.primary class="w-fit" wire:click="openModal">
					<x-slot name="icon">
						<x-icons.angle-right class="icon h-6 w-6" />
					</x-slot>
					Konfirmasi
				</x-button.primary>
			</div>
		@endif

		@if ($results->first()->status == 3)
			<livewire:handler.point.technician.export-point-transactions :transactionID="$results->first()->transaction_id" />
		@endif

		@if ($showModal)
			<!-- Modal overlay -->
			<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
				<!-- Modal box -->
				<div class="flex max-w-lg flex-col gap-2 rounded-lg bg-white p-6 dark:bg-gray-800">
					<h2 class="text-lg font-semibold text-gray-900 dark:text-white">Konfirmasi Pengajuan</h2>
					<p class="text-gray-800 dark:text-gray-300">Apakah Anda yakin ingin mengonfirmasi transaksi <span
							class="font-semibold">{{ $transactionID }}</span>?</p>
					<div class="mt-4 flex justify-end space-x-2">
						<x-button.success wire:click="confirm">Konfirmasi</x-button.success>
						<x-button.danger wire:click="reject">Tolak</x-button.danger>
						<x-button.primary wire:click="closeModal">Batal</x-button.primary>
					</div>
				</div>
			</div>
		@endif
	@endcan
</div>
