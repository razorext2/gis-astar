@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- Summary Cards --}}
    @livewire('components.card', ['type' => 'servermonitor'])

    <div
        class="mb-4 rounded-2xl border border-white/60 bg-white/60 p-4 shadow-lg shadow-zinc-200/50 backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-black/30 md:p-6">

        <!-- Header -->
        <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
            <div>
                <h1 class="flex items-center gap-2 text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                    <x-icons.computer class="h-7 w-7 text-red-500" />
                    Server Overview
                </h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Pantau penggunaan resource server secara terpusat.
                </p>
            </div>
            <x-button.danger @click="$dispatch('open-create-server')">
                <x-slot name="icon">
                    <x-icons.plus class="h-4 w-4" />
                </x-slot>
                Tambah Server
            </x-button.danger>
        </div>
    </div>

    @livewire('system.server-overview')
@endsection
