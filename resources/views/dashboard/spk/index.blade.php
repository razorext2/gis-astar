{{-- Goal: Show SPK index page with Livewire wrapper component, Livewire: App\Livewire\Handler\Spk\IndexTabs, Alpine: false --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- carousel for cards --}}
    <livewire:components.card type="spk" />

    <div class="relative space-y-4">
        <div
            class="flex flex-col rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <span class="text-xl font-semibold text-gray-900 dark:text-white">
                Manajemen SPK
            </span>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Kamu dapat menambah invoice, mengubah nama invoice, dan menghapus data Manajemen SPK adalah feature yang
                diperuntukkan untuk Marketing dalam mengelola data SPK Customer.
            </p>
        </div>

        @can('spk-create')
            <x-button.success href="{{ route('spk.create') }}" class="max-w-fit" id="add-button">
                <x-slot name="icon">
                    <x-icons.plus class="h-5 w-5" />
                </x-slot>
                SPK
            </x-button.success>
        @endcan

        <livewire:handler.spk.index-tabs />
    </div>
@endsection
