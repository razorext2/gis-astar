{{-- Goal: Template export piutang Excel/PDF, Livewire: None, Alpine: None --}}
<table style="border-collapse: collapse; width: 100%;">
	<thead>
		<tr>
			<th style="font-weight: bold;" colspan="2">Laporan Piutang</th>
			<th style="font-weight: bold;" colspan="8">{{ $fromDate . ' s/d ' . $toDate }}</th>
		</tr>
		<tr style="height: 50px;">
			<th style="width: 55px; border: 1px solid black; text-align: center; font-weight: bold;">#</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">No. SR</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Tipe SR</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Tgl SR</th>
			<th style="width: 180px; border: 1px solid black; text-align: center; font-weight: bold;">Nama Customer</th>
			<th style="width: 200px; border: 1px solid black; text-align: center; font-weight: bold;">Alamat Customer</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">Total Tagihan</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">Sisa Tagihan</th>
			<th style="width: 150px; border: 1px solid black; text-align: center; font-weight: bold;">Assign Ke</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Status</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($data as $i => $item)
			<tr>
				<td style="border: 1px solid black; text-align: center;">{{ $i + 1 }}</td>
				<td style="border: 1px solid black;">{{ $item->no_sr ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->sr_type ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->sr_date ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->customer_name ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->customer_address ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: right;">{{ number_format($item->total_bill ?? 0, 0, ',', '.') }}</td>
				<td style="border: 1px solid black; text-align: right;">{{ number_format($item->remaining_bill ?? 0, 0, ',', '.') }}</td>
				<td style="border: 1px solid black;">{{ $item->pegawaiRelasi->full_name ?? $item->userRelasi->name ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">
					@php
						$statusText = match ((int)$item->bill_status) {
							0 => 'Belum ditagih',
							1 => 'Tagihan berjalan',
							2 => 'Tagihan selesai',
							3 => 'Tagihan tertunda',
							default => 'Belum Lunas',
						};
					@endphp
					{{ $statusText }}
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
