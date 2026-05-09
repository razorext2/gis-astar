@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="relative grid grid-cols-1 rounded-xl border border-zinc-200 bg-white/60 py-2 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">

        <div class="flex flex-col px-3 lg:p-0">
            <div>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Log Aktivitas
                </span>

                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                    Berisi semua aktivitas yang pengguna di sistem lakukan.
                </p>
            </div>
        </div>

        <livewire:table-refresher table-name="LogTable" />
    </div>
@endsection
