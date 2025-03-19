@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div
			class="grid gap-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 sm:p-6">

			<div class="w-full">
				<header class="flex flex-row">

					<form id="back-form" action="{{ route('technician.index') }}"></form>
					<x-button.danger class="my-auto me-4 max-h-10" form="back-form" type="submit">
						<x-slot name="icon">
							<x-icons.angle-left class="icon h-6 w-6 text-red-500 dark:text-white" />
						</x-slot>
						Kembali
					</x-button.danger>

					<h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
						{{ __('Update Laporan Teknisi') }}
					</h2>

				</header>
				<p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
					{{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
				</p>
			</div>

			<div class="w-full">

				<div class="grid gap-4 md:grid-cols-2" id="laporan-content">

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic id="kode_pegawai" name="kode_pegawai" readonly>
							Kode Pegawai
						</x-input.basic>
					</div>

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic id="employee_name" name="employee_name" readonly>
							Nama Pegawai
						</x-input.basic>
					</div>

					<div class="col-span-2 w-full">
						<x-input.w-button id="no_vt" name="no_vt" value="{{ Request::query('id') }}" placeholder="VT-XXXXXX">
							<x-slot name="buttonLabel">
								Fetch
							</x-slot>
							<x-slot name="textLabel">
								Nomor Kunjungan
							</x-slot>
						</x-input.w-button>

						<div class="mt-2 hidden text-sm text-red-500" id="alert-no_vt"></div>
					</div>

					<div class="col-span-2 hidden w-full" id="partner_parent">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for=""> Partner Kunjungan
						</label>

						<div id="partner_child"></div>
					</div>

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic id="customer_contact" name="customer_contact" placeholder="PT. XXX" readonly>
							Customer Contact
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-customer_contact"></div>
					</div>

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic id="customer_address" name="customer_address" placeholder="Jl. XXX, Kota XXX" readonly>
							Alamat Customer
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-customer_address"></div>
					</div>

					<div class="col-span-2 w-full">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="keterangan">Rincian
							Pekerjaan</label>
						<textarea
						 class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
						 id="job_detail" rows="25" placeholder="Rincian pekerjaan..." readonly></textarea>
					</div>

					<div class="col-span-2 w-full lg:col-span-1" id="weight_type_container">
						<x-input.select id="weight_type" name="weight_type" :options="[
						    'Single Deck' => 'Single Deck',
						    'Floor Scale' => 'Floor Scale',
						    'Hopper' => 'Hopper',
						    'Tangki' => 'Tangki',
						    'Conveyer' => 'Conveyer',
						    'Check Weigher' => 'Check Weigher',
						    'Timbangan Jembatan' => 'Timbangan Jembatan',
						    'Other' => 'Other',
						]" default-option="Pilih jenis timbangan">
							<x-slot name="textLabel">Jenis Timbangan</x-slot>
						</x-input.select>
						{{-- other weight type, ditampilkan ketika pilih "other" --}}
						<x-input.basic class="hidden" id="other_weight_type" name="other_weight_type"
							placeholder="Sebutkan tipe timbangannya..." />
						<div class="mt-2 hidden text-sm text-red-500" id="alert-weight_type"></div>
					</div>

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic id="size" name="size" placeholder="12 X 12" required>
							Ukuran
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-size"></div>
					</div>

					<div class="col-span-2 w-full">
						<x-input.basic id="capacity" name="capacity" placeholder="cth: 60000" required>
							Kapasitas
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-capacity"></div>
					</div>

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic id="indicator_type" name="indicator_type" placeholder="cth: PSC6801" required>
							Tipe Indikator
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-indicator_type"></div>
					</div>

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic id="indicator_sn" name="indicator_sn" placeholder="cth: 010xxxx" required>
							Serial Number (S/N)
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-indicator_sn"></div>
					</div>

					<div class="col-span-2 w-full lg:col-span-1">
						<div class="grid grid-cols-2 gap-4">
							<div class="col-span-2 w-full lg:col-span-1">
								<x-input.basic id="loadcell_type" name="loadcell_type" placeholder="cth: PDS" required>
									Tipe Loadcell
								</x-input.basic>
								{{-- select ditampilkan kalo pilih "Timbangan Jembatan" --}}
								<x-input.select class="hidden" id="other_loadcell_type" name="other_loadcell_type" :options="[
								    'HPC (Presica)' => 'HPC (Presica)',
								    'PDS (Presica)' => 'PDS (Presica)',
								    'SDB (Presica)' => 'SDB (Presica)',
								    'ZSF (Presica)' => 'ZSF (Presica)',
								    'DSC (Presica)' => 'DSC (Presica)',
								    'PRD (Presica)' => 'PRD (Presica)',
								    'T302 (Avery)' => 'T302 (Avery)',
								    'T302X (Avery)' => 'T302X (Avery)',
								    'HM9A (Zemic)' => 'HM9A (Zemic)',
								    'HM9B (Zemic)' => 'HM9B (Zemic)',
								    'QS (Keli)' => 'QS (Keli)',
								]"
									default-option="Pilih type loadcell">
								</x-input.select>
								<div class="mt-2 hidden text-sm text-red-500" id="alert-loadcell_type"></div>
							</div>

							<div class="col-span-2 w-full lg:col-span-1">
								<x-input.basic id="loadcell_qty" name="loadcell_qty" placeholder="cth: 2" required>
									Jumlah Loadcell
								</x-input.basic>
								<div class="mt-2 hidden text-sm text-red-500" id="alert-loadcell_qty"></div>
							</div>
						</div>
					</div>

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic id="loadcell_sn" name="loadcell_sn" placeholder="cth: 010xxxx" required>
							Serial Number (S/N)
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-loadcell_sn"></div>
					</div>

					<div class="col-span-2 w-full">
						<x-input.basic id="junction_type" name="junction_type" placeholder="cth: 6 Way" required>
							Type Junction Box
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-junction_type"></div>
					</div>

					<div class="col-span-2 w-full">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="job_update">Update
							Pekerjaan</label>
						<textarea
						 class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
						 id="job_update" rows="25" placeholder="Update pekerjaan..."></textarea>
					</div>

					<div class="relative col-span-2 w-full">
						<x-button.primary class="float-right" id="store" type="button">
							<x-slot name="icon">
								<x-icons.angle-right class="icon h-5 w-5" />
							</x-slot>
							Update laporan
						</x-button.primary>
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
@push('script')
	@vite(['resources/js/pages/technician/add.js'])
@endpush
