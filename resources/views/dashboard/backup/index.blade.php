@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 rounded-xl border border-zinc-200 py-2 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

        <div class="flex flex-col px-3 md:mb-2 lg:p-0">
            <div class="mb-2">
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Cadangan Database
                </span>

                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                    Silahkan klik tombol cadangkan untuk membuat cadangan database baru.
                </p>
            </div>

            <div>
                <livewire:handler.backups.create />
            </div>
        </div>

        <livewire:powergrid-tables.backup-table />
    </div>
@endsection
