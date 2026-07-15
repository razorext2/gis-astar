{{-- Goal: Add kit details for packing list, Caller: production.packing-list.kits route, Deps: handler.production-histories.packing-list-kit (Livewire) --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative space-y-4">

        {{-- Main Container --}}
        <div
            class="flex flex-col gap-6 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            {{-- Header Section --}}
            <div
                class="flex flex-col justify-between gap-4 border-b border-zinc-200 pb-6 dark:border-zinc-800 md:flex-row md:items-start">
                <div class="flex items-center gap-3">
                    <x-button.danger href="{{ route('production.packing-list.add', ['production' => $data->id]) }}"
                        wire:navigate id="back-button" class="shrink-0">
                        <x-icons.angle-left class="h-5 w-5" />
                    </x-button.danger>

                    <div class="flex flex-col gap-1">
                        <h1 class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white lg:text-2xl">
                            Detail Komponen Packing List
                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                            Customer: <span
                                class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $data->spk->customer['nama_perusahaan'] }}</span>
                        </p>
                    </div>
                </div>

                <div class="hidden items-center gap-2 rounded-lg bg-blue-50 px-3 py-2 dark:bg-blue-900/20 md:flex">
                    <x-icons.info class="h-4 w-4 text-blue-500" />
                    <p class="text-[11px] font-medium text-blue-700 dark:text-blue-300">
                        Input detail komponen atau upload file pendukung.
                    </p>
                </div>
            </div>

            {{-- Info Grid --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div
                    class="flex flex-col gap-1 rounded-xl border border-zinc-100 bg-zinc-50/50 p-4 shadow dark:border-zinc-800 dark:bg-zinc-800/30">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Ekspedisi</span>
                    <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                        {{ $barang['nama_ekspedisi'] ?: '-' }}
                    </span>
                </div>

                <div
                    class="flex flex-col gap-1 rounded-xl border border-zinc-100 bg-zinc-50/50 p-4 shadow dark:border-zinc-800 dark:bg-zinc-800/30">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Nama Barang</span>
                    <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                        {{ $barang['qty_barang'] . ' ' . $barang['satuan_barang'] }} &mdash; {{ $barang['nama_barang'] }}
                    </span>
                    <span class="text-[10px] italic text-zinc-500 dark:text-zinc-400">
                        ({{ Terbilang::make($barang['qty_barang']) }} {{ $barang['satuan_barang'] }})
                    </span>
                </div>
            </div>

            {{-- Livewire Content Area --}}
            <div class="space-y-6">
                @if ($barang['packing_list_type'] === 'manual')
                    <livewire:handler.production-histories.packing-list-kit :idbarang="$barang['id_barang']" :idspk="$data->spk->id" />

                    <div class="space-y-4">
                        <div class="flex items-center gap-2 border-b border-zinc-100 pb-2 dark:border-zinc-800">
                            <x-icons.archive class="h-4 w-4 text-blue-500" />
                            <h4 class="text-sm font-bold text-zinc-900 dark:text-white">Daftar Peti</h4>
                        </div>

                        <livewire:packing-list-kit-table :idbarang="$barang['id_barang']" />
                    </div>
                @endif

                @if ($barang['packing_list_type'] === 'upload')
                    <div class="rounded-xl border border-zinc-100 p-4 dark:border-zinc-800"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                        <livewire:handler.production-histories.packing-list-files :idbarang="$barang['id_barang']" :idspk="$data->spk->id" />
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
