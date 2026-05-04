@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="grid grid-cols-1 gap-2 rounded-xl bg-white/60 p-2 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 lg:gap-4 lg:p-6">

        <div class="flex flex-col">
            <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                Rekap Laporan Harian
            </span>

            <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                Laporan Lapangan adalah feature yang diperuntukkan untuk staff lapangan seperti Teknisi dan Mekanik untuk
                perekapan pelaporan pekerjaan mereka yang mereka lakukan dilapangan.
            </p>
        </div>

        <div class="flex flex-col gap-2 lg:gap-4">
            @livewire('handler.spk.daily-report.detail.daily', ['id' => $id])
        </div>

    </div>
@endsection
