@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="grid grid-cols-1 gap-2 rounded-xl border border-zinc-200 bg-white/60 p-2 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:gap-4 lg:p-6">

        <div class="flex flex-col">
            <span class="text-xl font-semibold text-gray-900 dark:text-white">
                Preview Laporan
            </span>

            <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                Berikut adalah preview dari laporan harian Teknisi/Mekanik, mohon dicek sebelum memberikan tanda tangan!
            </p>
        </div>

        @php
            $route = request()->route()->getName();
            $redirectRoute = null;

            if ($route === 'report.general.customer-assignment') {
                $redirectRoute = route('report.general.daily', ['id' => $id]);
            } elseif ($route === 'daily-report.daily.customer-assignment') {
                $redirectRoute = route('daily-report.daily', ['id' => $id]);
            }
        @endphp

        <div>
            <x-button.link href="{{ $redirectRoute }}"
                class="flex w-fit items-center gap-2 ring-1 ring-red-600 dark:bg-red-800 dark:text-white" wire:navigate
                id="back-button">
                <x-slot name="icon">
                    <x-icons.angle-left class="h-5 w-5 text-red-500 dark:text-white" />
                </x-slot>
                Kembali
            </x-button.link>
        </div>

        <div class="flex flex-col gap-2 lg:gap-4">
            @livewire('handler.spk.daily-report.signature', ['id' => $id])
        </div>

    </div>
@endsection
