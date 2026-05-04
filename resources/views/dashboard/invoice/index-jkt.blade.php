@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-4">

        <div
            class="flex flex-col rounded-xl bg-white/60 p-2 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 lg:p-6">

            <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                Manajemen Invoice Jakarta
            </span>

            <p class="text-base text-gray-600 dark:text-gray-400">
                Kamu dapat menambah invoice, mengubah nama invoice, dan menghapus data invoice transaksi Kantor Cabang
                Jakarta.
            </p>

        </div>

        <div class="flex flex-row items-center justify-between gap-2">
            @can(['invoice-list', 'invoice-add'])
                <div class="flex flex-row gap-2">
                    <x-button.success wire:navigate href="{{ route('invoice.jkt.create', ['tipe_tagihan' => 'idcppn']) }}">
                        <x-slot name="icon">
                            <x-icons.angle-right class="h-6 w-6" />
                        </x-slot>
                        Invoice IDC
                    </x-button.success>

                    <x-button.success wire:navigate href="{{ route('invoice.jkt.create', ['tipe_tagihan' => 'idyppn']) }}">
                        <x-slot name="icon">
                            <x-icons.angle-right class="h-6 w-6" />
                        </x-slot>
                        Invoice IDY
                    </x-button.success>
                </div>
            @endcan

            @canany(['invoice-export-all', 'invoice-export-jkt'])
                <div class="max-w-xs">
                    <livewire:handler.invoice.export />
                </div>
            @endcanany
        </div>

        <div
            class="rounded-xl bg-white/60 p-2 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 lg:p-6">
            <livewire:table-refresher table-name="InvoiceTable" />
        </div>
    </div>
@endsection
