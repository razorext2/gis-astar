@extends('dashboard.layoutsDash.app')

{{-- Goal: Detail view container for collector report with new header and back button, Livewire: Handler\Collect\Show --}}

@section('content')
    <div class="w-full space-y-4">
        <div
            class="flex items-center gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none sm:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <header class="flex items-center">
                <x-button.danger class="my-auto me-4 max-h-10" href="{{ route('collect.index') }}" wire:navigate>
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>

                <div>
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                        Laporan Penagihan
                    </h2>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                        Detail laporan lapangan oleh kolektor
                    </p>
                </div>
            </header>
        </div>

        <livewire:handler.collect.show :id="$data->id" />
    </div>
@endsection

@push('script')
    @vite(['resources/js/pages/collect/detail.js'])
@endpush
