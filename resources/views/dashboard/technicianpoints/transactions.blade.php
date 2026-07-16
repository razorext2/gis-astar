@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="flex w-full flex-col gap-4 rounded-2xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 lg:p-6"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

        <header class="flex items-center justify-between">
            <h1 class="text-lg font-bold tracking-tight text-zinc-900 dark:text-white lg:text-xl">
                Riwayat Transaksi Poin Keluar
            </h1>
        </header>

        <livewire:powergrid-tables.point-transactions-table />
    </div>
@endsection
