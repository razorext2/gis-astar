@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-4">

        <div
            class="flex flex-col rounded-xl bg-white p-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">

            <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                {{ request()->route()->getName() === 'invoice.all.index' ? 'Manajemen Semua Invoice' : 'Manajemen Invoice Medan' }}
            </span>

            <p class="text-base text-gray-600 dark:text-gray-400">
                Kamu dapat menambah invoice, mengubah nama invoice, dan menghapus data invoice transaksi Kantor Medan.
            </p>

        </div>

        @can(['invoice-list', 'invoice-add'])
            @php
                $routeName = match (request()->route()->getName()) {
                    'invoice.all.index' => 'invoice.all.create',
                    'invoice.cust.index' => 'invoice.cust.create',
                    'invoice.medan.index' => 'invoice.medan.create',
                };
            @endphp

            <div class="flex flex-row gap-2">
                <x-button.link wire:navigate class="w-fit ring-1 ring-green-700 dark:bg-green-800 dark:text-white"
                    href="{{ route($routeName, ['tipe_tagihan' => 'idcppn']) }}">
                    <x-slot name="icon">
                        <x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
                    </x-slot>
                    Invoice IDC
                </x-button.link>

                <x-button.link wire:navigate class="w-fit ring-1 ring-green-700 dark:bg-green-800 dark:text-white"
                    href="{{ route($routeName, ['tipe_tagihan' => 'idyppn']) }}">
                    <x-slot name="icon">
                        <x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
                    </x-slot>
                    Invoice IDY
                </x-button.link>
            </div>
        @endcan

        <div
            class="rounded-xl bg-white p-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">
            <livewire:table-refresher table-name="InvoiceTable" />
        </div>
    </div>
@endsection
