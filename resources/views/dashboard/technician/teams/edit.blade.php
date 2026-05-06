@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="w-full rounded-2xl bg-white/60 p-4 shadow-sm ring-1 ring-zinc-200/60 dark:bg-dark-primary/60 dark:ring-white/10 md:p-6">

        <div
            class="flex flex-col justify-between gap-4 border-b border-zinc-200 pb-4 dark:border-zinc-800 sm:flex-row sm:items-center">
            <div>
                <h2 class="w-full text-xl font-bold text-gray-900 dark:text-white lg:text-2xl">Pengaturan Tim</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pembaruan formasi dan struktur kepemimpinan tim.</p>
            </div>

            <div>
                <x-button.danger class="my-auto me-4 max-h-10" wire:navigate href="{{ route('teams.index') }}">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>
            </div>
        </div>

        {{-- livewire edit component --}}
        @livewire('handler.teams.edit', ['team_code' => $team_code])
    </div>
@endsection
