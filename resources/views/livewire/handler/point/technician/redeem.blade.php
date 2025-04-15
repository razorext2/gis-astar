<div class="flex flex-col">

	<livewire:utils.stepper :step="$step" key="technician-point-redeem-stepper.{{ $step }}" />

	<div class="mt-4 flex justify-between">
		@if ($step != 3)
			<x-button.link
				class="w-fit ring-1 ring-red-700 hover:bg-red-300 dark:bg-red-800 dark:text-white dark:ring-gray-700 dark:hover:bg-red-900"
				wire:navigate href="{{ url()->previous() }}">
				<x-slot name="icon">
					<x-icons.angle-left class="icon h-6 w-6" />
				</x-slot>
				Kembali
			</x-button.link>
		@endif

		@if ($step == 2)
			<x-button.success class="w-fit" wire:click="validateData">
				<x-slot name="icon">
					<x-icons.angle-right class="icon h-6 w-6" />
				</x-slot>
				Lanjut
			</x-button.success>
		@endif
	</div>

	<div class="mt-4 w-full">
		<h3 class="text-lg font-semibold text-gray-900 dark:text-white">
			@if ($step == 1)
				Pilih periode poin yang akan diredeem.
			@elseif($step == 2)
				Validasi poin tiap teknisi.
			@endif
		</h3>
		<p class="text-xs text-gray-500 dark:text-gray-400 md:text-sm">
			Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veritatis aperiam dolores minus non sapiente?
		</p>
	</div>

	@if ($step == 1)
		<form wire:submit.prevent="process" class="mt-4 grid gap-4 lg:grid-cols-2">
			@csrf
			<div class="col-span-2 flex flex-col lg:col-span-1">
				<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="start_period">Periode
					awal:</label>
				<input
					class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
					type="date" name="start_period" wire:model="start_period" required>
			</div>

			<div class="col-span-2 flex flex-col lg:col-span-1">
				<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="end_period">Periode akhir:</label>
				<input
					class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
					type="date" name="end_period" wire:model="end_period" required>
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
			<div class="mt-4 flex flex-col gap-2 text-gray-800 dark:text-white lg:gap-4">
				@foreach ($results as $kodePegawai => $data)
					@php
						$total = 0;
					@endphp

					<p class="font-semibold">
						{{ $kodePegawai }} -{{ $data->first()->pegawai?->full_name ?? 'Teknisi belum terdaftar disistem.' }}
					</p>

					<div class="rounded-xl p-4 dark:bg-gray-700">
						<div class="relative max-h-44 overflow-auto">
							@if ($data->count() > 5)
								<div class="sticky top-0 w-full">
									<x-input.basic name="no_vt_{{ $kodePegawai }}" wire:input="searchKunjungan('{{ $kodePegawai }}')"
										wire:model.live="no_vt.{{ $kodePegawai }}" class="w-full" id="no_vt"
										placeholder="Cari nomor kunjungan..." />
								</div>
							@endif

							@php
								$listData = $filteredKunjungan[$kodePegawai] ?? $data;
							@endphp

							@foreach ($listData as $item)
								@php
									$total += $item->point;
								@endphp

								<div class="mt-2 flex w-full justify-between gap-2 text-center text-sm lg:text-base">
									<p>{{ $item->from_vt }}</p>
									<p class="font-semibold text-green-500">+{{ $item->point }} Poin</p>
									<p>{{ $item->updated_at }}</p>
								</div>
							@endforeach
						</div>

						<hr class="mt-2">
						<table class="mt-2 w-full text-right">
							<tr>
								<td>Total Poin Valid dari DB</td>
								<td class="text-right font-semibold">
									<span class="text-green-500">{{ $total }} Poin </span>
								</td>
							</tr>
							<tr>
								<td>Bonus</td>
								<td class="text-right font-semibold">
									<span class="text-green-500">
										+{{ ((($total >= 75 ? ($bonus = 25) : $total >= 100) ? ($bonus = 50) : $total >= 125) ? ($bonus = 75) : $total >= 150) ? ($bonus = 100) : ($bonus = 0) }}
										Poin </span>
								</td>
							</tr>
							<tr>
								<td>Akumulasi</td>
								<td class="text-right font-semibold">
									<span class="text-green-500">{{ $total + $bonus }} Poin </span>
								</td>
							</tr>
						</table>
					</div>
				@endforeach
			</div>
		@else
			<div class="text-center">
				<p class="mt-4 text-gray-800 dark:text-white">Tidak ada data ditemukan.</p>
				<a href="{{ route('technicianpoints.redeem', ['step' => 1]) }}"
					class="text-blue-500 dark:text-blue-400">Kembali</a>
			</div>
		@endif
	@endif
</div>
