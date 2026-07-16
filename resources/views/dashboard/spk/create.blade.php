@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="mb-16 flex flex-col gap-4">
        <div class="flex items-center gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <x-button.danger href="{{ route('spk.index') }}" class="max-h-10 max-w-fit" wire:navigate id="back-button">
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah SPK
                </span>

                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Manajemen SPK adalah feature yang diperuntukkan untuk Marketing dalam mengelola data SPK Customer.
                </p>
            </div>

        </div>

        <livewire:handler.spk.create />
    </div>
@endsection
