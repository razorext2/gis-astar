@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="space-y-6 pb-20">
        {{-- Header & Info Card --}}
        <div
            class="relative overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            {{-- Decorative background --}}
            <div
                class="pointer-events-none absolute inset-0 bg-gradient-to-br from-red-600/5 via-transparent to-transparent">
            </div>

            <div class="relative p-6 sm:p-8">
                {{-- Action Header --}}
                <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                    <x-button.link wire:navigate href="{{ route('event.index') }}"
                        class="group border border-red-200 bg-red-50/50 px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-100 hover:shadow-md hover:shadow-red-500/10 dark:border-red-900/30 dark:bg-red-950/20 dark:text-red-400 dark:hover:bg-red-900/30">
                        <x-icons.angle-right
                            class="h-4 w-4 rotate-180 text-red-500 transition-transform group-hover:-translate-x-0.5" />
                    </x-button.link>

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
                        class="rounded-2xl border border-zinc-200 bg-zinc-50/50 p-4 transition-colors hover:bg-white dark:border-zinc-800 dark:bg-zinc-950/20 dark:hover:bg-zinc-800/50">
                        <div
                            class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-zinc-400 dark:text-zinc-500">Lokasi
                            Event</p>
                        <p class="mt-1 font-bold text-zinc-900 dark:text-white">{{ $event->location }}</p>
                    </div>

                    {{-- Date --}}
                    <div
                        class="rounded-2xl border border-zinc-200 bg-zinc-50/50 p-4 transition-colors hover:bg-white dark:border-zinc-800 dark:bg-zinc-950/20 dark:hover:bg-zinc-800/50">
                        <div
                            class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
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
                        class="rounded-2xl border border-zinc-200 bg-zinc-50/50 p-4 transition-colors hover:bg-white dark:border-zinc-800 dark:bg-zinc-950/20 dark:hover:bg-zinc-800/50">
                        <div
                            class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-zinc-400 dark:text-zinc-500">
                            Ditambahkan</p>
                        <p class="mt-1 font-bold text-zinc-900 dark:text-white">
                            {{ $event->created_at->translatedFormat('d M Y') }}</p>
                    </div>

                    {{-- Updated At --}}
                    <div
                        class="rounded-2xl border border-zinc-200 bg-zinc-50/50 p-4 transition-colors hover:bg-white dark:border-zinc-800 dark:bg-zinc-950/20 dark:hover:bg-zinc-800/50">
                        <div
                            class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
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
            <div
                class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 sm:p-8">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-black tracking-tight text-zinc-900 dark:text-white">Grafik Visitor</h3>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total partisipan & pengunjung harian
                        </p>
                    </div>
                    <div class="rounded-full bg-red-100 p-2 text-red-600 dark:bg-red-900/30 dark:text-red-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                </div>
                <div class="relative min-h-[300px] w-full">
                    @livewire('chart.participant-visitor-graph', ['event_id' => $event->id])
                </div>
            </div>
        </div>

        {{-- Participants Section --}}
        <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="border-b border-zinc-200 p-6 dark:border-zinc-800 sm:p-8">
                <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-black tracking-tight text-zinc-900 dark:text-white">Daftar Partisipan</h2>
                        <p class="mt-1 text-sm font-medium text-zinc-500 dark:text-zinc-400">Kelola individu yang terdaftar
                            pada event ini</p>
                    </div>

                    {{-- Form Create (Inline/Modal Trigger) --}}
                    @livewire('handler.big-event-participant.create', ['big_event_id' => $event->id])
                </div>

                {{-- Table Component --}}
                <div class="overflow-hidden">
                    @livewire('big-event-participant-table', ['id' => $event->id])
                </div>
            </div>
        </div>
    </div>
@endsection
