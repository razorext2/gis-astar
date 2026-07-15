@extends('dashboard.layoutsDash.app')
@section('content')
    @php
        $tp = match ((string) $data->tipe_kunjungan) {
            'ATRBRG' => 'Antar Barang (SR)',
            'JPTBRG' => 'Jemput Barang',
            'ATRTEK' => 'Antar Teknisi',
            'JPTTEK' => 'Jemput Teknisi',
            default => 'N/A',
        };

        $sp = match ((int) $data->status_pengantaran) {
            1 => 'Belum Diterima',
            2 => 'Sudah Diterima',
            default => 'N/A',
        };

        $statusClasses = [
            0 => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
            1 => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            2 => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
            3 => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
            4 => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300',
            5 => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300',
        ];

        $statusLabels = [
            0 => 'Sedang Diajukan',
            1 => 'Disetujui',
            2 => 'Ditolak',
            3 => 'Perlu Diperbaiki',
            4 => 'Belum Di-assign',
            5 => 'Menunggu Update',
        ];
    @endphp

    <div class="w-full space-y-4">
        {{-- Header / Main Info Card --}}
        <div
            class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <header class="flex items-center">
                <x-button.danger href="{{ route('driver.index') }}" wire:navigate class="my-auto me-4 max-h-10">
                    <x-slot name="icon">
                        <x-icons.angle-left class="h-4 w-4" />
                    </x-slot>
                    Kembali
                </x-button.danger>

                <div>
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                        {{ $data->title ?? 'N/A' }}
                    </h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        Detail Laporan Driver
                    </p>
                </div>
            </header>
        </div>

        <div
            class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="space-y-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Tujuan
                        Perjalanan</p>
                    <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $tp }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Status
                        Pengantaran</p>
                    <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $sp }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Driver</p>
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                            <x-icons.user class="h-5 w-5" />
                        </div>
                        <div>
                            <div class="flex items-center gap-x-2">
                                <p class="font-semibold text-zinc-900 dark:text-white">{{ $data->pegawai->full_name ?? 'N/A' }}</p>
                                @if ($data->pegawai?->userRelasi)
                                    <x-dashboard.badge-inactive :is_active="$data->pegawai->userRelasi->is_active ?? true" />
                                @endif
                            </div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $data->kode_pegawai }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Status Validasi
                    </p>
                    <div>
                        <span
                            class="{{ $statusClasses[$data->status] ?? $statusClasses[4] }} inline-flex items-center rounded-lg px-3 py-1 text-sm font-bold">
                            {{ $statusLabels[$data->status] ?? 'Unknown' }}
                        </span>
                        @if (in_array($data->status, [1, 2, 3]) && $data->validateBy)
                            <div class="mt-1 flex items-center gap-x-2 text-[10px] text-zinc-500 dark:text-zinc-400">
                                <span>Oleh: {{ $data->validateBy->name }}</span>
                                <x-dashboard.badge-inactive :is_active="$data->validateBy?->is_active ?? true" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <hr class="my-6 border-zinc-200 dark:border-zinc-800">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div class="space-y-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Waktu Dibuat
                    </p>
                    <p class="font-semibold text-zinc-900 dark:text-white">
                        {{ $data->created_at ? $data->created_at->locale('id')->isoFormat('D MMM YYYY HH:mm:s') : 'N/A' }}
                    </p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Waktu Diupdate
                    </p>
                    <p class="font-semibold text-zinc-900 dark:text-white">
                        {{ $data->updated_at ? $data->updated_at->locale('id')->isoFormat('D MMM YYYY HH:mm:s') : 'N/A' }}
                    </p>
                </div>
            </div>

            @can('driver-approve')
                @if ($data->status == 0)
                    <hr class="my-6 border-zinc-200 dark:border-zinc-800">
                    <div class="flex flex-col items-center justify-between gap-4 sm:flex-row" id="action">
                        <div class="hidden sm:block">
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Konfirmasi
                                Laporan</p>
                            <p class="text-sm text-zinc-600 dark:text-zinc-300">Silahkan verifikasi laporan berikut:</p>
                        </div>
                        <div class="flex w-full items-center justify-end gap-3 text-right sm:w-auto">
                            <x-button.success class="confirm-btn min-w-[140px]" id="confirm-btn" data-id="{{ $data->id }}"
                                data-validateby="{{ Crypt::encryptString(auth()->user()->id) }}" type="button">
                                <x-slot name="icon">
                                    <x-icons.check-circle class="h-4 w-4" />
                                </x-slot>
                                Approve Laporan
                            </x-button.success>
                        </div>
                    </div>
                @endif
            @endcan

            @if ($data->status == 3 && $data->total_revision <= 2)
                <hr class="my-6 border-zinc-200 dark:border-zinc-800">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <div class="hidden sm:block">
                        <p class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Revisi
                            Laporan</p>
                        <p class="text-sm text-zinc-600 dark:text-zinc-300">Laporan memerlukan perbaikan.</p>
                    </div>
                    <div class="flex w-full items-center justify-end gap-3 sm:w-auto">
                        <x-button.danger href="{{ route('driver.edit', $data->id) }}" class="min-w-[140px]">
                            <x-slot name="icon">
                                <x-icons.checklist-stepper class="h-4 w-4" />
                            </x-slot>
                            Klik untuk revisi
                        </x-button.danger>
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            {{-- Keterangan / Catatan Card --}}
            <div
                class="rounded-xl border border-zinc-200 p-6 shadow-md dark:border-zinc-800 dark:shadow-none"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                <h3 class="mb-4 flex items-center gap-2 text-lg font-bold text-zinc-900 dark:text-white">
                    <x-icons.book-open class="h-5 w-5 text-blue-500" />
                    Keterangan Laporan
                </h3>

                <div class="prose prose-sm dark:prose-invert prose-p:leading-relaxed prose-p:m-0 prose-ul:m-0 prose-li:m-0 quill-content max-w-none rounded-lg border border-zinc-100 bg-zinc-50 p-4 text-sm text-zinc-700 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-300"
                    id="editor">
                    {!! $data->keterangan ?? 'Belum diupdate.' !!}
                </div>

                @if ($data->notes)
                    <div
                        class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-900/30 dark:bg-red-900/10">
                        <h4 class="flex items-center gap-2 text-sm font-bold text-red-800 dark:text-red-400">
                            <x-icons.exclamation-circle class="h-4 w-4" />
                            Catatan Internal:
                        </h4>
                        <p class="mt-1 text-sm text-red-700 dark:text-red-300">{{ $data->notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Location Card --}}
            <div
                class="rounded-xl border border-zinc-200 p-6 shadow-md dark:border-zinc-800 dark:shadow-none"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                <h3 class="mb-4 flex items-center gap-2 text-lg font-bold text-zinc-900 dark:text-white">
                    <x-icons.map-pin class="h-5 w-5 text-red-500" />
                    Lokasi Checkpoint
                </h3>

                @if ($data->latitude && $data->longitude)
                    <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
                        <iframe class="h-[300px] w-full grayscale-[20%] dark:hue-rotate-180 dark:invert-[90%]"
                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            src="https://maps.google.com/maps?q={{ $data->latitude }},{{ $data->longitude }}&hl=id&z=17&t=k&output=embed">
                        </iframe>
                    </div>
                    <div class="mt-4 flex items-start gap-2">
                        <x-icons.map-pin class="mt-1 h-4 w-4 shrink-0 text-zinc-400" />
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $data->lokasi ?? 'Alamat tidak tersedia' }}
                        </p>
                    </div>
                    <div class="mt-2 flex gap-4 text-xs text-zinc-400">
                        <span>Lat: {{ $data->latitude }}</span>
                        <span>Long: {{ $data->longitude }}</span>
                    </div>
                @else
                    <p class="p-2 text-sm text-zinc-500 lg:p-4">Belum diupdate.</p>
                @endif
            </div>
        </div>

        {{-- Documentation Card --}}
        <div
            class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <h3 class="mb-4 flex items-center gap-2 text-lg font-bold text-zinc-900 dark:text-white">
                <x-icons.camera class="h-5 w-5 text-indigo-500" />
                Dokumentasi Lapangan
            </h3>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5" id="captured-images">
                @forelse ($data->photoCollect as $photo)
                    <div
                        class="group relative aspect-square overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
                        <img src="{{ asset($photo->photourl) }}" alt="Dokumentasi" id="documentations"
                            data-url="{{ asset($photo->photourl) }}"
                            onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                            class="h-full w-full cursor-pointer object-cover transition-transform duration-500 group-hover:scale-110"
                            loading="lazy">
                    </div>
                @empty
                    <div
                        class="col-span-full flex h-32 flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 dark:border-zinc-800">
                        <x-icons.camera class="h-8 w-8 text-zinc-300" />
                        <p class="mt-2 text-sm text-zinc-500">Tidak ada foto dokumentasi</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
@push('script')
    @vite('resources/js/pages/driver/detail.js')
@endpush
