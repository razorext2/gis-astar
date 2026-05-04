@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="relative grid grid-cols-1 rounded-xl bg-white/60 py-2 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 lg:p-6">

        <div class="flex flex-col px-3 md:mb-2 lg:p-0">
            <div class="mb-2">
                <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                    Cadangan Database
                </span>

                <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                    Silahkan klik tombol cadangkan untuk membuat cadangan database baru.
                </p>
            </div>

            <div>
                @livewire('handler.backups.create')
            </div>
        </div>

        <livewire:table-refresher table-name="BackupTable" />
    </div>
@endsection
