{{-- Goal: Add Golongan Form Page, Livewire: -, Alpine: - --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full">
        <form class="mt-4" action="{{ route('golongan.store') }}" method="POST">
            @csrf
            <div class="w-full md:max-w-lg">
                <div
                    class="w-full rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none sm:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                    <div class="max-w-xl">
                        <header class="flex items-center">
                            <x-button.danger href="{{ route('golongan.index') }}" class="my-auto me-4 max-h-10"
                                wire:navigate>
                                <x-icons.angle-left class="h-5 w-5" />
                            </x-button.danger>

                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ __('Tambah Data Golongan') }}
                            </h2>
                        </header>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                            {{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
                        </p>

                        <div class="my-4 grid gap-6 sm:gap-6 md:grid-cols-2">
                            <div class="w-full">
                                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                    for="nama_golongan">Nama
                                    Golongan</label>
                                <input
                                    class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-zinc-200 p-2.5 text-sm text-gray-900"
                                    id="nama_golongan" name="nama_golongan" type="text" placeholder="Nama Golongan"
                                    required="">
                            </div>
                            <div class="w-full">
                                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                    for="alias">Alias</label>
                                <input
                                    class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-zinc-200 bg-white p-2.5 text-sm text-gray-900"
                                    id="alias" name="alias" type="text" placeholder="Alias" required="">
                            </div>
                        </div>

                        <header class="flex items-center">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ __('Atur Jadwal') }}
                            </h2>
                        </header>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                            {{ __('Atur jam masuk dan jam keluar untuk setiap hari.') }}
                        </p>

                        <div class="rounded-lg sm:my-4" id="jadwal">
                            <!-- Looping for each day -->
                            @php
                                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            @endphp
                            @foreach ($days as $day)
                                <div class="w-full border-b border-b-gray-500">
                                    <div class="grid gap-2 py-4 sm:flex md:gap-4">

                                        <div class="w-20 sm:flex-none">
                                            <h3
                                                class="text-md mt-0 font-semibold text-gray-700 dark:text-white md:mt-9">
                                                {{ $day }}</h3>
                                        </div>

                                        <div class="w-full sm:flex-1">
                                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                                for="jam_masuk_{{ strtolower($day) }}">Jam
                                                Masuk</label>
                                            <input
                                                class="focus:ring-primary-600 block w-full rounded-lg border border-zinc-200 p-2.5 text-sm text-gray-900"
                                                id="jam_masuk_{{ strtolower($day) }}"
                                                name="jam_masuk_{{ strtolower($day) }}" type="time" required>
                                        </div>

                                        <div class="w-full sm:flex-1">
                                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                                for="jam_keluar_{{ strtolower($day) }}">Jam
                                                Keluar</label>
                                            <input
                                                class="focus:ring-primary-600 block w-full rounded-lg border border-zinc-200 p-2.5 text-sm text-gray-900"
                                                id="jam_keluar_{{ strtolower($day) }}"
                                                name="jam_keluar_{{ strtolower($day) }}" type="time" required>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 flex items-center">
                            <x-button.success type="submit">
                                {{ __('Submit') }}
                                <x-slot name="icon">
                                    <x-icons.checklist-stepper class="h-5 w-5" />
                                </x-slot>
                            </x-button.success>
                        </div>
                    </div>
            </div>
        </form>
    </div>
@endsection
