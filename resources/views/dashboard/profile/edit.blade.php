@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- Hero Profile Header --}}
    <div class="relative mb-6 rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        {{-- Decorative gradient background --}}
        <div class="pointer-events-none absolute inset-0 rounded-3xl bg-gradient-to-br from-red-600/10 via-transparent to-transparent dark:from-red-900/20"></div>
        <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-red-500/5 blur-3xl"></div>

        <div class="relative flex flex-col gap-6 p-6 sm:flex-row sm:items-end sm:p-8">
            {{-- Avatar Section --}}
            <div class="group relative w-fit" x-data="{ open: false }">
                <div class="relative">
                    <img class="h-28 w-28 rounded-2xl border-4 border-white object-cover shadow-xl dark:border-zinc-800 sm:h-32 sm:w-32"
                        src="{{ auth()->user()->profile_pic ? asset('storage/profile-pictures/' . auth()->user()->profile_pic) : asset('assets/img/profile-picture-5.jpg') }}"
                        alt="{{ auth()->user()->name }}" onerror="this.src = '{{ asset('assets/img/noImage.webp') }}'">
                    {{-- Edit overlay --}}
                    <button @click="open = !open"
                        class="absolute inset-0 flex items-center justify-center rounded-2xl bg-zinc-950/50 opacity-0 transition-opacity duration-200 group-hover:opacity-100"
                        type="button">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
                {{-- Uploader panel --}}
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="absolute left-0 top-36 z-20 w-72 rounded-2xl border border-zinc-200 bg-white p-4 shadow-xl dark:border-zinc-700 dark:bg-zinc-900">
                    @livewire('utils.profile-picture-uploader')
                </div>
            </div>

            {{-- User Info --}}
            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-2">
                    <h1 class="text-2xl font-black tracking-tight text-zinc-900 dark:text-white sm:text-3xl">
                        {{ auth()->user()->name }}
                    </h1>
                    <span
                        class="rounded-full bg-red-100 px-3 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-900/30 dark:text-red-400">
                        {{ auth()->user()->roles->pluck('name')->implode(', ') }}
                    </span>
                </div>

                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ auth()->user()->email }}</p>

                @if (auth()->user()->kode_pegawai)
                    <div class="mt-3">
                        @livewire('handler.profile.bio-edit')
                    </div>
                @endif

                <div class="mt-3">
                    @livewire('inspire-component')
                </div>
            </div>
        </div>
    </div>

    {{-- Digital Signature --}}
    <div class="mb-6">
        @livewire('utils.digital-signature')
    </div>

    {{-- Form Cards --}}
    <div class="grid gap-4 lg:grid-cols-2">

        {{-- Update Profile Info --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 sm:p-8">
            @include('dashboard.profile.partials.update-profile-information-form')
        </div>

        {{-- Update Password --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 sm:p-8">
            @include('dashboard.profile.partials.update-password-form')
        </div>

        {{-- Delete Account --}}
        <div
            class="col-span-full rounded-2xl border border-red-200 bg-red-50/80 p-6 shadow-sm dark:border-red-900/30 dark:bg-red-950/80 sm:p-8">
            @include('dashboard.profile.partials.delete-user-form')
        </div>

    </div>
@endsection
