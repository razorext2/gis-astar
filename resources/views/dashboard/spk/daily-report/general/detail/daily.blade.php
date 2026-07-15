@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="mb-16 space-y-4">
        <div
            class="flex items-center gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <x-button.danger
                href="{{ $route == 'report.general.daily' ? route('report.general.index') : route('daily-report.assign', ['spk_id' => $assignment->project->spk_id]) }}"
                wire:navigate id="back-button">
                <x-slot name="icon">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-slot>
            </x-button.danger>

            <div class="flex flex-col">
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Rekap Laporan Harian
                </span>

                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                    Laporan Lapangan adalah feature yang diperuntukkan untuk staff lapangan seperti Teknisi dan Mekanik
                    untuk
                    perekapan pelaporan pekerjaan mereka yang mereka lakukan dilapangan.
                </p>
            </div>
        </div>

        @livewire('handler.spk.daily-report.detail.daily', ['id' => $id])
    </div>
@endsection
