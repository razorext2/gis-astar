@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="flex flex-col gap-5">
        {{-- Greetings --}}
        <livewire:utils.greetings />

        {{-- All Menu (Mobile only) --}}
        <div class="rounded-xl border border-zinc-200 p-5 shadow-sm dark:border-zinc-800 md:hidden lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="mb-4 flex items-center gap-2 border-b border-zinc-200 pb-4 dark:border-zinc-800">
                <div class="h-2 w-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]"></div>
                <h3 class="text-base font-bold tracking-wide text-zinc-800 dark:text-white">Menu</h3>
            </div>
            <div class="mt-1">
                <x-drawer.dashboard-menu />
            </div>
        </div>
    </div>
@endsection
