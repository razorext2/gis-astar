@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="flex flex-col">
        {{-- Greetings Section --}}
        <div class="mb-4">
            @livewire('utils.greetings')
        </div>

        <div class="mb-4 flex flex-col items-stretch lg:grid lg:grid-cols-3 lg:gap-x-4">

            <form id="attend-in" action="{{ route('attendanceIn.index') }}"></form>
            <form id="attend-out" action="{{ route('attendanceOut.index') }}"></form>

            <!-- Chart Section -->
            <div
                class="col-span-2 mb-4 flex h-full flex-col rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md dark:border-zinc-800 dark:bg-dark-primary dark:shadow-none md:p-6 lg:mb-0">
                <div class="mb-5 flex items-start justify-between">
                    <div>
                        <p class="mb-1 text-3xl font-black tracking-tight text-zinc-900 dark:text-white">
                            {{ $yearNow }}
                        </p>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                            Menampilkan data 7 hari kebelakang
                        </p>
                    </div>
                    <div
                        class="flex items-center rounded-lg bg-red-50 px-3 py-1 text-center text-sm font-bold text-red-700 dark:bg-red-700/10 dark:text-red-500">
                        {{ $formattedDateRange }}
                    </div>
                </div>

                {{-- Livewire Chart --}}
                <div class="relative h-[340px] w-full overflow-hidden px-1 py-4 lg:h-full lg:flex-1">
                    <livewire:chart.line />
                </div>

                <div class="mt-4 border-t border-zinc-100 pt-5 dark:border-zinc-800">
                    <div class="flex flex-wrap items-center justify-between gap-3">

                        <x-button.primary form="attend-in" type="submit"
                            class="flex-1 justify-center bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 sm:flex-none">
                            <x-slot name="icon">
                                <x-icons.angle-right class="icon h-5 w-5 text-white" />
                            </x-slot>
                            Absen Masuk
                        </x-button.primary>

                        <x-button.danger form="attend-out" type="submit"
                            class="flex-1 justify-center !bg-red-700 text-white hover:!bg-red-800 dark:!bg-red-700 dark:hover:!bg-red-800 sm:flex-none">
                            <x-slot name="icon">
                                <x-icons.angle-left class="icon h-5 w-5 text-white" />
                            </x-slot>
                            Absen Keluar
                        </x-button.danger>
                    </div>
                </div>
            </div>
            <!-- End Chart Section -->

            <!-- Notifications Section -->
            <div class="grid grid-cols-1 gap-y-4">

                {{-- Notification In --}}
                <div
                    class="flex h-[340px] flex-col rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md dark:border-zinc-800 dark:bg-dark-primary dark:shadow-none">

                    <div class="mb-4 flex items-center justify-between border-b border-zinc-100 pb-3 dark:border-zinc-800">
                        <div class="flex items-center gap-2">
                            <div class="h-2 w-2 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                            <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-300">
                                Absen Masuk
                            </p>
                        </div>
                        <p class="text-xs font-medium text-zinc-400 dark:text-zinc-500">
                            {{ \Carbon\Carbon::today()->locale('id')->isoFormat('D MMMM') }}
                        </p>
                    </div>

                    <ul class="custom-scrollbar flex-1 space-y-3 overflow-y-auto pr-2 font-sans"
                        aria-labelledby="dropdownUsersButton">
                        @if ($attendance_today->isNotEmpty())
                            @foreach ($attendance_today as $at)
                                <li class="group">
                                    <div
                                        class="flex items-start rounded-xl bg-zinc-50 p-3 transition-colors hover:bg-blue-50 dark:bg-dark-secondary dark:hover:bg-blue-900/10">
                                        <img class="me-3 mt-0.5 h-8 w-8 rounded-full border border-zinc-200 object-cover shadow-sm dark:border-zinc-700"
                                            src="{{ $at->user?->profile_pic ? asset('storage/profile-pictures/' . $at->user->profile_pic) : asset('assets/img/profile-picture-5.jpg') }}"
                                            alt="{{ $at->pegawaiRelasi->full_name ?? 'User' }}" loading="lazy"
                                            onerror="this.src = '{{ asset('assets/img/noImage.webp') }}'">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-zinc-800 dark:text-white">
                                                {{ $at->pegawaiRelasi->full_name ?? 'Pegawai N/A' }}
                                            </span>
                                            <span class="mt-1 flex flex-col gap-1 text-xs text-zinc-500 dark:text-zinc-400">
                                                <span>Melakukan absensi masuk pada pukul</span>
                                                <b
                                                    class="w-fit rounded bg-blue-100 px-1.5 py-0.5 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                                    {{ \Carbon\Carbon::parse($at->jam_masuk)->format('H:i') }}
                                                </b>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="flex h-full items-center justify-center">
                                <span class="text-center text-sm font-medium italic text-zinc-400 dark:text-zinc-500">
                                    Belum ada absensi masuk hari ini
                                </span>
                            </li>
                        @endif
                    </ul>
                </div>

                {{-- Notification Out --}}
                <div
                    class="flex h-[340px] flex-col rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md dark:border-zinc-800 dark:bg-dark-primary dark:shadow-none">

                    <div class="mb-4 flex items-center justify-between border-b border-zinc-100 pb-3 dark:border-zinc-800">
                        <div class="flex items-center gap-2">
                            <div
                                class="h-2 w-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)] dark:bg-red-700">
                            </div>
                            <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-300">
                                Absen Keluar
                            </p>
                        </div>
                        <p class="text-xs font-medium text-zinc-400 dark:text-zinc-500">
                            {{ \Carbon\Carbon::today()->locale('id')->isoFormat('D MMMM') }}
                        </p>
                    </div>

                    <ul class="custom-scrollbar flex-1 space-y-3 overflow-y-auto pr-2 font-sans"
                        aria-labelledby="dropdownUsersButton">
                        @if ($attendance_out_today->isNotEmpty())
                            @foreach ($attendance_out_today as $at)
                                <li class="group">
                                    <div
                                        class="flex items-start rounded-xl bg-zinc-50 p-3 transition-colors hover:bg-red-50 dark:bg-dark-secondary dark:hover:bg-red-900/10">
                                        <img class="me-3 mt-0.5 h-8 w-8 rounded-full border border-zinc-200 object-cover shadow-sm dark:border-zinc-700"
                                            src="{{ $at->user?->profile_pic ? asset('storage/profile-pictures/' . $at->user->profile_pic) : asset('assets/img/profile-picture-5.jpg') }}"
                                            alt="{{ $at->pegawaiRelasi->full_name ?? 'User' }}" loading="lazy"
                                            onerror="this.src = '{{ asset('assets/img/noImage.webp') }}'">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-zinc-800 dark:text-white">
                                                {{ $at->pegawaiRelasi->full_name ?? 'Pegawai N/A' }}
                                            </span>
                                            <span class="mt-1 flex flex-col gap-1 text-xs text-zinc-500 dark:text-zinc-400">
                                                <span>Melakukan absensi keluar pada pukul</span>
                                                <b
                                                    class="w-fit rounded bg-red-100 px-1.5 py-0.5 text-red-700 dark:bg-red-900/30 dark:text-red-500">
                                                    {{ \Carbon\Carbon::parse($at->jam_keluar)->format('H:i') }}
                                                </b>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="flex h-full items-center justify-center">
                                <span class="text-center text-sm font-medium italic text-zinc-400 dark:text-zinc-500">
                                    Belum ada absensi keluar hari ini
                                </span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <!-- End Notifications Section -->
        </div>
    @endsection
