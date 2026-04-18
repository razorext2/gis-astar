@extends('dashboard.layoutsDash.app')

@section('content')
    <div class="w-full space-y-6 xl:w-8/12 2xl:w-6/12">
        <div
            class="rounded-2xl bg-white/80 p-6 shadow-xl ring-1 ring-gray-200 backdrop-blur-md dark:bg-dark-primary/80 dark:shadow-none dark:ring-gray-800 lg:p-8">
            <div class="max-w-4xl">
                <header class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <x-button.link id="back-btn"
                            class="group justify-center bg-white/50 hover:bg-red-700 hover:text-white" wire:navigate
                            href="{{ route('users.index') }}">
                            <x-icons.angle-left class="h-6 w-6" />
                        </x-button.link>
                        <div>
                            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ __('Tambah Data User') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Daftarkan akun pengguna baru dengan hak akses yang sesuai.') }}
                            </p>
                        </div>
                    </div>
                </header>

                <form action="{{ route('users.store') }}" method="POST" class="space-y-2 lg:space-y-4">
                    @csrf

                    <!-- Section: Informasi Dasar -->
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                            <x-input.basic name="name" id="name" placeholder="John Doe" required />
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Alamat Email</label>
                            <x-input.basic name="email" id="email" type="email" placeholder="john@example.com"
                                required />
                        </div>
                    </div>

                    <!-- Section: Keamanan -->
                    <div
                        class="rounded-2xl border border-blue-100 bg-blue-50/30 p-6 dark:border-blue-900/30 dark:bg-blue-900/10">
                        <h3
                            class="mb-4 flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-blue-600 dark:bg-blue-400"></span>
                            Keamanan Akun
                        </h3>
                        <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Password</label>
                                <x-input.basic name="password" id="password" type="password" placeholder="••••••••"
                                    required />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Konfirmasi
                                    Password</label>
                                <x-input.basic name="confirm-password" id="confirm-password" type="password"
                                    placeholder="••••••••" required />
                            </div>
                        </div>
                    </div>

                    <!-- Section: Roles -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Roles / Peran Akses</label>
                        <div class="group relative">
                            <select name="roles[]" id="roles" multiple="multiple"
                                class="block w-full rounded-xl border border-gray-200 bg-white p-3 text-sm transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                @foreach ($roles as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-[10px] italic text-gray-400 sm:text-xs">Tekan Ctrl (Windows) atau Cmd (Mac) untuk
                            memilih lebih dari satu peran.</p>
                    </div>

                    <div class="flex items-center">
                        <x-button.primary id="store" type="submit" class="w-full sm:w-auto">
                            <x-slot name="icon">
                                <x-icons.plus class="h-5 w-5" />
                            </x-slot>
                            <span>Daftarkan User</span>
                        </x-button.primary>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
