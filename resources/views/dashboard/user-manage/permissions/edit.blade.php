{{-- Goal: Edit Permissions Page, Livewire: handler.permissions.delete, handler.permissions.update, Alpine: - --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none sm:p-6 xl:w-1/2"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

        <header class="flex items-center">
            <x-button.danger class="my-auto me-4 max-h-10" href="{{ route('permissions.index') }}" wire:navigate>
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                {{ __('Ubah Data Permission') }}
            </h2>
        </header>

        <div class="flex items-center justify-between">
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                {{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
            </p>

            <livewire:handler.permissions.delete :id="$id" />
        </div>

        <livewire:handler.permissions.update :id="$id" />

    </div>
@endsection
