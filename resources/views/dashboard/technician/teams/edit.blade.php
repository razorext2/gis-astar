@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="w-full rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md dark:border-zinc-800 dark:bg-dark-primary/60 md:p-6">

        <div class="flex gap-4 border-b border-zinc-200 pb-4 dark:border-zinc-800 sm:flex-row sm:items-center">
            <x-button.danger class="my-auto max-h-10" wire:navigate href="{{ route('teams.index') }}">
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div>
                <h2 class="w-full text-xl font-bold text-gray-900 dark:text-white lg:text-2xl">Pengaturan Tim</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pembaruan formasi dan struktur kepemimpinan tim.</p>
            </div>
        </div>

        {{-- livewire edit component --}}
        @livewire('handler.teams.edit', ['team_code' => $team_code])
    </div>
@endsection
