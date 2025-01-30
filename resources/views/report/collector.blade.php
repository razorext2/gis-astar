<table style="border-collapse: collapse; width: 100%;">
	<thead>
		<tr>
			<th style="font-weight: bold;" colspan="3">
				{{ $date }}</th>
			<th style="font-weight: bold;" colspan="10">
				{{ match ($type) {
				    'idcppn' => 'IDC PPN',
				    'idcnonppn' => 'IDC Non PPN',
				    'idyppn' => 'IDY PPN',
				    default => 'N/A',
				} }}
			</th>
		</tr>
		<tr style="height: 70px;">
			<th style="width: 25px; border: 1px solid black; text-align: center; font-weight: bold;">#</th>
			<th style="width: 60px; border: 1px solid black; text-align: center; font-weight: bold;">TT Bawa Bon</th>
			<th style="width: 110px; border: 1px solid black; text-align: center; font-weight: bold;">Nama Cust</th>
			<th style="width: 95px; border: 1px solid black; text-align: center; font-weight: bold;">No. Bukti</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Nilai</th>
			<th style="width: 35px; border: 1px solid black; text-align: center; font-weight: bold;">TT</th>
			<th style="width: 80px; border: 1px solid black; text-align: center; font-weight: bold;">Ket.</th>
			<th style="width: 60px; border: 1px solid black; text-align: center; font-weight: bold;">Cara Byr</th>
			<th style="width: 50px; border: 1px solid black; text-align: center; font-weight: bold;">Jns Giro</th>
			<th style="width: 70px; border: 1px solid black; text-align: center; font-weight: bold;">No. Giro</th>
			<th style="width: 60px; border: 1px solid black; text-align: center; font-weight: bold;">Tgl Cair</th>
			<th style="width: 70px; border: 1px solid black; text-align: center; font-weight: bold;">Pot(PPH23, Adm)</th>
			<th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Nilai</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($items as $i => $item)
			<tr style="font-weight: bold;">
				<td style="border: 1px solid black; text-align: center;">{{ $i + 1 }}</td>
				<td style="border: 1px solid black; text-align: center;"></td>
				<td style="border: 1px solid black; text-align: left;">
					{{ match ($type) {
					    'idcnonppn' => $item->collectTaskRelasi->customer_name ?? 'N/A',
					    'idcppn' => $item->collectTaskPpnRelasi->customer_name ?? 'N/A',
					    'idyppn' => $item->collectIdyPpnRelasi->customer_name ?? 'N/A',
					    default => 'N/A',
					} }}
				</td>
				<td style="border: 1px solid black; text-align: center;">
					{{ $item->no_sr ?? '' }}
				</td>
				<td style="border: 1px solid black; text-align: right; font-size: 9px;">
					{{ match ($type) {
					    'idcnonppn' => Number::currency($item->collectTaskRelasi->remaining_bill ?? 0, 'IDR', 'id') ?? 'N/A',
					    'idcppn' => Number::currency($item->collectTaskPpnRelasi->remaining_bill ?? 0, 'IDR', 'id') ?? 'N/A',
					    'idyppn' => Number::currency($item->collectIdyPpnRelasi->remaining_bill ?? 0, 'IDR', 'id') ?? 'N/A',
					    default => 'N/A',
					} }}
				</td>
				<td style="border: 1px solid black; text-align: center;"></td>
				<td style="border: 1px solid black; text-align: center;">{{ $item->keterangan }}</td>
				<td style="border: 1px solid black; text-align: center;">
					{{ match ($item->payment_type) {
					    0 => 'Cash' ?? 'N/A',
					    1 => 'Transfer' ?? 'N/A',
					    2 => 'Giro/cek' ?? 'N/A',
					    default => 'N/A',
					} }}
				</td>
				<td style="border: 1px solid black; text-align: center;"></td>
				<td style="border: 1px solid black; text-align: center;"></td>
				<td style="border: 1px solid black; text-align: center;"></td>
				<td style="border: 1px solid black; text-align: center;"></td>
				<td style="border: 1px solid black; text-align: right; font-size: 9px;">
					{{ Number::currency($item->payment_amount ?? 0, 'IDR', 'id') }}
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
