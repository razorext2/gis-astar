@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="w-full rounded-xl bg-white p-4 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 md:p-6">

        <header class="mb-4 flex items-center justify-between">
            <p class="text-lg font-semibold text-gray-900 dark:text-white lg:text-xl">
                Detail Transaksi Poin Keluar
            </p>
        </header>

        <livewire:handler.point.technician.detail-transaction :transactionID="$transactionID" />

    </div>
@endsection
