<div class="relative mb-4 w-full">
	<header class="flex flex-row">
		<h2 class="font-base text-sm text-gray-400">
			Detail
		</h2>
	</header>
	<h2 class="text-xl font-medium text-gray-900 dark:text-white">
		Deductions
	</h2>

	<x-button.actions class="absolute bottom-0 right-0">
		<x-button.success id="btn-create-deduction">
			<x-slot name="icon">
				<x-icons.plus class="h-4 w-4" />
			</x-slot>
			Add Deductions
		</x-button.success>
	</x-button.actions>
</div>

<table id="table-deduction">
	<thead>
		<tr>
			<th>
				<span class="flex items-center">
					#
				</span>
			</th>
			<th>
				<span class="flex items-center">
					Deduction Name
				</span>
			</th>
			<th>
				<span class="flex items-center">
					Deduction Period
				</span>
			</th>
			<th>
				<span class="flex items-center">
					Type (% or Terbilang)
				</span>
			</th>
			<th>
				<span class="flex items-center">
					Deduction Fee
				</span>
			</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="4">Total Deduction: </th>
			<th class="text-red-500" id="total-deduction-fee"></th>
		</tr>
	</tfoot>
</table>

@include('dashboard.deduction.add-modal')
@include('dashboard.deduction.edit-modal')
@include('dashboard.deduction.delete')

@push('script')
	<script type="module">
		function showDeductionData() {
			// Initialize DataTable
			let table = $('#table-deduction').DataTable({
				processing: true,
				serverSide: true,
				responsive: true,
				searchable: true,
				ajax: {
					url: "{{ url()->current() }}",
					data: {
						table: 'deduction'
					}
				},
				columns: [{
						data: 'actions',
						name: 'actions',
					}, {
						data: 'deduction_name',
						name: 'deduction_name'
					},
					{
						data: 'deduction_period',
						name: 'deduction_period'
					},
					{
						data: 'deduction_type',
						name: 'deduction_type',
					},
					{
						data: 'deduction_fee',
						name: 'deduction_fee'
					},
				],
				dom: `<"text-left dark:text-white"l>S<"relative overflow-x-auto w-full mt-20 lg:mt-4"t><"grid text-center gap-6 lg:grid-cols-2 mt-4 dark:text-white"<"lg:mt-3 lg:text-left"i><"lg:text-right dark:text-gray-900"p>>`,
				footerCallback: function(row, data, start, end, display) {
					let api = this.api();

					// Calculate the total for numeric-only values in the allowance_fee column
					let total = api
						.column(4, {
							page: 'current'
						}) // Column index for allowance_fee
						.data()
						.reduce(function(a, b) {
							// Strip out non-numeric characters and convert commas to dots for decimals
							let numericValue = b.replace(/Rp\s?|\./g, '').replace(',', '.');
							let parsedValue = parseFloat(numericValue) || 0;
							return a + parsedValue;
						}, 0);

					// Format and display the total in the footer
					$(api.column(4).footer()).html(
						`Rp ${total.toLocaleString('id-ID', { minimumFractionDigits: 2 })}`);
				}
			});
		}

		$(document).ready(function() {
			showDeductionData();
		});
	</script>
@endpush
