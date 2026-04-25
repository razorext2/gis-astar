@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full space-y-6">
        <div
            class="grid gap-4 rounded-xl bg-white p-4 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 sm:p-6">
            <div class="w-full">
                <header class="flex flex-row gap-x-4">

                    <div class="max-w-xs">
                        <x-button.link class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white"
                            href="{{ route('driver.index') }}" wire:navigate>
                            <x-slot name="icon">
                                <x-icons.angle-right class="h-6 w-6 text-red-500 dark:text-white" />
                            </x-slot>
                            Kembali
                        </x-button.link>
                    </div>

                    <h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
                        {{ __('Tambah Laporan Driver') }}
                    </h2>

                </header>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    {{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
                </p>
            </div>

            @livewire('handler.driver.assign-add')
        </div>
    </div>
@endsection
