@extends('dashboard.layoutsDash.app')
{{-- Goal: Update SPK Delivery details page, Caller: spk.delivery.index, Deps: Handler\Spk\DeliveryUpdate --}}
@section('content')
    <div class="relative space-y-4">

        {{-- Header Card --}}
        <div class="flex flex-col rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    <x-button.danger href="{{ route('delivery.index') }}" class="w-fit" wire:navigate id="back-button"
                        class="max-h-10 max-w-fit">
                        <x-icons.angle-left class="h-5 w-5" />
                    </x-button.danger>

                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Update Pengiriman</h1>
                            <span
                                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-xs font-bold text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-900/30 dark:text-blue-400">
                                {{ $data->nomor_order }}
                            </span>
                        </div>

                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                            Kelola detail logistik dan informasi pengiriman untuk pelanggan.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    @if ($data->is_using_company_driver)
                        <span
                            class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-[10px] font-bold text-indigo-700 ring-1 ring-inset ring-indigo-700/10 dark:bg-indigo-900/30 dark:text-indigo-400">
                            <x-icons.user class="mr-1 h-3 w-3" /> Supir Perusahaan
                        </span>
                    @endif

                    @if ($data->is_picked_up_by_customer)
                        <span
                            class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-[10px] font-bold text-amber-700 ring-1 ring-inset ring-amber-700/10 dark:bg-amber-900/30 dark:text-amber-400">
                            <x-icons.shopping-bag class="mr-1 h-3 w-3" /> Dijemput Customer
                        </span>
                    @endif
                </div>
            </div>

            {{-- Customer Quick Info --}}
            <div
                class="mt-4 flex items-center gap-3 rounded-lg border border-zinc-100 bg-zinc-50/50 p-3 shadow dark:border-zinc-800/50 dark:bg-zinc-800/30">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white shadow-sm dark:bg-zinc-800">
                    <x-icons.office-building class="h-5 w-5 text-zinc-400" />
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Pelanggan / Perusahaan</p>
                    <p class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $data->customer['nama_perusahaan'] }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <livewire:handler.spk.delivery-update :id="$id" />
        </div>

    </div>
@endsection
