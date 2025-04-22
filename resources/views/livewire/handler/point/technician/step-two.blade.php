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
							wire:model.live="no_vt.{{ $kodePegawai }}" class="w-full" id="no_vt" placeholder="Cari nomor kunjungan..." />
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
