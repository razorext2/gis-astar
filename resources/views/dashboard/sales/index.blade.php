@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:components.card type="salesreport" />

    {{-- Handler: validate sales modal — dipasang sekali di luar tabel, diaktifkan via event --}}
    @can('sales-approve')
        <livewire:handler.sales.validate-sales wire:key="sales-validate-modal" />
    @endcan

    <form id="add-form" action="{{ route('sales.create') }}"></form>
    <div class="relative grid grid-cols-1 gap-4">

        <div class="flex items-center justify-between gap-2 md:justify-start md:gap-4">
            @can('sales-create')
                <div class="max-w-xs">
                    <x-button.success id="add-button" form="add-form" type="submit">
                        <x-slot name="icon">
                            <x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
                        </x-slot>
                        Tambah Data
                    </x-button.success>
                </div>
            @endcan
        </div>

        <div class="flex h-auto items-center justify-center">
            <div
                class="grid w-full grid-cols-2 gap-2 rounded-xl border border-zinc-200 p-2 shadow-md dark:border-zinc-800 dark:shadow-none md:gap-4 md:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

                <div class="col-span-2">
                    <livewire:sales-table />
                </div>

            </div>
        </div>
    </div>
@endsection
