@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="grid grid-cols-1 gap-2 rounded-xl bg-white p-2 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 lg:gap-4 lg:p-6">

        <div class="flex items-center gap-2 lg:gap-4">
            <x-button.link href="{{ route('daily-report.index') }}"
                class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white" wire:navigate id="back-button">
                <x-slot name="icon">
                    <x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
                </x-slot>
                Kembali
            </x-button.link>


            <div class="flex flex-col md:mb-2">
                <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                    Rekap Laporan {{ $spk->nomor_order ?? '' }}
                </span>

                <p class="mt-0.5 hidden text-gray-600 dark:text-gray-400 lg:block lg:text-base">
                    Laporan Lapangan adalah feature yang diperuntukkan untuk staff lapangan seperti Teknisi dan Mekanik
                    untuk pelaporan pekerjaan dilapangan.
                </p>
            </div>
        </div>

        <div class="flex flex-col gap-2 lg:gap-4">
            @can('assign-laporan-harian-spk')
                @livewire('handler.spk.daily-report.assign')
            @endcan

            @livewire('handler.spk.daily-report.reports', ['id' => request()->get('spk_id')])
        </div>
    </div>
@endsection
