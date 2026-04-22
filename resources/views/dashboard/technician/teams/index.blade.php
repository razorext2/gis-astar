@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'technicianteam'])

    <div
        class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-200 backdrop-blur-xl dark:bg-dark-primary dark:ring-white/10 md:p-6 lg:p-8">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h2 class="w-full text-xl font-bold text-gray-900 dark:text-white lg:text-2xl">Tim Teknisi</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400"> Berikut adalah data tim teknisi </p>
            </div>

            @can('team-create')
                <div>
                    <x-button.primary wire:navigate class="shadow-primary/20 px-5 transition-all hover:shadow-lg"
                        href="{{ route('teams.create') }}" as="a">
                        <x-slot name="icon">
                            <x-icons.plus class="mr-2 h-5 w-5" />
                        </x-slot>
                        Bentuk Tim Baru
                    </x-button.primary>
                </div>
            @endcan

        </div>

        {{-- livewire index component --}}
        @livewire('handler.teams.index')
    </div>
@endsection
