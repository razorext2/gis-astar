@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="mb-16 space-y-4">

        {{-- Header Card --}}
        <div
            class="flex items-center gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <x-button.danger href="{{ route('technicianpoints.transactions') }}" wire:navigate id="back-button"
                class="max-h-10 max-w-fit">
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div>
                <span class="text-xl font-semibold text-zinc-900 dark:text-white">
                    Detail Transaksi Poin Keluar
                </span>

                <p class="mt-0.5 text-sm text-zinc-600 dark:text-zinc-400">
                    Informasi terperinci mengenai pengajuan dan riwayat penukaran poin teknisi.
                </p>
            </div>
        </div>

        {{-- Component Card (Wrapper is handled inside component if necessary, but here we just call it) --}}
        <livewire:handler.point.technician.detail-transaction :transactionID="$transactionID" />

    </div>
@endsection
