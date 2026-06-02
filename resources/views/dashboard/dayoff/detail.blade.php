@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full space-y-6">
        <div
            class="grid gap-6 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none sm:p-6">
            <div class="w-full">
                <header class="flex items-center">

                    <x-button.danger class="my-auto me-4 max-h-10" href="{{ route('dayoff.index') }}" wire:navigate>
                        <x-icons.angle-left class="h-5 w-5" />
                    </x-button.danger>

                    <h2 class="text-lg text-gray-900 dark:text-gray-300">
                        Detail: <span class="font-bold text-white">Permohonan {{ $data->dayoff_for ?? 'N/A' }}
                            {{ $data->pegawaiRelasi->full_name ?? 'N/A' }} </span>
                    </h2>
                </header>
            </div>

            <div class="w-full">
                <div class="grid gap-2 md:grid-cols-2">

                    <div
                        class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Nama Pegawai</p>
                        <p class="text-navy-700 text-base font-medium dark:text-white">
                            {{ $data->pegawaiRelasi->full_name ?? 'N/A' }}
                        </p>
                    </div>

                    <div
                        class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Kode Pegawai</p>
                        <p class="text-navy-700 text-base font-medium dark:text-white">
                            {{ $data->kode_pegawai ?? 'N/A' }}
                        </p>
                    </div>

                    <div
                        class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Jenis Permohonan</p>
                        <p class="text-navy-700 text-base font-medium dark:text-white">
                            {{ $data->dayoff_for ?? 'N/A' }}
                        </p>
                    </div>

                    <div
                        class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Waktu Mulai</p>
                        <p class="text-navy-700 text-base font-medium dark:text-white">
                            {{ $data->tgl_dari ?? 'N/A' }}
                        </p>
                    </div>

                    <div
                        class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Waktu Selesai</p>
                        <p class="text-navy-700 text-base font-medium dark:text-white">
                            {{ $data->tgl_hingga ?? 'N/A' }}
                        </p>
                    </div>

                    <div
                        class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Keterangan</p>
                        <div class="text-navy-700 w-full text-wrap text-base dark:text-white">
                            {!! $data->keterangan !!}
                        </div>
                    </div>

                    <div
                        class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Status</p>
                        <p class="text-navy-700 pt-1.5 text-base font-medium dark:text-white">
                            @php
                                $status = $data->status;

                                if ($status == 1) {
                                    echo '<span class="rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-800 ring-1 ring-zinc-200 dark:bg-green-900 dark:text-green-300 dark:ring-zinc-800"> Diterima </span>';
                                } elseif ($status == 0) {
                                    echo '<span class="rounded-full bg-yellow-100 px-4 py-1 text-sm font-medium text-yellow-800 ring-1 ring-zinc-200 dark:bg-yellow-900 dark:text-yellow-300 dark:ring-zinc-800"> Diajukan </span>';
                                } elseif ($status == 2) {
                                    echo '<span class="rounded-full bg-red-100 px-4 py-1 text-sm font-medium text-red-800 ring-1 ring-zinc-200 dark:bg-red-900 dark:text-red-300 dark:ring-zinc-800"> Ditolak </span>';
                                } else {
                                    echo '<span class="rounded-full bg-red-100 px-4 py-1 text-sm font-medium text-red-800 ring-1 ring-zinc-200 dark:bg-red-900 dark:text-red-300 dark:ring-zinc-800"> Dibatalkan </span>';
                                }
                            @endphp
                        </p>
                    </div>

                    <div
                        class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Divalidasi oleh</p>
                        <p class="text-navy-700 text-base font-medium dark:text-white">
                            {{ $data->validate_by != 0 ? $data->user->name : 'Belum diverifikasi' }}
                        </p>
                    </div>

                    <div
                        class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Catatan</p>
                        <p class="text-navy-700 text-base font-medium dark:text-white">
                            {{ $data->notes ?? 'N/A' }}
                        </p>
                    </div>

                    <div
                        class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Lampiran</p>

                        @php
                            $urls = json_decode($data->url, true);
                        @endphp

                        <div class="flex flex-col">
                            @foreach ($urls as $url => $key)
                                <a href="{{ $key }}" target="_blank"
                                    class="text-navy-700 text-base font-medium underline dark:text-white">Lampiran
                                    {{ $url + 1 }}, </a>
                            @endforeach
                        </div>
                    </div>

                    @if ($data->status && auth()->user()->can('dayoff-approve'))
                        <div class="col-span-2 mt-2 flex flex-col justify-end" id="action">
                            <div class="text-right">

                                <x-button.success class="confirm-btn float-right" id="confirm-btn"
                                    data-id="{{ $data->id }}" type="button">
                                    <x-slot name="icon">
                                        <x-icons.angle-right class="h-5 w-5" />
                                    </x-slot>
                                    Konfirmasi
                                </x-button.success>

                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    @vite('resources/js/pages/dayoff/detail.js')
@endpush
