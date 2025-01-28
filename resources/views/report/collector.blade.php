<table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
	<thead>
		<tr>
			<th style="border: 1px solid black; font-weight: bold;">
				{{ $date }}
			</th>
			<th style="border: 1px solid black; font-weight: bold;">
				{{ $date }}
			</th>
			<th style="border: 1px solid black; font-weight: bold;" colspan="11">

				{{ match ($type) {
				    'idcppn' => 'IDC PPN ',
				    'idcnonppn' => 'IDC Non PPN',
				} }}

			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th style="border: 1px solid black; font-weight: bold; text-align:center">#</th>
			<th style="border: 1px solid black; font-weight: bold; text-align:center">TT Bawa Bon</th>
			<th style="border: 1px solid black; font-weight: bold; text-align:center">Nama Cust</th>
			<th style="border: 1px solid black; font-weight: bold; text-align:center">No. Bukti</th>
			<th style="border: 1px solid black; font-weight: bold; text-align:center">Nilai</th>
			<th style="border: 1px solid black; font-weight: bold; text-align:center">TT</th>
			<th style="border: 1px solid black; font-weight: bold; text-align:center">Keterangan</th>
			<th style="border: 1px solid black; font-weight: bold; text-align:center">Cara Byr</th>
			<th style="border: 1px solid black; font-weight: bold; text-align:center">Jenis Giro</th>
			<th style="border: 1px solid black; font-weight: bold; text-align:center">No. Giro</th>
			<th style="border: 1px solid black; font-weight: bold; text-align:center">Tgl Cair</th>
			<th style="border: 1px solid black; font-weight: bold; text-align:center">Pot(PPH23, Adm)</th>
			<th style="border: 1px solid black; font-weight: bold; text-align:center">Nilai</th>
		</tr>
		@php
			$i = 1;
		@endphp
		@foreach ($items as $item)
			<tr>
				<td style="border:1px solid black; text-align:center">{{ $i++ }}</td>
				<td style="border:1px solid black;">{{--  --}}</td>
				<td style="border:1px solid black; word-wrap:normal">
					{{ match ($type) {
					    'idcppn' => $item->collectTaskPpnRelasi->customer_name,
					    'idcnonppn' => $item->collectTaskRelasi->customer_name,
					} }}
				</td>
				<td style="border:1px solid black; text-align:center">{{ $item->no_sr ?? '' }}</td>
				<td style="border:1px solid black;">{{ $item->payment_amount ?? '' }}</td>
				<td style="border:1px solid black;">{{--  --}}</td>
				<td style="border:1px solid black;">{{ $item->keterangan }}</td>
				<td style="border:1px solid black;">
					{{ match ($item->payment_type) {
					    0 => 'Cash',
					    1 => 'Transfer',
					    2 => 'Giro/cek',
					} }}
				</td>
				<td style="border:1px solid black;">{{--  --}}</td>
				<td style="border:1px solid black;">{{--  --}}</td>
				<td style="border:1px solid black;">{{--  --}}</td>
				<td style="border:1px solid black;">{{--  --}}</td>
				<td style="border:1px solid black;">{{--  --}}</td>
			</tr>
		@endforeach
	</tbody>
</table>
