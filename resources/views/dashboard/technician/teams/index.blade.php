@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'technicianteam'])

    <div
        class="rounded-xl border border-gray-200 bg-white p-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none md:p-6">
        <div class="flex flex-row justify-between">
            <div>
                <h2 class="w-full text-lg font-semibold text-gray-900 dark:text-white">Tim teknisi</h2>
                <p class="text-md text-gray-600 dark:text-gray-300"> Berikut adalah data tim teknisi </p>
            </div>

            @can('team-create')
                <div>
                    <x-button.link wire:navigate
                        class="ring-1 ring-blue-700 hover:bg-blue-300 dark:bg-blue-800 dark:text-white dark:ring-gray-700 dark:hover:bg-blue-900"
                        href="{{ route('teams.create') }}">
                        <x-slot name="icon">
                            <x-icons.plus class="icon h-6 w-6 text-blue-500 dark:text-white" />
                        </x-slot>
                        Tim
                    </x-button.link>
                </div>
            @endcan

        </div>

        {{-- livewire index component --}}
        @livewire('handler.teams.index')
    </div>
@endsection
