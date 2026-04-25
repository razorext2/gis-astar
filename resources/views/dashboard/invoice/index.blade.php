@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-4">

        <div
            class="flex flex-col rounded-xl bg-white p-2 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 lg:p-6">

            <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                Manajemen Semua Invoice
            </span>

            <p class="text-base text-gray-600 dark:text-gray-400">
                Kamu dapat menambah invoice, mengubah nama invoice, dan menghapus data invoice transaksi Kantor Medan.
            </p>

        </div>

        <div class="flex flex-row items-center justify-between gap-2">
            @can(['invoice-list', 'invoice-add'])
                @php
                    $routeName = match (request()->route()->getName()) {
                        'invoice.all.index' => 'invoice.all.create',
                        'invoice.cust.index' => 'invoice.cust.create',
                        'invoice.medan.index' => 'invoice.medan.create',
                        default => 'invoice.all.create',
                    };
                @endphp

                <div class="flex flex-row gap-2">
                    <x-button.success wire:navigate href="{{ route($routeName, ['tipe_tagihan' => 'idcppn']) }}">
                        <x-slot name="icon">
                            <x-icons.angle-right class="h-6 w-6" />
                        </x-slot>
                        Invoice IDC
                    </x-button.success>

                    <x-button.success wire:navigate href="{{ route($routeName, ['tipe_tagihan' => 'idyppn']) }}">
                        <x-slot name="icon">
                            <x-icons.angle-right class="h-6 w-6" />
                        </x-slot>
                        Invoice IDY
                    </x-button.success>
                </div>
            @endcan

            @canany(['invoice-export-all', 'invoice-export-cust', 'invoice-export-medan', 'invoice-export-pku',
                'invoice-export-jkt'])
                <div class="max-w-xs">
                    <livewire:handler.invoice.export />
                </div>
            @endcanany
        </div>

        <div
            class="rounded-xl bg-white p-2 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 lg:p-6">
            <livewire:table-refresher table-name="InvoiceTable" />
        </div>
    </div>
@endsection
