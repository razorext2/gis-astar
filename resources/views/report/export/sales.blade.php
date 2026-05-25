{{-- Goal: Template export sales Excel/PDF, Livewire: None, Alpine: None --}}
<table style="border-collapse: collapse; width: 100%;">
	<thead>
		<tr>
			<th style="font-weight: bold;" colspan="2">Laporan Sales</th>
			<th style="font-weight: bold;" colspan="8">{{ $fromDate . ' s/d ' . $toDate }}</th>
		</tr>
		<tr style="height: 50px;">
			<th style="width: 55px; border: 1px solid black; text-align: center; font-weight: bold;">#</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">Kode Pegawai</th>
			<th style="width: 150px; border: 1px solid black; text-align: center; font-weight: bold;">Sales</th>
			<th style="width: 180px; border: 1px solid black; text-align: center; font-weight: bold;">Judul</th>
			<th style="width: 150px; border: 1px solid black; text-align: center; font-weight: bold;">Nama Customer</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">Telp Customer</th>
			<th style="width: 200px; border: 1px solid black; text-align: center; font-weight: bold;">Lokasi</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Status</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Order?</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Tgl Dibuat</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($data as $i => $item)
			@php
				$statusLabels = [0 => 'Menunggu Validasi', 1 => 'Disetujui', 2 => 'Ditolak'];
			@endphp
			<tr>
				<td style="border: 1px solid black; text-align: center;">{{ $i + 1 }}</td>
				<td style="border: 1px solid black;">{{ $item->kode_pegawai ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->pegawaiRelasi->full_name ?? $item->userRelasi->name ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->title ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->customer_name ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->customer_telp ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->lokasi ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $statusLabels[$item->status] ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->customer_make_order ? 'Ya' : 'Tidak' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->created_at?->format('d/m/Y') ?? '-' }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
