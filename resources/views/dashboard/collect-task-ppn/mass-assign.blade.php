@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 sm:p-6">
			<div class="w-full">
				<header class="flex flex-row">

					<form id="index-collect-task-ppn" action="{{ route('collect-task-ppn.index') }}"></form>
					<x-button.danger class="my-auto me-4 max-h-10" form="index-collect-task-ppn" type="submit">
						<x-slot name="icon">
							<x-icons.angle-left class="icon h-6 w-6 text-red-500 dark:text-white" />
						</x-slot>
						Kembali
					</x-button.danger>

					<h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
						{{ __('Assign Surat Jalan (FP)') }}
					</h2>

				</header>
				<p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
					{{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
				</p>

				<form id="mass-assign" method="POST">
					@csrf
					<div class="mb-6 mt-4 grid grid-cols-2 gap-6">

						<div class="w-full">

							<x-input.basic id="full_name" name="full_name" placeholder="Cari nama kolektor.." required>
								Nama Kolektor
							</x-input.basic>
							<div class="autocomplete-pegawai-results" id="autocomplete-pegawai-results"></div>
							<div class="mt-2 hidden text-sm text-red-500" id="alert-full_name"></div>
						</div>

						<div class="w-full">

							<x-input.basic class="cursor-not-allowed" id="kode_pegawai" name="kode_pegawai" placeholder="Kode pegawai"
								required readonly>
								Kode Jari
							</x-input.basic>
							<div class="mt-2 hidden text-sm text-red-500" id="alert-kode_pegawai"></div>
						</div>

						<div class="col-span-2 w-full">

							<x-input.basic id="no_sr" name="no_sr" placeholder="8 digit terakhir faktur pajak...">
								No. Faktur Pajak
							</x-input.basic>

							<div class="autocomplete-collect-task-ppn-container" id="autocomplete-collect-task-ppn-container"></div>

						</div>

						<div class="col-span-2 w-full">

							<p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> List FP yang dipilih </p>
							<div class="grid w-full gap-2" id="selected-container">
								<x-input.basic id="empty" name="empty" value="Belum ada FP yang dipilih..." :labels="false"
									readonly></x-input.basic>
								{{-- disini harusnya --}}
							</div>

							<div class="mt-2 hidden text-sm text-red-500" id="alert-sr_data"></div>

						</div>

					</div>

					<div class="relative inline-flex w-full gap-4">

						<x-button.primary id="store" type="button">
							<x-slot name="icon">
								<x-icons.angle-right class="h-5 w-5 text-blue-500 dark:text-white" />
							</x-slot>
							Submit
						</x-button.primary>

					</div>

				</form>
			</div>
		</div>
	</div>
@endsection
@push('script')
	<script>
		const pegawaiSearch = "{{ route('pegawai.autocomplete') }}";
		const srSearch = "{{ route('collect-task-ppn.autocomplete') }}";
		const assign_by = "{{ Auth::user()->kode_pegawai ?? '0' }}"
	</script>
	@vite(['resources/js/collect-task-ppn/mass-assign.js'])
@endpush
