<div class="relative overflow-x-auto">
	<div class="relative mb-4 w-full">
		<header class="flex flex-row">
			<h2 class="font-base text-sm text-gray-400">
				Total
			</h2>
		</header>
		<h2 class="text-xl font-medium text-gray-900 dark:text-white">
			Payroll
		</h2>
	</div>

	<table id="salary-counter">
		<thead>
			<tr>
				<th class="!text-center">No</th>
				<th class="!text-center">Type</th>
				<th class="!text-center">Debit</th>
				<th class="!text-center">Credit</th>
				<th class="!text-center">Total</th>
			</tr>
		</thead>
		<tbody>
			@php
				$counter = 2;

				// Use the null coalescing operator to handle the null case
				$total = $pegawai->salaryRelasi->salary_fee ?? 0;
			@endphp

			<tr>
				<td class="text-center">1</td>
				<td>Salary</td>
				<td class="text-right text-green-500">+ {{ Number::currency($pegawai->salaryRelasi->salary_fee ?? 0, 'IDR', 'id') }}
				</td>
				<td class="!text-right">-</td>
				<td class="!text-right">{{ Number::currency($total, 'IDR', 'id') }}</td> <!-- Initial total as base salary -->
			</tr>

			<!-- Allowances Loop -->
			@foreach ($allowances as $data)
				@php
					$total += $data->allowance_fee; // Add each allowance to the total
				@endphp
				<tr>
					<td class="text-center">{{ $counter++ }}</td>
					<td>{{ $data->allowance_name }}</td>
					<td class="!text-right text-green-500">+ {{ Number::currency($data->allowance_fee, 'IDR', 'id') }}</td>
					<td class="!text-right">-</td>
					<td class="!text-right">{{ Number::currency($total, 'IDR', 'id') }}</td>
					<!-- Updated total after each addition -->
				</tr>
			@endforeach

			<!-- Deductions Loop -->
			@foreach ($deductions as $data)
				@php
					$total -= $data->deduction_fee; // Subtract each deduction from the total
				@endphp
				<tr>
					<td class="text-center">{{ $counter++ }}</td>
					<td>{{ $data->deduction_name }}</td>
					<td class="!text-right">-</td>
					<td class="!text-right text-red-500">- {{ Number::currency($data->deduction_fee, 'IDR', 'id') }}</td>
					<td class="!text-right">{{ Number::currency($total, 'IDR', 'id') }}</td>
					<!-- Updated total after each subtraction -->
				</tr>
			@endforeach
		</tbody>

		<tfoot>
			<tr>
				<td class="font-semibold" colspan="4">Total salary:</td>
				<td class="!text-right font-semibold">{{ Number::currency($total, 'IDR', 'id') }}</td>
			</tr>
		</tfoot>

	</table>
</div>
@push('script')
	<script>
		let table = new DataTable('#salary-counter', {
			responsive: true,
			paging: false,
			searching: false,
			layout: {
				topStart: {
					buttons: [{
						extend: 'print',
						autoPrint: false,
						text: 'Print salary receipt',
						customize: function(win) {
							// Get required data from the backend (ensure these values are defined globally or passed as needed)
							let pegawaiName = "{{ $pegawai->full_name }}";
							let salaryPeriod =
								"{{ isset($pegawai->salaryRelasi)? \Carbon\Carbon::parse($pegawai->salaryRelasi->period)->locale('id')->isoFormat('MMMM YYYY'): 'N/A' }}";
							let salaryFee =
								"{{ isset($pegawai->salaryRelasi) ? Number::currency($pegawai->salaryRelasi->salary_fee, 'IDR', 'id') : '0' }}";
							let previousMonth =
								"{{ isset($pegawai->salaryRelasi)? \Carbon\Carbon::parse($pegawai->salaryRelasi->period)->subMonth()->locale('id')->isoFormat('MMMM YYYY'): 'N/A' }}";

							let allowances = @json($allowances);
							let deductions = @json($deductions);
							let total = "{{ Number::currency($total, 'IDR', 'id')"; // Final total amount

							// Build the custom print content
							let allowancesContent = allowances.length ? allowances.map((data) =>
								`
								<tr>
									<td class="w-1/2"> ${data.allowance_name} ${new Date(data.allowance_period).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })}</td>
									<td class="text-left" style="width: 300px;"> : Rp. </td>
									<td class="text-right"> ${Number(data.allowance_fee).toLocaleString('id-ID')},00 </td>
								</tr>
							`).join('') : '<tr><td colspan="3" class="text-center">No Allowances</td></tr>';

							let deductionsContent = deductions.length ? deductions.map((data) =>
								`
								<tr>
									<td class="w-1/2"> ${data.deduction_name} ${new Date(data.deduction_period).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })}</td>
									<td class="text-left" style="width: 300px;"> : Rp. </td>
									<td class="text-right"> ${Number(data.deduction_fee).toLocaleString('id-ID')},00 </td>
								</tr>
							`).join('') : '<tr><td colspan="3" class="text-center">No Deductions</td></tr>';

							// Main print layout
							$(win.document.body).html(`
							<div class="p-3 m-2 border border-gray-950 rounded-xl">
								<div class="text-center font-semibold text-lg pb-6">
									TANDA TERIMA GAJI
								</div>
								<hr>
								<div class="text-left py-2">
									<p><strong>Nama:</strong> ${pegawaiName}</p>
									<p><strong>Periode:</strong> ${salaryPeriod}</p>
								</div>
								<hr>

								<div class="text-left py-2">
									<span class="font-semibold text-lg"> RINCIAN UPAH </span>
									<table class="w-full">
										<tr>
											<td class="w-1/2"> Upah ${salaryPeriod}</td>
											<td class="text-left" style="width: 300px;"> : Rp. </td>
											<td class="text-right"> ${salaryFee},00 </td>
										</tr>
										${allowancesContent}
									</table>
								</div>

								<div class="text-left py-2">
									<span class="font-semibold text-lg"> POTONGAN </span>
									<table class="w-full">
										${deductionsContent}
									</table>
								</div>
								
								<div class="text-left py-2 border border-gray-950 px-1">
									<table class="w-full">
										<tr>
											<td class="w-1/2"> Total terima: </td>
											<td class="text-left" style="width: 300px;"> : Rp. </td>
											<td class="text-right font-semibold"> ${total},00 </td>
										</tr>
										<tr>
											<td class="w-1/2"> Total pembulatan: </td>
											<td class="text-left" style="width: 300px;"> : Rp. </td>
											<td class="text-right font-semibold"> ${total},00 </td>
										</tr>
									</table>
								</div>

								<div style="text-align: right; margin-top: 30px;">
									<p>Diterima Oleh</p>
									<br><br>
									<p>${pegawaiName}</p>
								</div>
								<br>
								<p class="uppercase">NB: SEGALA BENTUK POT. BLN ${previousMonth} SDH DI POT PADA GAJI ${salaryPeriod}</p>
							</div>
						`);

							// Apply custom CSS
							$(win.document.body).css('font-family', 'Arial, sans-serif');
							$(win.document.body).find('h2, h3').css('text-align', 'center');
							$(win.document.body).find('p').css('margin', '5px 0');
						}
					}]
				}
			}
		});
	</script>
@endpush
