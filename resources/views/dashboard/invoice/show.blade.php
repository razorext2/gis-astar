@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid w-full grid-cols-1 gap-4">

        <div class="flex items-center gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            @php
                $currentRoute = request()->route()->getName();
                $routePrefix = Str::beforeLast($currentRoute, '.');
            @endphp

            <x-button.danger wire:navigate href="{{ route($routePrefix . '.index') }}" class="max-h-10">
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Riwayat Status Invoice
                </span>

                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                    Berikut adalah riwayat status invoice
                </p>
            </div>

        </div>

        <livewire:handler.invoice.show :id="$id" />
    </div>

    @push('script')
        @vite('resources/js/pages/invoice/detail.js')
    @endpush
@endsection
