@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid w-full grid-cols-1 gap-4">

        <div
            class="flex flex-row items-center gap-4 rounded-xl bg-white p-2 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 lg:p-6">

            <div class="max-w-xs">
                @php
                    $currentRoute = request()->route()->getName();
                    $routePrefix = Str::beforeLast($currentRoute, '.');
                @endphp

                <x-button.danger wire:navigate href="{{ route($routePrefix . '.index') }}">
                    <x-slot name="icon">
                        <x-icons.angle-left class="h-6 w-6" />
                    </x-slot>
                    {{ __('Kembali') }}
                </x-button.danger>
            </div>

            <div class="flex flex-col gap-1.5">
                <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                    Riwayat Status Invoice
                </span>

                <p class="text-base text-gray-600 dark:text-gray-400">
                    Berikut adalah riwayat status invoice
                </p>

            </div>

        </div>

        @livewire('handler.invoice.show', ['id' => $id])
    </div>

    @push('script')
        @vite('resources/js/pages/invoice/detail.js')
    @endpush
@endsection
