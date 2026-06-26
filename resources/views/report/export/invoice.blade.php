<table style="border-collapse: collapse; width: 100%;">
	<thead>
		<tr>
			<th style="font-weight: bold;" colspan="2">Laporan Invoice</th>
			<th style="font-weight: bold;" colspan="10">{{ $fromDate . ' s/d ' . $toDate }}</th>
		</tr>
		<tr style="height: 50px;">
			<th style="width: 55px; border: 1px solid black; text-align: center; font-weight: bold;">#</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">No. BTT</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Tgl BTT</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Tgl Invoice</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">No. Piutang</th>
			<th style="width: 150px; border: 1px solid black; text-align: center; font-weight: bold;">No. Faktur Pajak</th>
			<th style="width: 180px; border: 1px solid black; text-align: center; font-weight: bold;">Nama Customer</th>
			<th style="width: 80px; border: 1px solid black; text-align: center; font-weight: bold;">Tipe Tagihan</th>
			<th style="width: 80px; border: 1px solid black; text-align: center; font-weight: bold;">Tipe Invoice</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Status Kirim</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">Ditambahkan Oleh</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Dibuat Tgl</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($data as $i => $item)
			<tr>
				<td style="border: 1px solid black; text-align: center;">{{ $i + 1 }}</td>
				<td style="border: 1px solid black;">{{ $item->nomor_btt ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->tgl_btt ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->tgl_invoice ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->no_piutang ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->no_faktur_pajak ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->nama_customer ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ strtoupper($item->tipe_tagihan ?? '-') }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->tipe_invoice == 'dalkot' ? 'Dalam Kota' : 'Luar Kota' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->status_pengiriman ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->addedBy->name ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->created_at?->format('d/m/Y') ?? '-' }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
