@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="w-full rounded-2xl bg-white/60 p-4 shadow-sm ring-1 ring-gray-200/60 dark:bg-dark-primary/60 dark:ring-white/10 md:p-6">

        <div
            class="flex flex-col justify-between gap-4 border-b border-gray-100 pb-4 dark:border-gray-800 sm:flex-row sm:items-center">
            <div>
                <h2 class="w-full text-xl font-bold text-gray-900 dark:text-white lg:text-2xl">Pengaturan Tim</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pembaruan formasi dan struktur kepemimpinan tim.</p>
            </div>

            <div>
                <x-button.danger wire:navigate href="{{ route('teams.index') }}" as="a">
                    <x-slot name="icon">
                        <svg class="mr-1 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14M5 12l4-4m-4 4 4 4" />
                        </svg>
                    </x-slot>
                    Kembali
                </x-button.danger>
            </div>
        </div>

        {{-- livewire edit component --}}
        @livewire('handler.teams.edit', ['team_code' => $team_code])
    </div>
@endsection
