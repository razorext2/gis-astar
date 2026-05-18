@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'dailyreport'])

    <div class="relative space-y-4">
        <div
            class="flex flex-col rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">
            <span class="text-xl font-semibold text-gray-900 dark:text-white">
                Laporan Harian
            </span>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Laporan Harian adalah feature yang diperuntukkan untuk staff lapangan seperti Teknisi dan Mekanik
                untuk pelaporan pekerjaan dilapangan.
            </p>
        </div>

        <div
            class="rounded-xl border border-zinc-200 bg-white/60 px-2 py-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">
            @livewire('project-assignment-table')
        </div>
    </div>
@endsection
