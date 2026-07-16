@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="grid grid-cols-1 gap-2 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:gap-4 lg:p-6"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

        <div class="flex items-center">
            <x-button.danger href="{{ route('daily-report.index') }}" wire:navigate id="back-button"
                class="my-auto me-4 max-h-10">
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div class="flex flex-col md:mb-2">
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Rekap Laporan {{ $spk->nomor_order ?? '' }}
                </span>

                <p class="mt-0.5 hidden text-gray-600 dark:text-gray-400 lg:block lg:text-base">
                    Laporan Lapangan adalah feature yang diperuntukkan untuk staff lapangan seperti Teknisi dan Mekanik
                    untuk pelaporan pekerjaan dilapangan.
                </p>
            </div>
        </div>

        <div class="flex flex-col gap-2 lg:gap-4">
            @can('laporan-harian-spk-assign')
                <livewire:handler.spk.daily-report.assign />
            @endcan

            <livewire:handler.spk.daily-report.reports :id="request()->get('spk_id')" />
        </div>
    </div>
@endsection
