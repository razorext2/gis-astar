{{-- Goal: Template export kolektor Excel/PDF, Livewire: None, Alpine: None --}}
<table style="border-collapse: collapse; width: 100%;">
	<thead>
		<tr>
			<th style="font-weight: bold;" colspan="2">Laporan Kolektor</th>
			<th style="font-weight: bold;" colspan="8">{{ $fromDate . ' s/d ' . $toDate }}</th>
		</tr>
		<tr style="height: 50px;">
			<th style="width: 55px; border: 1px solid black; text-align: center; font-weight: bold;">#</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">No. SR</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Tipe Tagihan</th>
			<th style="width: 150px; border: 1px solid black; text-align: center; font-weight: bold;">Kolektor</th>
			<th style="width: 180px; border: 1px solid black; text-align: center; font-weight: bold;">Judul</th>
			<th style="width: 200px; border: 1px solid black; text-align: center; font-weight: bold;">Lokasi</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Status</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">Tipe Bayar</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">Jumlah Bayar</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Tgl Assign</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($data as $i => $item)
			@php
				$statusLabels = [0 => 'Belum Dilengkapi', 1 => 'Disetujui', 2 => 'Diajukan', 3 => 'Ditolak', 4 => 'Perlu Revisi'];
			@endphp
			<tr>
				<td style="border: 1px solid black; text-align: center;">{{ $i + 1 }}</td>
				<td style="border: 1px solid black;">{{ $item->no_sr ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ strtoupper($item->bill_type ?? '-') }}</td>
				<td style="border: 1px solid black;">{{ $item->pegawaiRelasi->full_name ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->title ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->location ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $statusLabels[$item->status] ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ ucfirst($item->payment_type ?? '-') }}</td>
				<td style="border: 1px solid black; text-align: right;">{{ number_format($item->payment_amount ?? 0, 0, ',', '.') }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->assign_date ?? '-' }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
