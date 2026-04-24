@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full space-y-6">
        <div
            class="grid gap-4 rounded-xl bg-white p-4 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 sm:p-6">

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
                        Update Laporan Teknisi {{ Request::query('id') ?? '' }}
                    </h2>

                </header>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    {{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
                </p>
                @if (Request::query('id'))
                    <p class="text-sm text-red-600 dark:text-red-300">
                        {{ __('*Perubahan/revisi laporan hanya diperbolehkan maksimal (n)x.') }}
                    </p>
                @endif
            </div>

            <div class="w-full">

                <div class="grid gap-4 md:grid-cols-2" id="laporan-content">

                    <div class="{{ Request::query('id') ? 'hidden' : 'col-span-2 w-full' }}">
                        <x-input.w-button id="no_vt" name="no_vt" value="{{ Request::query('id') }}"
                            placeholder="VT-XXXXXX">
                            <x-slot name="buttonLabel">
                                Fetch
                            </x-slot>
                            <x-slot name="textLabel">
                                Nomor Kunjungan
                            </x-slot>
                        </x-input.w-button>

                        <div class="mt-2 hidden text-sm text-red-500" id="alert-no_vt"></div>
                    </div>

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

                    <div class="col-span-2 w-full lg:col-span-1">
                        <x-input.basic id="id_permintaan" name="id_permintaan" readonly>
                            ID Permintaan Kunjungan
                        </x-input.basic>
                    </div>

                    <div class="col-span-2 w-full lg:col-span-1">
                        <x-input.basic id="visit_date" name="visit_date" readonly>
                            Tanggal Kunjungan
                        </x-input.basic>
                    </div>

                    <div class="col-span-2 hidden w-full" id="partner_parent">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for=""> Partner
                            Kunjungan
                        </label>

                        <div id="partner_child"></div>
                    </div>

                    <div class="col-span-2 w-full">
                        <x-input.basic id="customer_contact" name="customer_contact" placeholder="PT. XXX" readonly>
                            Nama Customer
                        </x-input.basic>
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-customer_contact"></div>
                    </div>

                    <div class="col-span-2 hidden w-full lg:col-span-1">
                        <x-input.basic id="customer_address" name="customer_address" placeholder="Jl. XXX, Kota XXX"
                            readonly>
                            Alamat Customer
                        </x-input.basic>
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-customer_address"></div>
                    </div>

                    <div class="col-span-2 w-full">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="keterangan">Rincian
                            Pekerjaan</label>
                        <textarea
                            class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
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
                            'Kombinasi' => 'Kombinasi',
                            'Other' => 'Other',
                        ]"
                            default-option="Pilih jenis timbangan">
                            <x-slot name="textLabel">Jenis Timbangan</x-slot>
                        </x-input.select>
                        {{-- other weight type, ditampilkan ketika pilih "other" --}}
                        <x-input.basic class="hidden" id="other_weight_type" name="other_weight_type"
                            placeholder="Sebutkan tipe timbangannya..." />
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-weight_type"></div>
                    </div>

                    <div class="col-span-2 w-full lg:col-span-1">
                        <div class="flex items-center justify-between gap-2">
                            <div>
                                <x-input.basic id="width" name="width" placeholder="xx Meter" required>
                                    Lebar
                                </x-input.basic>
                            </div>
                            <p class="mt-2 font-semibold text-gray-800 dark:text-white">x</p>
                            <div>
                                <x-input.basic id="length" name="length" placeholder="xx Meter" required>
                                    Panjang
                                </x-input.basic>
                            </div>
                        </div>
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
                                <x-input.select class="hidden" id="other_loadcell_type" name="other_loadcell_type"
                                    :options="[
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
                                        'PST' => 'PST',
                                    ]" default-option="Pilih type loadcell">
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

                    {{-- @livewire('handler.pdf.upload-pdf') --}}
                    <div class="col-span-2 w-full">
                        <p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Upload Dokumen BAST</p>
                        <p class="mb-2 text-xs text-red-500">
                            *Harap mengirimkan file PDF yang sudah di scan terlebih dahulu.
                        </p>

                        <div class="flex w-full flex-col gap-y-2">
                            <label for="bast_document"
                                class="flex h-64 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-zinc-200 bg-gray-50 transition-all duration-500 hover:bg-gray-100 dark:border-zinc-800 dark:bg-gray-700 dark:hover:border-zinc-800 dark:hover:bg-gray-800">
                                <div class="flex flex-col items-center justify-center pb-6 pt-5">
                                    <x-icons.cloud-upload class="mb-4 h-8 w-8 text-gray-500 dark:text-gray-400" />
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                            class="font-semibold">Klik untuk
                                            upload</span>
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Hanya file PDF yang diperbolehkan.
                                        Max: 10MB</p>
                                    <p id="documentName"
                                        class="mt-1 text-base font-semibold text-gray-500 dark:text-gray-400"></p>
                                </div>
                                <input id="bast_document" name="bast_document" accept=".pdf" type="file"
                                    class="hidden" />
                            </label>

                            <div class="flex hidden flex-row items-center gap-2" id="saved_documentation">
                                <x-button.primary class="float-right" id="show_document" type="button"> Lihat dokumen
                                    saat ini
                                </x-button.primary>
                            </div>
                            <div id="captured-images" class="flex hidden flex-row"></div>
                        </div>
                    </div>

                    <div class="col-span-2 w-full">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="job_update">Update
                            Pekerjaan</label>
                        <textarea
                            class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="job_update" rows="25" placeholder="Update pekerjaan..."></textarea>
                    </div>

                    <div class="col-span-2 w-full">
                        <x-input.basic id="point" name="point" readonly>
                            Jumlah poin yang akan kamu dapat:
                        </x-input.basic>
                        <p class="mt-2 text-xs text-green-600 dark:text-green-300">
                            {{ __('*Poin akan diakumulasikan jika laporan telah dikonfirmasi') }}
                        </p>
                    </div>

                    <div class="col-span-2 w-full" id="status_container">
                        <x-input.select id="status" name="status" :options="[
                            '4' => 'Draft',
                            '0' => 'Ajukan',
                        ]"
                            default-option="Pilih status laporan">
                            <x-slot name="textLabel">Status Laporan</x-slot>
                        </x-input.select>
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-status"></div>
                    </div>

                    <div class="relative col-span-2 w-full">
                        <p id="warning_status" class="-mt-1 mb-2 hidden w-full text-right text-sm text-red-600"> * Anda
                            tidak
                            diperbolehkan
                            mengubah
                            laporan yang sedang dalam
                            status
                            <b>Diajukan</b>
                        </p>
                        <x-button.success class="float-right" id="store" type="button">
                            <x-slot name="icon">
                                <x-icons.checklist-stepper class="icon h-5 w-5" />
                            </x-slot>
                            {{ __('Simpan laporan') }}
                        </x-button.success>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    @vite(['resources/js/pages/technician/add.js'])
@endpush
