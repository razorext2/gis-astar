@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex w-full flex-col gap-4 rounded-xl border border-zinc-200 p-2 shadow-md dark:border-zinc-800 dark:shadow-none md:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <h2 class="w-full text-lg font-semibold text-gray-900 dark:text-white">Peta Penyebaran Staff Operasional</h2>

        @livewire('handler.route.all-employees')
    </div>
@endsection
