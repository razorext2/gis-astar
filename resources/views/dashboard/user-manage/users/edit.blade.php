@extends('dashboard.layoutsDash.app')

@section('content')
    <div class="w-full space-y-6 xl:w-8/12 2xl:w-6/12">
        <div
            class="rounded-2xl bg-white/80 p-6 shadow-xl ring-1 ring-gray-200 backdrop-blur-md dark:bg-dark-primary/80 dark:shadow-none dark:ring-gray-800 lg:p-8">
            <div class="max-w-4xl">
                <header class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('users.index') }}"
                            class="group inline-flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600 transition-all hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                            <x-icons.angle-left class="h-6 w-6 transition-transform group-hover:-translate-x-1" />
                        </a>
                        <div>
                            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ __('Edit Data User') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Kelola profil, akun, dan peran akses pengguna di bawah ini.') }}
                            </p>
                        </div>
                    </div>
                </header>

                <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-2 lg:space-y-4">
                    @csrf
                    @method('put')

                    <!-- Section: Informasi Dasar -->
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                            <x-input.basic name="name" id="name" :value="$user->name" placeholder="John Doe"
                                required />
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Alamat Email</label>
                            <x-input.basic name="email" id="email" type="email" :value="$user->email"
                                placeholder="john@example.com" required />
                        </div>
                    </div>

                    <!-- Section: Status & Keamanan -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Status Akun</label>
                            <select name="is_active" id="is_active"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-blue-500">
                                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="{{ $user->is_active ? 'hidden' : '' }} space-y-2" id="deactivation_reason_container">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Alasan Nonaktif</label>
                            <x-input.textarea name="deactivation_reason" id="deactivation_reason" rows="1"
                                placeholder="Contoh: Resign atau Cuti">
                                {{ $user->deactivation_reason }}
                            </x-input.textarea>
                        </div>
                    </div>

                    <!-- Section: Ganti Password -->
                    <div
                        class="rounded-2xl border border-blue-100 bg-blue-50/30 p-6 dark:border-blue-900/30 dark:bg-blue-900/10">
                        <h3
                            class="mb-4 flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-blue-600 dark:bg-blue-400"></span>
                            Ganti Password (Opsional)
                        </h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Password Baru</label>
                                <x-input.basic name="password" id="password" type="password" placeholder="••••••••" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Konfirmasi
                                    Password</label>
                                <x-input.basic name="confirm-password" id="confirm-password" type="password"
                                    placeholder="••••••••" />
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-blue-500/80">Kosongkan jika tidak ingin mengubah password.</p>
                    </div>

                    <!-- Section: Roles -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Roles / Peran Akses</label>
                        <div class="group relative">
                            <select name="roles[]" id="roles" multiple="multiple"
                                class="block w-full rounded-xl border border-gray-200 bg-white p-3 text-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                @foreach ($roles as $value => $label)
                                    <option value="{{ $value }}" {{ isset($userRole[$value]) ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-[10px] italic text-gray-400 sm:text-xs">Tekan Ctrl (Windows) atau Cmd (Mac) untuk
                            memilih lebih dari satu peran.</p>
                    </div>

                    <div class="flex items-center">
                        <x-button.primary id="store" type="submit" class="w-fit">
                            <x-slot name="icon">
                                <x-icons.checklist-stepper class="h-5 w-5" />
                            </x-slot>
                            <span>Update User</span>
                        </x-button.primary>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    @vite('resources/js/pages/user/edit.js')
@endpush
