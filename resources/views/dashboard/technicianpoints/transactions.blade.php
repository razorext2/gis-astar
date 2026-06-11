@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex w-full flex-col gap-4 rounded-2xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 lg:p-6">

        <header class="flex items-center justify-between">
            <h1 class="text-lg font-bold tracking-tight text-zinc-900 dark:text-white lg:text-xl">
                Riwayat Transaksi Poin Keluar
            </h1>
        </header>

        <livewire:powergrid-tables.point-transactions-table />
    </div>
@endsection
