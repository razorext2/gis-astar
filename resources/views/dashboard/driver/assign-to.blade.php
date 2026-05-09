@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full space-y-6">
        <div
            class="grid gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none sm:p-6">
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

            @livewire('handler.driver.assign-to', ['id' => $id])
        </div>
    </div>
@endsection
