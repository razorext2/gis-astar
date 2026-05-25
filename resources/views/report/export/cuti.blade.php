<table style="border-collapse: collapse; width: 100%;">
	<thead>
		<tr>
			<th style="font-weight: bold;" colspan="2">Laporan Cuti</th>
			<th style="font-weight: bold;" colspan="8">{{ $fromDate . ' s/d ' . $toDate }}</th>
		</tr>
		<tr style="height: 50px;">
			<th style="width: 55px; border: 1px solid black; text-align: center; font-weight: bold;">#</th>
			<th style="width: 180px; border: 1px solid black; text-align: center; font-weight: bold;">Nama Pegawai</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">Tipe Cuti</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Tgl Mulai</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Tgl Selesai</th>
			<th style="width: 80px; border: 1px solid black; text-align: center; font-weight: bold;">Total Hari</th>
			<th style="width: 200px; border: 1px solid black; text-align: center; font-weight: bold;">Alasan</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Status</th>
			<th style="width: 150px; border: 1px solid black; text-align: center; font-weight: bold;">Personel Backup</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Diajukan Tgl</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($data as $i => $item)
			<tr>
				<td style="border: 1px solid black; text-align: center;">{{ $i + 1 }}</td>
				<td style="border: 1px solid black;">{{ $item->user->name ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->leaveType->name ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->start_date?->format('d/m/Y') ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->end_date?->format('d/m/Y') ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->total_days ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->reason ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</td>
				<td style="border: 1px solid black;">{{ $item->backupPerson->name ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->created_at?->format('d/m/Y') ?? '-' }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
