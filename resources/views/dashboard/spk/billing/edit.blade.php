@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative space-y-4 lg:space-y-6">

        {{-- Header Card --}}
        <div
            class="flex items-center gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">

            <x-button.danger href="{{ route('billing.index') }}" class="w-fit" wire:navigate id="back-button"
                class="max-h-10 max-w-fit">
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Update Nomor Tagihan</h1>
                    <span
                        class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-xs font-bold text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-900/30 dark:text-blue-400">
                        SPK Billing
                    </span>
                </div>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                    Silahkan isi nomor penagihan menggunakan nomor SR ataupun Faktur Pajak sesuai dengan data SPK.
                </p>
            </div>
        </div>

        {{-- Main Content --}}
        @livewire('handler.spk.billing-update', ['id' => $id])
    </div>
@endsection
