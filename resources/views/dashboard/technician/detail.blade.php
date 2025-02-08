@extends('dashboard.layoutsDash.app')
@section('content')
	@php
		$data = $user->where('kode_pegawai', Auth::user()->kode_pegawai)->first();
	@endphp

	<div class="w-full space-y-6">
		<div
			class="grid gap-6 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 sm:p-6">
			<div class="w-full">
				<header class="flex flex-row">

					<form id="actionForm" action="{{ route('technician.index') }}"></form>
					<x-button.danger class="my-auto me-4 max-h-10" id="back-button" form="actionForm" type="submit">
						<x-slot name="icon">
							<x-icons.angle-left class="icon h-6 w-6 text-red-500 dark:text-white" />
						</x-slot>
						Kembali
					</x-button.danger>

					<h2 class="font-base mt-2 text-lg text-gray-900 dark:text-gray-300">
						Detail: <span class="font-bold text-white" id="no_vt_label"> Laporan </span>
					</h2>
				</header>
			</div>

			<div class="w-full">

				<div class="grid gap-2 md:grid-cols-2" id="content">

					<input id="no_vt" type="hidden" value="{{ $no_vt }}">

					<x-detail.label id="kode_pegawai" label="Kode Pegawai" />

					<x-detail.label id="nama_pegawai" label="Nama Pegawai" />

					<x-detail.label id="customer_contact" label="Customer Contact" />

					<x-detail.label id="customer_address" label="Alamat Customer" />

					<div class="h-full rounded-lg bg-gray-50 p-3 dark:bg-gray-700 lg:col-span-2">
						<p class="text-sm text-gray-600 dark:text-gray-300">Rincian pekerjaan</p>
						<x-skeleton />
						<x-input.textarea class="hidden" id="job_detail" name="job_detail" placeholder="Rincian pekerjaan"
							:labels="'Rincian pekerjaan'" rows="25" readonly />
					</div>

					<x-detail.label class="lg:col-span-2" id="weight_type" label="Jenis Timbangan" />

					<x-detail.label id="weight_size" label="Ukuran" />

					<x-detail.label id="weight_capacity" label="Kapasitas" />

					<x-detail.label id="indicator_type" label="Tipe Indikator" />

					<x-detail.label id="indicator_sn" label="SN Indikator" />

					<x-detail.label class="lg:col-span-2" id="loadcell_type" label="Tipe Loadcell" />

					<x-detail.label id="loadcell_qty" label="Jumlah Loadcell" />

					<x-detail.label id="loadcell_sn" label="SN Loadcell" />

					<x-detail.label class="lg:col-span-2" id="junction_type" label="Tipe Junctionbox" />

					<div class="h-full rounded-lg bg-gray-50 p-3 dark:bg-gray-700 lg:col-span-2">
						<p class="text-sm text-gray-600 dark:text-gray-300">Update pekerjaan</p>
						<x-skeleton />
						<x-input.textarea class="hidden" id="job_update" name="job_update" placeholder="Update pekerjaan" :labels="'Update pekerjaan'"
							rows="25" readonly />
					</div>

					<x-detail.label id="update_teknisi" label="Waktu update" />

					<x-detail.label id="teknisi_telp" label="Nomor telepon" />
				</div>

			</div>
		</div>
	</div>
@endsection
@push('script')
	@vite('resources/js/technician/detail.js')
@endpush
