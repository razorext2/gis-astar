{{-- Goal: Display SPK Production progress detail, Caller: production.show route, Deps: production-histories handler --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative space-y-4">
        {{-- Outer Card --}}
        <div
            class="flex flex-col gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            {{-- Header Section: Order Status --}}
            <div
                class="flex flex-col justify-between gap-4 border-b border-zinc-200 pb-4 dark:border-zinc-800 md:flex-row md:items-start">
                <div class="flex items-center gap-3">
                    <x-button.danger href="{{ route('production.index') }}" wire:navigate id="back-button" class="shrink-0">
                        <x-icons.angle-left class="h-5 w-5" />
                    </x-button.danger>

                    <div class="flex flex-col gap-1.5">
                        <div class="flex flex-wrap items-center gap-2">
                            <h1
                                class="font-mono text-xl font-bold tracking-tight text-zinc-900 dark:text-white lg:text-2xl">
                                {{ $data->spk->nomor_order . ($data->spk->revision_count ? 'R' . str_pad($data->spk->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                            </h1>

                            @php
                                $badgeClasses = match ($data->spk->status_approval) {
                                    0
                                        => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-900/20 dark:text-amber-400 dark:ring-amber-500/30',
                                    1
                                        => 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-900/20 dark:text-green-400 dark:ring-green-500/30',
                                    2
                                        => 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-900/20 dark:text-red-400 dark:ring-red-500/30',
                                    3
                                        => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-900/20 dark:text-amber-400 dark:ring-amber-500/30',
                                    default
                                        => 'bg-zinc-50 text-zinc-700 ring-zinc-600/20 dark:bg-zinc-900/20 dark:text-zinc-400 dark:ring-zinc-500/30',
                                };
                            @endphp
                            <span class="{{ $badgeClasses }} rounded-lg px-2.5 py-1 text-xs font-medium ring-1">
                                {{ $data->spk->status_approval_description }}
                            </span>
                        </div>

                        @if ($data->spk->latest_revision_request_detail)
                            <p class="text-sm text-red-600 dark:text-red-400">
                                <span class="font-semibold text-zinc-700 dark:text-zinc-300">Revisi Terakhir:</span>
                                {{ $data->spk->latest_revision_request_detail }}
                            </p>
                        @endif

                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $data->spk->customer['nama_perusahaan'] }} &mdash; Laporan Progres Produksi
                        </p>
                    </div>
                </div>

                @hasanyrole(['Admin', 'Produksi'])
                    <div class="shrink-0">
                        <x-button.primary href="{{ route('spk.generate.pdf', ['id' => $data->spk->id]) }}" id="spk-pdf-export">
                            Ekspor SPK
                        </x-button.primary>
                    </div>
                @endhasanyrole
            </div>

            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                {{-- Card: Detail Order --}}
                <div
                    class="flex flex-col gap-4 rounded-xl border border-zinc-100 p-4 shadow-sm dark:border-zinc-800 dark:shadow-none"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                    <h3
                        class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                        <x-icons.file-invoice class="h-4 w-4 text-blue-500" /> Detail Order
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tanggal Cetak</span>
                            <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($data->spk->tgl_cetak)->locale('id')->isoFormat('D MMMM Y') }}
                            </span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Waktu Penyerahan</span>
                            <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                                {{ $data->spk->tgl_kirim }} Hari
                                @if ($data->spk->tgl_kirim <= 1)
                                    <span
                                        class="ml-1 rounded-full bg-red-100 px-2 py-0.5 text-xs font-bold text-red-600 dark:bg-red-900/30 dark:text-red-400">SEGERA</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tipe Tagihan</span>
                            <span class="text-sm font-semibold uppercase text-zinc-900 dark:text-white">
                                {{ $data->spk->tipe_tagihan }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Card: Informasi Customer --}}
                <div
                    class="flex flex-col gap-4 rounded-xl border border-zinc-100 p-4 shadow-sm dark:border-zinc-800 dark:shadow-none"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                    <h3
                        class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                        <x-icons.user class="h-4 w-4 text-blue-500" /> Informasi Customer
                    </h3>
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Nama Perusahaan /
                                Customer</span>
                            <span
                                class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $data->spk->customer['nama_perusahaan'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Card: Daftar Produk Dipesan (full width) --}}
                <div
                    class="flex flex-col gap-4 rounded-xl border border-zinc-100 p-4 shadow-sm dark:border-zinc-800 dark:shadow-none md:col-span-2"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                    <div
                        class="flex flex-wrap items-center justify-between gap-4 border-b border-zinc-100 pb-3 dark:border-zinc-800">
                        <h3 class="flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-white">
                            <x-icons.archive class="h-4 w-4 text-blue-500" /> Daftar Produk Dipesan
                        </h3>
                        <span
                            class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium uppercase text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                            {{ $data->spk->tipe_timbangan ?? 'Tipe timbangan tidak diatur.' }}
                        </span>
                    </div>

                    <div class="max-h-52 overflow-x-auto overflow-y-auto">
                        <table class="w-full text-left text-sm">
                            <thead
                                class="border-b border-zinc-100 text-xs text-zinc-500 dark:border-zinc-800 dark:text-zinc-400">
                                <tr>
                                    <th class="pb-2 font-medium">Nama Barang</th>
                                    <th class="w-32 pb-2 text-center font-medium">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                @forelse ($data->spk->products as $row)
                                    <tr>
                                        <td class="py-3 pr-4">
                                            <p class="font-semibold text-zinc-900 dark:text-white">
                                                {{ $row['nama_barang'] ?? '-' }}</p>
                                        </td>
                                        <td class="py-3 text-center align-top">
                                            <span
                                                class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30">
                                                {{ $row['jumlah_unit'] ?? '' }} {{ $row['satuan_barang'] ?? '' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2"
                                            class="py-4 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                            Tidak ada produk dipesan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Bahan Stok Lama Banner --}}
                    <div
                        class="flex flex-col justify-between gap-4 rounded-lg bg-zinc-50 p-4 dark:bg-zinc-800/50 sm:flex-row sm:items-center">
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-zinc-900 dark:text-white">Produksi menggunakan bahan
                                stok lama?</span>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Identifikasi bahan baku yang digunakan
                                dalam proses produksi.</span>
                        </div>
                        @if ($data->spk->is_using_old_stock)
                            <span
                                class="inline-flex shrink-0 items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                Menggunakan Stok Lama
                            </span>
                        @else
                            <span
                                class="inline-flex shrink-0 items-center gap-1 rounded-full bg-zinc-200 px-3 py-1 text-xs font-semibold text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300">
                                Tidak Menggunakan Stok Lama
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Card: Staff --}}
                <div
                    class="flex flex-col gap-4 rounded-xl border border-zinc-100 p-4 shadow-sm dark:border-zinc-800 dark:shadow-none"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                    <h3
                        class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                        <x-icons.users class="h-4 w-4 text-blue-500" /> Staff
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Ditambah Oleh</span>
                            <div class="flex items-center gap-x-2">
                                <span class="text-sm font-semibold capitalize text-zinc-900 dark:text-white">{{ $data->spk->addedBy->name }}</span>
                                <x-dashboard.badge-inactive :is_active="$data->spk->addedBy?->is_active ?? true" />
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Diproduksi Oleh</span>
                            <div class="flex items-center gap-x-2">
                                <span class="text-sm font-semibold capitalize text-zinc-900 dark:text-white">{{ $data->spk->assignTo->name ?? '-' }}</span>
                                @if ($data->spk->assignTo)
                                    <x-dashboard.badge-inactive :is_active="$data->spk->assignTo?->is_active ?? true" />
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Reassign Ke</span>
                            <div class="flex items-center gap-x-2">
                                <span class="text-sm font-semibold capitalize text-zinc-900 dark:text-white">{{ $data->reassignTo->name ?? '-' }}</span>
                                @if ($data->reassignTo)
                                    <x-dashboard.badge-inactive :is_active="$data->reassignTo?->is_active ?? true" />
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Divalidasi Oleh</span>
                            <div class="flex items-center gap-x-2">
                                <span class="text-sm font-semibold capitalize text-zinc-900 dark:text-white">{{ $data->spk->approvedBy->name ?? '-' }}</span>
                                @if ($data->spk->approvedBy)
                                    <x-dashboard.badge-inactive :is_active="$data->spk->approvedBy?->is_active ?? true" />
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Divalidasi Pada</span>
                            <span class="text-sm font-semibold capitalize text-zinc-900 dark:text-white">
                                {{ $data->spk->approved_at
                                    ? \Carbon\Carbon::parse($data->spk->approved_at)->locale('id')->isoFormat('D MMMM Y HH:mm:ss')
                                    : '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Card: Progress Produksi --}}
                <div
                    class="flex flex-col gap-4 rounded-xl border border-zinc-100 p-4 shadow-sm dark:border-zinc-800 dark:shadow-none"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                    <div class="flex items-center justify-between border-b border-zinc-100 pb-3 dark:border-zinc-800">
                        <h3 class="flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-white">
                            <x-icons.bar class="h-4 w-4 text-blue-500" /> Progress Produksi
                        </h3>
                        <span class="text-sm font-bold text-blue-600 dark:text-blue-400">
                            {{ $data->productionHistories?->last()->status_produksi_description['percentage'] ?? '0' }}%
                        </span>
                    </div>

                    @php
                        $pct = $data->productionHistories?->last()->status_produksi_description['percentage'] ?? 0;
                        $progressLabel =
                            $data->productionHistories?->last()->status_produksi_description['label'] ?? '';
                    @endphp

                    <div class="space-y-3">
                        <div class="relative h-3 w-full overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-800">
                            {{-- Progress Fill --}}
                            <div class="absolute inset-y-0 left-0 rounded-full bg-blue-600 transition-all duration-700 ease-out"
                                style="width: {{ $pct }}%">
                                {{-- Subtle shine effect --}}
                                <div
                                    class="absolute inset-0 animate-pulse bg-gradient-to-r from-transparent via-white/20 to-transparent">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                Status: <span
                                    class="font-semibold text-zinc-900 dark:text-zinc-200">{{ $progressLabel ?: 'Menunggu Produksi' }}</span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        {{-- End Outer Card --}}

        {{-- Riwayat Produksi --}}
        @can('produksi-list')
            <div
                class="flex flex-col gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

                <div
                    class="flex flex-wrap items-center justify-between gap-4 border-b border-zinc-200 pb-4 dark:border-zinc-800">
                    <h2 class="flex items-center gap-2 text-base font-semibold text-zinc-900 dark:text-white">
                        <x-icons.clipboard class="h-4 w-4 text-blue-500" /> Riwayat Produksi
                    </h2>

                    @can('produksi-create')
                        <x-button.primary wire:navigate :href="route('production.history.add', $data->id)" wire:transition.duration.300ms
                            id="produksi-histories-add">
                            <x-slot name="icon">
                                <x-icons.plus class="h-5 w-5 -rotate-90 text-green-400 dark:text-white" />
                            </x-slot>
                            Tambah Laporan
                        </x-button.primary>
                    @endcan
                </div>

                @livewire('handler.production-histories.histories-list', ['id' => $data->id], $data->id)
            </div>
        @endcan
        {{-- End Riwayat Produksi --}}
    </div>

    @push('script')
        @vite('resources/js/pages/spk/show.js')
    @endpush
@endsection
