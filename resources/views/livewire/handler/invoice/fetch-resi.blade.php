<div class="my-2 flex flex-col gap-4">
	<x-button.primary class="w-fit text-sm" wire:click="fetchResi">Cek Resi</x-button.primary>

	@if ($data)
		<p class="text-xs italic text-red-500">
			*Untuk membatasi hit ke API, dimohon untuk cek riwayat resi per 1 jam sekali.
		</p>

		<div
			class="flex flex-col gap-2 rounded-xl bg-white p-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-secondary dark:shadow-none dark:ring-gray-700 lg:p-4"
			wire:transition.origin.top>

			<div class="flex flex-col justify-between text-xs lg:flex-row lg:text-base">
				<p>{{ $data['data']['summary']['awb'] }} ({{ $data['data']['summary']['service'] }} /
					{{ $data['data']['summary']['weight'] }}Kg / Rp.
					{{ number_format($data['data']['summary']['amount'], 2, ',', '.') }})
				</p>
				<p>{{ $data['data']['summary']['date'] }} (<span
						class="font-semibold">{{ $data['data']['summary']['status'] }}</span>)</p>
			</div>

			<table class="w-full border-[1px] border-gray-400">
				<tr>
					<td class="w-1/2 border-[1px] border-gray-400">
						<div class="flex flex-col p-2">
							<p>Pengirim:</p>
							<p class="text-lg font-semibold">{{ $data['data']['detail']['shipper'] }}</p>
							<p class="text-sm font-medium">{{ $data['data']['detail']['origin'] }}</p>
						</div>
					</td>
					<td class="w-1/2 border-[1px] border-gray-400">
						<div class="flex flex-col p-2">
							<p>Penerima:</p>
							<p class="text-lg font-semibold">{{ $data['data']['detail']['receiver'] }}</p>
							<p class="text-sm font-medium">{{ $data['data']['detail']['destination'] }}</p>
						</div>
					</td>
				</tr>
			</table>

			<div class="flex flex-col">
				@foreach ($data['data']['history'] as $history)
					<div class="flex flex-row items-center justify-between border-b-[1px] border-b-gray-700 py-4">
						<div class="flex w-20 items-center justify-center">
							<x-icons.check class="h-6 w-6 text-green-500" />
						</div>

						<div class="grow">
							<p>Lokasi: {{ $history['location'] ?? '-' }}</p>
							<p>{{ $history['desc'] ?? '-' }}</p>
						</div>

						<div class="">
							<p>{{ \Carbon\carbon::parse($history['date'])->format('d M Y') }}</p>
							<p>{{ \Carbon\carbon::parse($history['date'])->format('H:i:s') }}</p>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	@endif
</div>
