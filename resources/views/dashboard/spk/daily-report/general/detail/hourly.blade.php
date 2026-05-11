@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="mb-16 space-y-4">
        <div
            class="flex items-center gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">

            <x-button.danger href="{{ route('daily-report.daily', ['id' => $dailyReport->assignment_id]) }}"
                class="max-h-10 w-fit shrink-0" wire:navigate id="back-button">
                <x-slot name="icon">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-slot>
                Kembali
            </x-button.danger>

            <div>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Rekap Laporan Aktivitas
                </span>

                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                    Laporan Lapangan adalah feature yang diperuntukkan untuk staff lapangan seperti Teknisi dan Mekanik
                    untuk
                    perekapan pelaporan pekerjaan mereka yang mereka lakukan dilapangan.
                </p>
            </div>
        </div>

        @livewire('handler.spk.daily-report.detail.hourly', ['id' => $daily])
    </div>
@endsection
