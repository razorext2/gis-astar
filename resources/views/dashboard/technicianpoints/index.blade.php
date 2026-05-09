@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="w-full rounded-xl bg-white/60 p-4 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 md:p-6">

        <header class="mb-4 flex items-center justify-between">
            <p class="text-lg font-semibold text-gray-900 dark:text-white lg:text-xl">
                Riwayat Poin Masuk
            </p>

            @can('point-redeem')
                <x-button.link
                    class="text-sm text-green-500 ring-1 ring-green-500 hover:bg-green-300 dark:bg-green-800 md:text-base"
                    href="{{ route('points.redeem', ['step' => 1]) }}" wire:navigate>
                    <x-slot name="icon">
                        <x-icons.plus class="icon h-6 w-6 text-green-500 dark:text-white" />
                    </x-slot>
                    Redeem
                </x-button.link>
            @endcan
        </header>

        @livewire('handler.point.technician.index')
    </div>
@endsection
