{{-- Goal: Template export absensi Excel/PDF, Livewire: None, Alpine: None --}}
<table style="border-collapse: collapse; width: 100%;">
	<thead>
		<tr>
			<th style="font-weight: bold;" colspan="2">Laporan Absensi</th>
			<th style="font-weight: bold;" colspan="8">{{ $fromDate . ' s/d ' . $toDate }}</th>
		</tr>
		<tr style="height: 50px;">
			<th style="width: 55px; border: 1px solid black; text-align: center; font-weight: bold;">#</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">Kode Pegawai</th>
			<th style="width: 180px; border: 1px solid black; text-align: center; font-weight: bold;">Nama Pegawai</th>
			@if (($attendanceType ?? 'masuk') === 'semua')
				<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Aktivitas</th>
			@endif
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Jenis</th>
			<th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">
				{{ ($attendanceType ?? 'masuk') === 'semua' ? 'Jam Absen' : (($attendanceType ?? 'masuk') === 'keluar' ? 'Jam Keluar' : 'Jam Masuk') }}
			</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Status</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Verifikasi</th>
			<th style="width: 150px; border: 1px solid black; text-align: center; font-weight: bold;">Diverifikasi Oleh</th>
			<th style="width: 200px; border: 1px solid black; text-align: center; font-weight: bold;">Keterangan</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Tanggal</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($data as $i => $item)
			@php
				$flow = $item->attendance_flow_type ?? 'masuk';
				$jamTime = $flow === 'keluar' ? ($item->jam_keluar ?? null) : ($item->jam_masuk ?? null);
			@endphp
			<tr>
				<td style="border: 1px solid black; text-align: center;">{{ $i + 1 }}</td>
				<td style="border: 1px solid black;">{{ $item->kode_pegawai ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->pegawaiRelasi->full_name ?? '-' }}</td>
				@if (($attendanceType ?? 'masuk') === 'semua')
					<td style="border: 1px solid black; text-align: center; font-weight: bold;">
						{{ $flow === 'keluar' ? 'Keluar' : 'Masuk' }}
					</td>
				@endif
				<td style="border: 1px solid black; text-align: center;">{{ $item->jenis ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $jamTime ? $jamTime->format('H:i:s') : '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->status == 1 ? 'Hadir' : 'Tidak Hadir' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->verified ? 'Ya' : 'Belum' }}</td>
				<td style="border: 1px solid black;">{{ $item->verifiedBy->name ?? '-' }}</td>
				<td style="border: 1px solid black;">{{ $item->keterangan ?? '-' }}</td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->created_at?->format('d/m/Y') ?? '-' }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
