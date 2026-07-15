@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="grid w-full gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none sm:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <div class="w-full">
            <header class="flex items-center">
                <x-button.danger href="{{ route('driver.index') }}" wire:navigate class="my-auto me-4 max-h-10">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>

                <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ __('Assign Laporan Driver') }}
                </h2>

            </header>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                {{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
            </p>
        </div>

        <livewire:handler.driver.assign-to :id="$id" />
    </div>
@endsection
