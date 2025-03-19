@extends('dashboard.pegawai.detail')
@section('menus')
	<div
		class="mb-8 grid gap-4 rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-dark-primary lg:grid-cols-2"
		id="payroll" role="tabpanel" aria-labelledby="payroll-tab">
		<div class="col-span-2 w-full">
			<div class="grid">
				<div class="relative w-full">
					<header class="flex flex-row">
						<h2 class="font-base text-sm text-gray-400">
							Salary Info
						</h2>
					</header>
					<h2 class="text-xl font-medium text-gray-900 dark:text-white">
						{{ $pegawai->full_name }}
					</h2>

					@if (auth()->user()->can('salary-edit'))
						<a class="absolute bottom-0 right-0 p-1 text-sm text-blue-500 hover:underline"
							href="{{ route('salary.edit', $pegawai->id) }}">
							Edit
						</a>
					@endif
				</div>

				<div class="w-full">

					<div class="mt-4">

						<div class="grid gap-2 md:grid-cols-2">

							<div
								class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-gray-100 p-3 dark:border-gray-700 dark:bg-gray-700">
								<p class="text-sm text-gray-600 dark:text-gray-300">Kode Pegawai</p>
								<p class="text-navy-700 text-base font-medium dark:text-white">
									{{ $pegawai->kode_pegawai ?? 'N/A' }}
								</p>
							</div>

							<div
								class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-gray-100 p-3 dark:border-gray-700 dark:bg-gray-700">
								<p class="text-sm text-gray-600 dark:text-gray-300">Nama Lengkap</p>
								<p class="text-navy-700 text-base font-medium dark:text-white">
									{{ $pegawai->full_name ?? 'N/A' }}
								</p>
							</div>

							<div
								class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-gray-100 p-3 dark:border-gray-700 dark:bg-gray-700">
								<p class="text-sm text-gray-600 dark:text-gray-300">Payroll Type</p>
								<p class="text-navy-700 text-base font-medium first-letter:uppercase dark:text-white">
									{{ $pegawai->salaryRelasi->payroll_type ?? 'N/A' }}
								</p>
							</div>

							<div
								class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-gray-100 p-3 dark:border-gray-700 dark:bg-gray-700">
								<p class="text-sm text-gray-600 dark:text-gray-300">Base Salary</p>
								<p class="text-navy-700 text-base font-medium dark:text-white">
									{{ $pegawai->salaryRelasi ? Number::currency($pegawai->salaryRelasi->salary_fee ?? 0, 'IDR', 'id') : 'N/A' }}
								</p>
							</div>

							<div
								class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-gray-100 p-3 dark:border-gray-700 dark:bg-gray-700 md:col-span-2">
								<p class="text-sm text-gray-600 dark:text-gray-300">Periode</p>
								<p class="text-navy-700 text-base font-medium dark:text-white">
									{{ $pegawai->salaryRelasi ? \Carbon\Carbon::parse($pegawai->salaryRelasi->period)->locale('id')->isoFormat('MMMM YYYY') : 'N/A' }}
								</p>
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div
		class="col-span-2 mb-8 w-full rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-dark-primary dark:text-white">
		@include('dashboard.pegawai.details.components.allowances-section')
	</div>

	<div
		class="col-span-2 mb-8 w-full rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-dark-primary dark:text-white">
		@include('dashboard.pegawai.details.components.deductions-section')
	</div>

	<div
		class="col-span-2 mb-8 w-full rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-dark-primary dark:text-white">
		@include('dashboard.pegawai.details.components.total-payroll')
	</div>
@endsection
