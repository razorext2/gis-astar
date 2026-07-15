{{-- Goal: Halaman detail laporan teknisi, Livewire: handler.technician.show, Alpine: - --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="mb-16 space-y-4">
        <div
            class="flex items-center gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <x-button.danger href="{{ route('technician.index') }}" class="max-h-10 w-fit shrink-0" wire:navigate
                id="back-button">
                <x-slot name="icon">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-slot>
            </x-button.danger>

            <div>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Laporan Teknisi
                </span>

                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                    Laporan kunjungan teknisi — No. VT: <span
                        class="font-semibold text-zinc-900 dark:text-white">{{ $technician->no_vt }}</span>
                </p>
            </div>

            @can('technician-approve')
                <div class="ml-auto shrink-0">
                    <x-button.primary
                        href="{{ route('technician.fetch.update', \App\Support\IdObfuscator::encode($technician->id)) }}"
                        wire:navigate id="fetch-button">
                        <x-slot name="icon">
                            <x-icons.clipboard class="icon h-5 w-5" />
                        </x-slot>
                        Fetch Perbaikan Data
                    </x-button.primary>
                </div>
            @endcan
        </div>

        <livewire:handler.technician.show :id="$technician->id" />
    </div>
@endsection
