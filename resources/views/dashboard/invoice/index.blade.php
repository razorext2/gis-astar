@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative space-y-4">

        <div
            class="flex flex-col rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">

            <span class="text-xl font-semibold text-gray-900 dark:text-white">
                Manajemen Semua Invoice
            </span>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Kamu dapat menambah invoice, mengubah nama invoice, dan menghapus data invoice transaksi Kantor Medan.
            </p>

        </div>

        <div class="flex flex-col justify-between gap-2 lg:flex-row lg:items-center">
            @can(['invoice-list', 'invoice-create'])
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
        </div>

        <div
            class="rounded-xl border border-zinc-200 bg-white/60 px-2 py-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">
            <livewire:powergrid-tables.invoice-table />
        </div>
    </div>
@endsection
