@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="mb-16 space-y-4">
        {{-- Header Card --}}
        <div class="flex items-center gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <x-button.danger href="{{ route('points.index') }}" wire:navigate class="max-h-10 max-w-fit">
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>
            <div>
                <span class="text-xl font-semibold text-zinc-900 dark:text-white">
                    Tarik Poin Teknisi
                </span>
                <p class="mt-0.5 text-sm text-zinc-600 dark:text-zinc-400">
                    Proses penarikan poin reward teknisi berdasarkan kuartal tahunan.
                </p>
            </div>
        </div>

        {{-- Component Card --}}
        <div class="flex w-full flex-col gap-4 rounded-2xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            @livewire('handler.point.technician.redeem')
        </div>
    </div>
@endsection
