@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="mb-16 space-y-4">
        {{-- Header Container with Back Button --}}
        <div class="flex items-center gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <x-button.danger href="{{ route('technician.show', $hash) }}" class="max-h-10 w-fit shrink-0" wire:navigate
                id="back-button">
                <x-slot name="icon">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-slot>
            </x-button.danger>

            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white"> Fetch Update </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400"> Perbandingan data dari API dan data yang ada didatabase.
                </p>
            </div>
        </div>

        {{-- Livewire Content Container --}}
        <div class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <livewire:handler.technician.fetch :id="$id" />
        </div>
    </div>
@endsection
