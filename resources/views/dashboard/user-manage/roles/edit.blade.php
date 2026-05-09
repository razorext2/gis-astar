@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-fit space-y-6">
        <div
            class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none sm:p-6">
            <div class="max-w-2xl">
                <header class="flex items-center">
                    <x-button.danger class="my-auto me-4 max-h-10" href="{{ route('roles.index') }}" wire:navigate>
                        <x-icons.angle-left class="h-5 w-5" />
                    </x-button.danger>

                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
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
