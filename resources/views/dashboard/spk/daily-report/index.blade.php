@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'spkdailyreport'])

    <div
        class="grid grid-cols-1 rounded-xl bg-white/60 py-2 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 lg:p-6">

        <div class="flex flex-col px-3 md:mb-2 lg:p-0">
            <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                Laporan Lapangan
            </span>

            <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                Laporan Lapangan adalah feature yang diperuntukkan untuk staff lapangan seperti Teknisi dan Mekanik untuk
                perekapan pelaporan pekerjaan mereka yang mereka lakukan dilapangan.
            </p>
        </div>

        @livewire('daily-report-table')

    </div>
@endsection
