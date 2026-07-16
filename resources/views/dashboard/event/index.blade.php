@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-4">

        <div class="flex flex-col rounded-xl border border-zinc-200 p-2 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <span class="text-xl font-semibold text-gray-900 dark:text-white">
                Manajemen Event
            </span>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Kamu dapat menambah event, mengubah nama event, dan menghapus data event.
            </p>

        </div>

        <x-button.success href="{{ route('event.create') }}" class="max-w-fit" id="add-button" wire:navigate>
            <x-slot name="icon">
                <x-icons.plus class="h-5 w-5" />
            </x-slot>
            Tambah Event
        </x-button.success>

        <div class="rounded-xl border border-zinc-200 p-2 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <livewire:powergrid-tables.big-event-table />
        </div>
    </div>
@endsection
