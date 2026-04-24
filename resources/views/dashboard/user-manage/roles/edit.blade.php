@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-fit space-y-6">
        <div
            class="rounded-xl bg-white p-4 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 sm:p-6">
            <div class="max-w-2xl">
                <header class="flex flex-row gap-x-2">
                    <x-button.link class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white"
                        href="{{ route('roles.index') }}" wire:navigate>
                        <x-slot name="icon">
                            <x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
                        </x-slot>
                        Kembali
                    </x-button.link>
                    <h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
                        {{ __('Ubah Data Role') }}
                    </h2>
                </header>

                <div class="flex items-center justify-between">

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        {{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
                    </p>

                    @livewire('handler.roles.delete', ['id' => $id])
                </div>

                @livewire('handler.roles.update', ['id' => $id])
            </div>
        </div>
    </div>
@endsection
