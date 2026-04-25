@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full space-y-6">
        <div
            class="grid gap-6 rounded-xl bg-white p-4 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 sm:p-6">
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

                    @can('technician-approve')
                        <div class="flex w-full items-center justify-end">
                            <form id="fetchForm" action="{{ route('technician.fetch.update', $data->no_vt) }}"></form>
                            <x-button.primary class="my-auto me-4 max-h-10" id="fetch-button" form="fetchForm" type="submit">
                                <x-slot name="icon">
                                    <x-icons.clipboard class="icon h-6 w-6 text-blue-500 dark:text-white" />
                                </x-slot>
                                Fetch perbaikan data
                            </x-button.primary>
                        </div>
                    @endcan
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
                        <x-input.textarea id="job_detail" name="job_detail" placeholder="Rincian pekerjaan"
                            :labels="'Rincian pekerjaan'" rows="15" readonly>
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

                    <div
                        class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700">
                        <p class="mb-2 text-sm text-gray-600 dark:text-gray-300">Dokumentasi</p>

                        <div class="flex" id="captured-images">
                            <!-- Thumbnail gambar yang diambil akan muncul di sini -->
                            @if ($data->photo_collects)
                                <div class="flex flex-row gap-2">
                                    @foreach ($data->photo_collects as $photo)
                                        @php
                                            $ext = pathinfo($photo->photourl, PATHINFO_EXTENSION);
                                        @endphp

                                        @if ($ext == 'pdf')
                                            <div class="flex-none items-center gap-x-2">
                                                <x-button.primary
                                                    onclick="window.open(`/storage/technician/{{ $photo->photourl }}`, '_blank')"
                                                    id="show_document" type="button"> Lihat dokumen saat ini
                                                </x-button.primary>
                                            </div>
                                        @endif

                                        @if (in_array($ext, ['png', 'jpg', 'jpeg']))
                                            <div class="relative me-2 flex-none items-center gap-4 rounded-xl">
                                                <img class="h-36 w-36 rounded-xl object-cover ring-1 ring-zinc-200 transition duration-300 ease-in-out hover:scale-105"
                                                    id="documentations"
                                                    onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                                    data-url="{{ asset($photo->photourl) }}"
                                                    src="{{ asset($photo->photourl) }}" alt=""
                                                    onclick="javascript:void(0)" loading="lazy">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-600 dark:text-white"> Tidak ada dokumentasi.</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-span-2 h-full rounded-lg bg-gray-50 p-3 dark:bg-gray-700">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Update pekerjaan</p>
                        <x-input.textarea id="job_update" name="job_update" placeholder="Update pekerjaan" :labels="'Update pekerjaan'"
                            rows="15" readonly>
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
                        class="col-span-2 flex flex-row gap-4 rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:flex-col">

                        <div class="grid w-full content-center items-center lg:grid-cols-4">
                            <div class="text-navy-700 text-base font-medium dark:text-white">
                                <p class="mb-0.5 text-sm text-gray-600 dark:text-gray-300">Status</p>
                                @if ($data->status == 0)
                                    <span class="rounded-lg bg-yellow-500 px-2 py-0.5"> Butuh konfirmasi </span>
                                @elseif ($data->status == 1)
                                    <span class="rounded-lg bg-green-500 px-2 py-0.5"> Diterima </span>
                                @elseif ($data->status == 2)
                                    <span class="rounded-lg bg-yellow-500 px-2 py-0.5"> Butuh revisi </span>
                                @elseif ($data->status == 3)
                                    <span class="rounded-lg bg-red-500 px-2 py-0.5"> Ditolak </span>
                                @elseif ($data->status == 4)
                                    <span class="rounded-lg bg-gray-500 px-2 py-0.5"> Draft </span>
                                @else
                                    <span class="rounded-lg bg-red-500 px-2 py-0.5"> Status tidak diketahui </span>
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

                        <div class="grid w-full content-center items-center lg:grid-cols-4">
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
                    @if ($data->status == 0)
                        <x-button.success class="w-fit self-end" id="store" data-id="{{ $data->no_vt }}"
                            type="button">
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
