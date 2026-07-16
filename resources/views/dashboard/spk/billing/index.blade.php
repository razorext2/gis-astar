@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:components.card type="spkbilling" />

    <div class="grid grid-cols-1 gap-6">

        <div class="grid grid-cols-1 rounded-xl border border-zinc-200 px-2 py-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="flex flex-col px-3 md:mb-2 lg:p-0">
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Manajemen Penagihan
                </span>

                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                    Manajemen Penagihan adalah feature yang diperuntukkan untuk Piutang dalam mengelola data penagihan
                    atas SPK Customer.
                </p>
            </div>

            <livewire:billing-table />
        </div>
    </div>
@endsection
