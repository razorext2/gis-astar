{{-- Goal: Form to update Packing List, Caller: production.packing-list.create route, Deps: handler.production-histories.packing-list (Livewire) --}}
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
                    <x-button.danger href="{{ route('production.index') }}" wire:navigate id="back-button" class="shrink-0">
                        <x-icons.angle-left class="h-5 w-5" />
                    </x-button.danger>

                    <div class="flex flex-col gap-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h1 class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white lg:text-2xl">
                                Update Packing List
                            </h1>
                            <span class="font-mono text-sm font-semibold text-blue-600 dark:text-blue-400">
                                {{ $data->spk->nomor_order . ($data->spk->revision_count ? 'R' . str_pad($data->spk->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                            </span>
                        </div>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                            Customer: <span
                                class="font-medium text-zinc-700 dark:text-zinc-300">{{ $data->spk->customer['nama_perusahaan'] }}</span>
                        </p>
                    </div>
                </div>

                {{-- Status / Hint --}}
                <div class="hidden items-center gap-2 rounded-lg bg-blue-50 px-3 py-2 dark:bg-blue-900/20 md:flex">
                    <x-icons.info class="h-4 w-4 text-blue-500" />
                    <p class="text-xs font-medium text-blue-700 dark:text-blue-300">
                        Pastikan semua item terdata dengan benar.
                    </p>
                </div>
            </div>

            {{-- Livewire Content --}}
            <div class="relative">
                <livewire:handler.production-histories.packing-list :id="$data->id" />
            </div>

        </div>
    </div>
@endsection
