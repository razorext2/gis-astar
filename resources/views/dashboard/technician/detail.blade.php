@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div
			class="grid gap-6 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 sm:p-6">
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

			<div class="flex w-full flex-col gap-2.5">

				<div class="grid gap-2 md:grid-cols-2" id="content">

					<x-detail.label id="kode_pegawai" label="Kode Pegawai">
						{{ $data->kode_pegawai }}
					</x-detail.label>

					<x-detail.label id="nama_pegawai" label="Nama Pegawai">
						{{ $data->pegawai->full_name ?? 'Teknisi belum terdaftar disistem.' }}
					</x-detail.label>

					<x-detail.label id="customer_contact" label="Customer Contact">
						{{ $data->customer_contact }}
					</x-detail.label>

					<x-detail.label id="customer_address" label="Alamat Customer">
						{{ $data->customer_address }}
					</x-detail.label>

					<div class="col-span-2 h-full rounded-lg bg-gray-50 p-3 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Rincian pekerjaan</p>
						<x-input.textarea id="job_detail" name="job_detail" placeholder="Rincian pekerjaan" :labels="'Rincian pekerjaan'"
							rows="15" readonly>
							{{ $data->job_detail }}
						</x-input.textarea>
					</div>

					<x-detail.label class="lg:col-span-2" id="weight_type" label="Jenis Timbangan">
						{{ $data->weight_type }}
					</x-detail.label>

					<x-detail.label id="weight_size" label="Ukuran">
						{{ $data->size }}
					</x-detail.label>

					<x-detail.label id="weight_capacity" label="Kapasitas">
						{{ $data->capacity }}
					</x-detail.label>

					<x-detail.label id="indicator_type" label="Tipe Indikator">
						{{ $data->indicator_type }}
					</x-detail.label>

					<x-detail.label id="indicator_sn" label="SN Indikator">
						{{ $data->indicator_sn }}
					</x-detail.label>

					<x-detail.label class="lg:col-span-2" id="loadcell_type" label="Tipe Loadcell">
						{{ $data->loadcell_type }}
					</x-detail.label>

					<x-detail.label id="loadcell_qty" label="Jumlah Loadcell">
						{{ $data->loadcell_qty }}
					</x-detail.label>

					<x-detail.label id="loadcell_sn" label="SN Loadcell">
						{{ $data->loadcell_sn }}
					</x-detail.label>

					<x-detail.label class="lg:col-span-2" id="junction_type" label="Tipe Junctionbox">
						{{ $data->junction_type }}
					</x-detail.label>

					<div class="col-span-2 h-full rounded-lg bg-gray-50 p-3 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Update pekerjaan</p>
						<x-input.textarea id="job_update" name="job_update" placeholder="Update pekerjaan" :labels="'Update pekerjaan'" rows="15"
							readonly>
							{{ $data->job_update }}
						</x-input.textarea>
					</div>

					<x-detail.label id="update_teknisi" label="Waktu update">
						{{ $data->update_teknisi }}
					</x-detail.label>

					<x-detail.label id="teknisi_telp" label="Nomor telepon">
						{{ $data->pegawai->no_telp ?? '-' }}
					</x-detail.label>

					<div
						class="col-span-2 flex flex-row gap-4 rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:flex-col">

						<div class="grid w-full grid-cols-4 content-center items-center">
							<div class="text-navy-700 text-base font-medium dark:text-white">
								<p class="mb-0.5 text-sm text-gray-600 dark:text-gray-300">Status</p>
								@if ($data->status == 0)
									<span class="rounded-lg bg-yellow-500 px-2 py-0.5"> Butuh konfirmasi </span>
								@elseif ($data->status == 1)
									<span class="rounded-lg bg-green-500 px-2 py-0.5"> Diterima </span>
								@elseif ($data->status == 2)
									<span class="rounded-lg bg-yellow-500 px-2 py-0.5"> Butuh revisi </span>
								@else
									<span class="rounded-lg bg-red-500 px-2 py-0.5"> Ditolak </span>
								@endif
							</div>

							<div class="text-navy-700 text-base font-medium dark:text-white">
								<p class="mb-0.5 text-sm text-gray-600 dark:text-gray-300">Divalidasi oleh</p>
								{{ $data->user->name ?? '-' }}
							</div>

							<div class="text-navy-700 text-base font-medium dark:text-white">
								<p class="mb-0.5 text-sm text-gray-600 dark:text-gray-300">Divalidasi tanggal</p>
								{{ $data->validate_at ?? '-' }}
							</div>

							<div class="text-navy-700 text-base font-medium dark:text-white">
								<p class="mb-0.5 text-sm text-gray-600 dark:text-gray-300">Catatan</p>
								{{ $data->notes ?? '-' }}
							</div>

						</div>

						<div class="grid w-full grid-cols-4 content-center items-center">
							<div class="text-navy-700 text-base font-medium dark:text-white">
								<p class="mb-0.5 text-sm text-gray-600 dark:text-gray-300">Jumlah revisi</p>
								Direvisi {{ $data->total_revision }} kali
							</div>

							<div class="text-navy-700 text-base font-medium dark:text-white">
								<p class="mb-0.5 text-sm text-gray-600 dark:text-gray-300">Direvisi oleh</p>
								{{ $data->revised_by->name ?? '-' }}
							</div>

							<div class="text-navy-700 text-base font-medium dark:text-white">
								<p class="mb-0.5 text-sm text-gray-600 dark:text-gray-300">Direvisi tanggal</p>
								{{ $data->revised_at ?? '-' }}
							</div>

						</div>
					</div>

				</div>

				@can('technician-approve')
					@if ($data->status == 0 || $data->status == 2)
						<x-button.success class="w-fit self-end" id="store" data-id="{{ $data->no_vt }}" type="button">
							<x-slot name="icon">
								<x-icons.angle-right class="h-5 w-5 text-blue-500 dark:text-white" />
							</x-slot>
							Konfirmasi
						</x-button.success>
					@endif
				@endcan

			</div>
		</div>
	</div>
@endsection
@push('script')
	@vite('resources/js/pages/technician/detail.js')
@endpush
