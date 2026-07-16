@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-6">

        <div class="relative grid grid-cols-1 rounded-xl border border-zinc-200 px-2 py-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">
                <div class="mb-2">
                    <span class="text-xl font-semibold text-gray-900 dark:text-white">
                        Laporan rute driver
                    </span>

                    <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                        Kamu dapat melihat detail rute harian driver dihalaman ini.
                    </p>
                </div>

            </div>

            <livewire:powergrid-tables.driver-route-table />

        </div>
    </div>
@endsection
