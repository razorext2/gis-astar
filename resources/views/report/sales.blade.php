<table style="border-collapse: collapse; width: 100%;">
	<thead>
		<tr>
			<th style="font-weight: bold;" colspan="3">{{ $role }}</th>
			<th style="font-weight: bold;" colspan="10">{{ $fromDate . ' - ' . $toDate }}</th>
		</tr>
		<tr style="height: 70px;">
			<th style="width: 25px; border: 1px solid black; text-align: center; font-weight: bold;">#</th>
			<th style="width: 120px; border: 1px solid black; text-align: right; font-weight: bold;">Nama Sales</th>
			<th style="width: 120px; border: 1px solid black; text-align: right; font-weight: bold;">Judul Laporan</th>
			<th style="width: 120px; border: 1px solid black; text-align: right; font-weight: bold;">Nama Customer</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">No. Telp Customer</th>
			<th style="width: 120px; border: 1px solid black; text-align: right; font-weight: bold;">Lokasi</th>
			<th style="width: 120px; border: 1px solid black; text-align: right; font-weight: bold;">Ket.</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">Koordinat</th>
			<th style="width: 50px; border: 1px solid black; text-align: center; font-weight: bold;">Status</th>
			<th style="width: 120px; border: 1px solid black; text-align: right; font-weight: bold;">Divalidasi Oleh</th>
			<th style="width: 80px; border: 1px solid black; text-align: right; font-weight: bold;">Catatan</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Dibuat Tgl</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Diupdate Tgl</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($data as $i => $item)
			<tr style="font-weight: bold;">
				<td style="border: 1px solid black; text-align: center;"></td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->pegawaiRelasi->full_name ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: left;">{{ $item->title ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->customer_name ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: right; font-size: 9px;">{{ $item->customer_telp ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->lokasi ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->keterangan ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->longitude ?? '-' }},
					{{ $item->latitude ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->status ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->validateBy->name ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->notes ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->created_at ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->updated_at ?? '-' }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
