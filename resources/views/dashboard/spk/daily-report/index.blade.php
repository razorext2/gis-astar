@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="grid grid-cols-1 rounded-xl bg-white py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">

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
