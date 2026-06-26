{{-- Goal: Display route timeline map for collector, Livewire: handler.route.collector, Alpine: - --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex flex-col gap-2 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">

        <div class="flex items-center gap-x-4">
            <x-button.danger href="{{ route('routes.collector') }}" class="my-auto max-h-10" wire:navigate>
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div class="flex flex-col">
                <div class="flex items-center gap-x-2">
                    <span class="flex items-center gap-2 text-xl font-semibold text-gray-900 dark:text-white">
                        Laporan rute {{ $pegawai->full_name }}
                    </span>
                    <x-dashboard.badge-inactive :is_active="$pegawai->userRelasi?->is_active ?? true" />
                </div>

                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                    Kamu dapat melihat detail rute harian <i class="font-semibold not-italic">{{ $pegawai->full_name }}</i>
                    dihalaman ini.
                </p>
            </div>
        </div>

        @livewire('handler.route.collector', ['kode_pegawai' => $pegawai->kode_pegawai])

    </div>
@endsection
