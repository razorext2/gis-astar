{{-- Goal: Show event details, stats, visitor graph, and participant table, Livewire: big-event-participant-table, chart.participant-visitor-graph, Alpine: None --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="space-y-4 pb-20">
        {{-- Header & Info Card --}}
        <div
            class="relative overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            {{-- Decorative background --}}
            <div
                class="pointer-events-none absolute inset-0 bg-gradient-to-br from-red-600/5 via-transparent to-transparent">
            </div>

            <div class="relative p-4 sm:p-6">
                {{-- Action Header --}}
                <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                    <x-button.danger href="{{ route('event.index') }}" class="max-h-10 w-fit shrink-0" wire:navigate
                        id="back-button">
                        <x-slot name="icon">
                            <x-icons.angle-left class="h-5 w-5" />
                        </x-slot>
                    </x-button.danger>

                    <div class="flex items-center gap-2">
                        <span class="flex h-3 w-3 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.4)]"></span>
                        <span class="text-xs font-black uppercase tracking-widest text-zinc-400 dark:text-zinc-500">Event
                            Details</span>
                    </div>
                </div>

            {{-- Event Hero Section --}}
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div class="flex-1">
                    <h1 class="text-3xl font-black tracking-tight text-zinc-900 dark:text-white sm:text-4xl">
                        {{ ucwords($event->name) }}
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-relaxed text-zinc-500 dark:text-zinc-400">
                        {{ $event->description }}
                    </p>
                </div>
            </div>

            {{-- Bento Info Grid --}}
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Location --}}
                <div
                    class="rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 transition-colors hover:bg-white dark:border-zinc-800 dark:bg-zinc-950/20 dark:hover:bg-zinc-800/50">
                    <div
                        class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">
                        <x-icons.map-pin class="h-5 w-5" />
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-zinc-400 dark:text-zinc-500">Lokasi
                        Event</p>
                    <p class="mt-1 font-bold text-zinc-900 dark:text-white">{{ $event->location }}</p>
                </div>

                {{-- Date --}}
                <div
                    class="rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 transition-colors hover:bg-white dark:border-zinc-800 dark:bg-zinc-950/20 dark:hover:bg-zinc-800/50">
                    <div
                        class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                        <x-icons.calendar class="h-5 w-5" />
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-zinc-400 dark:text-zinc-500">Periode
                    </p>
                    <p class="mt-1 line-clamp-1 font-bold text-zinc-900 dark:text-white">
                        {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d M') }} -
                        {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d M Y') }}
                    </p>
                </div>

                {{-- Created At --}}
                <div
                    class="rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 transition-colors hover:bg-white dark:border-zinc-800 dark:bg-zinc-950/20 dark:hover:bg-zinc-800/50">
                    <div
                        class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                        <x-icons.plus class="h-5 w-5" />
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-zinc-400 dark:text-zinc-500">
                        Ditambahkan</p>
                    <p class="mt-1 font-bold text-zinc-900 dark:text-white">
                        {{ $event->created_at->translatedFormat('d M Y') }}</p>
                </div>

                {{-- Updated At --}}
                <div
                    class="rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 transition-colors hover:bg-white dark:border-zinc-800 dark:bg-zinc-950/20 dark:hover:bg-zinc-800/50">
                    <div
                        class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400">
                        <x-icons.clockwise class="h-5 w-5" />
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-zinc-400 dark:text-zinc-500">
                        Pembaruan</p>
                    <p class="mt-1 font-bold text-zinc-900 dark:text-white">{{ $event->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics & Graph Section --}}
    <div class="grid gap-6 lg:grid-cols-1">
        <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 sm:p-6">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-black tracking-tight text-zinc-900 dark:text-white">Grafik Visitor</h3>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total partisipan & pengunjung harian
                    </p>
                </div>
                <div class="rounded-full bg-red-100 p-2 text-red-600 dark:bg-red-900/30 dark:text-red-400">
                    <x-icons.chart class="h-5 w-5" stroke-width="2.5" />
                </div>
            </div>
            <div class="relative min-h-[300px] w-full">
                <livewire:chart.participant-visitor-graph :event_id="$event->id" />
            </div>
        </div>
    </div>

    {{-- Participants Section --}}
    <div class="rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="border-b border-zinc-200 p-4 dark:border-zinc-800 sm:p-6">
            <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black tracking-tight text-zinc-900 dark:text-white">Daftar Partisipan</h2>
                    <p class="mt-1 text-sm font-medium text-zinc-500 dark:text-zinc-400">Kelola individu yang terdaftar
                        pada event ini</p>
                </div>

                {{-- Form Create (Inline/Modal Trigger) --}}
                <livewire:handler.big-event-participant.create :big_event_id="$event->id" />
            </div>

            {{-- Table Component --}}
            <div class="overflow-hidden">
                <livewire:big-event-participant-table :id="$event->id" />
            </div>
        </div>
    </div>
    </div>
@endsection
