@foreach ($data as $row)
	<table>
		<tr>
			<td style="font-weight: bold;">Periode</td>
			<td>:</td>
			<td colspan="2" style="text-align: right"> {{ Carbon\Carbon::parse($row->from_date)->isoFormat('MMM YYYY') }} -
				{{ Carbon\Carbon::parse($row->to_date)->isoFormat('MMM YYYY') }}</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Nama Teknisi</td>
			<td>:</td>
			<td colspan="2" style="text-align: right; width: 150px;">
				{{ $row->pegawai->full_name ?? 'Teknisi belum terdaftar' }}</td>
		</tr>
		<tr>
			<td colspan="4" style="text-align: center; font-weight: bold;">Point Didapat</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Rute Nomor</td>
			<td colspan="3">:</td>
		</tr>
		@foreach ($row->point as $point)
			<tr>
				<td></td>
				<td colspan="2" style="width: 110px;">{{ $point->from_vt }}</td>
				<td style="text-align: right;">+ {{ $point->point }} Poin</td>
			</tr>
		@endforeach
		<tr>
			<td style="font-weight: bold;">Total Point</td>
			<td>:</td>
			<td colspan="2" style="text-align: right"> {{ $row->total_points }} Poin </td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Redeemed By</td>
			<td>:</td>
			<td colspan="2" style="text-align: right; width: 150px;"> {{ $row->redeemedby->name ?? 'N/A' }} </td>
		</tr>
	</table>
@endforeach
