@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="flex flex-col gap-5">

        {{-- Greetings --}}
        <div>
            @livewire('utils.greetings')
        </div>

        {{-- Schedule Card --}}
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800 lg:p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-2">
                        <div class="h-2 w-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]"></div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 dark:text-zinc-500">Jadwal
                            Kamu</p>
                    </div>
                    <h2 class="text-base font-semibold text-zinc-700 dark:text-zinc-300">
                        {{ $getDay }}, {{ now()->translatedFormat('d F Y') }}
                    </h2>
                </div>
                <div class="flex items-end gap-2">
                    @if ($getJadwal)
                        <p class="text-3xl font-black tabular-nums tracking-tight text-zinc-900 dark:text-white lg:text-4xl">
                            {{ $getJadwal->jam_masuk }}
                        </p>
                        <span class="mb-1 text-sm font-medium text-zinc-400 dark:text-zinc-500">–</span>
                        <p
                            class="text-3xl font-black tabular-nums tracking-tight text-zinc-900 dark:text-white lg:text-4xl">
                            {{ $getJadwal->jam_keluar }}
                        </p>
                    @else
                        <p class="text-lg font-medium italic text-zinc-400 dark:text-zinc-500">Tidak ada jadwal hari ini.
                        </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sales Percentage --}}
        @can('sales-create')
            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800 lg:p-6">
                <div class="mb-4 flex items-center gap-2 border-b border-zinc-100 pb-4 dark:border-zinc-800">
                    <div class="h-2 w-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]"></div>
                    <h3 class="text-base font-bold tracking-wide text-zinc-800 dark:text-white">
                        Persentase Laporan Diterima
                    </h3>
                </div>
                <div class="grid gap-3 lg:grid-cols-3">
                    <x-dashboard.plugin.percentage :label="'Laporan Sales Harian'" :total="$sales_total_daily" :approved="$sales_approved_daily" :percentage="$sales_approved_percentage_daily" />

                    <x-dashboard.plugin.percentage :label="'Laporan Sales Bulanan'" :total="$sales_total_monthly" :approved="$sales_approved_monthly" :percentage="$sales_approved_percentage_monthly" />

                    <x-dashboard.plugin.percentage :label="'Laporan Sales Total'" :total="$sales_total" :approved="$sales_approved" :percentage="$sales_approved_percentage" />
                </div>
            </div>
        @endcan

        {{-- Teknisi Report --}}
        @hasrole('Teknisi')
            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800">
                <livewire:plugin.tech-report-percentage />
            </div>
        @endhasrole

        {{-- Attendance History (Desktop) --}}
        <div
            class="hidden rounded-2xl bg-white p-5 shadow-sm ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800 lg:block lg:p-6">
            <div class="mb-5 flex items-center gap-2 border-b border-zinc-100 pb-4 dark:border-zinc-800">
                <div class="h-2 w-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]"></div>
                <h3 class="text-base font-bold tracking-wide text-zinc-800 dark:text-white">History Absensi</h3>
            </div>

            <ol class="relative border-s border-zinc-200 pl-4 dark:border-zinc-800">
                @forelse ($attendance_all as $attendance)
                    {{-- Clock In --}}
                    @if ($attendance['jam_masuk'])
                        <li class="mb-5 ms-5">
                            <span
                                class="absolute -start-2.5 flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100 ring-4 ring-white dark:bg-emerald-900/40 dark:ring-dark-primary">
                                <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                            </span>
                            <div
                                class="flex items-center justify-between rounded-xl border border-zinc-100 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-dark-secondary sm:flex">
                                <div class="text-sm text-zinc-600 dark:text-zinc-300">
                                    Kamu melakukan
                                    <span class="font-bold text-emerald-600 dark:text-emerald-400">Clock-in</span>
                                    pada
                                    <span
                                        class="rounded-md bg-zinc-100 px-1.5 py-0.5 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                        {{ \Carbon\Carbon::parse($attendance['jam_masuk'])->locale('id')->isoFormat('DD MMM YYYY') }}
                                    </span>
                                    pukul
                                    <span
                                        class="rounded-md bg-zinc-100 px-1.5 py-0.5 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                        {{ \Carbon\Carbon::parse($attendance['jam_masuk'])->format('H:i:s') }}
                                    </span>
                                </div>
                                <div class="mt-2 flex shrink-0 flex-col items-end sm:mt-0">
                                    @php
                                        $status = $attendance['status_in'];
                                        $statusMap = [
                                            0 => [
                                                'bg' => 'bg-yellow-100 dark:bg-yellow-900/30',
                                                'text' => 'text-yellow-700 dark:text-yellow-400',
                                                'label' => 'Diajukan',
                                            ],
                                            1 => [
                                                'bg' => 'bg-emerald-100 dark:bg-emerald-900/30',
                                                'text' => 'text-emerald-700 dark:text-emerald-400',
                                                'label' => 'Diterima',
                                            ],
                                            2 => [
                                                'bg' => 'bg-red-100 dark:bg-red-900/30',
                                                'text' => 'text-red-700 dark:text-red-400',
                                                'label' => 'Ditolak',
                                            ],
                                        ];
                                        $s = $statusMap[$status] ?? [
                                            'bg' => 'bg-zinc-100 dark:bg-zinc-800',
                                            'text' => 'text-zinc-500',
                                            'label' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span
                                        class="{{ $s['bg'] }} {{ $s['text'] }} rounded-md px-2 py-0.5 text-xs font-semibold">
                                        {{ $s['label'] }}
                                    </span>
                                    <time class="mt-1 text-xs text-zinc-400">
                                        {{ \Carbon\Carbon::parse($attendance['jam_masuk'])->locale('id')->diffForHumans() }}
                                    </time>
                                </div>
                            </div>
                        </li>
                    @else
                        <li class="mb-5 ms-5">
                            <span
                                class="absolute -start-2.5 flex h-5 w-5 items-center justify-center rounded-full bg-zinc-100 ring-4 ring-white dark:bg-zinc-800 dark:ring-dark-primary">
                                <div class="h-2 w-2 rounded-full bg-zinc-400"></div>
                            </span>
                            <p class="text-sm italic text-zinc-400 dark:text-zinc-600">Data tidak ditemukan</p>
                        </li>
                    @endif

                    {{-- Clock Out --}}
                    @if ($attendance['latest_jam_keluar'])
                        <li class="mb-5 ms-5">
                            <span
                                class="absolute -start-2.5 flex h-5 w-5 items-center justify-center rounded-full bg-red-100 ring-4 ring-white dark:bg-red-900/40 dark:ring-dark-primary">
                                <div class="h-2 w-2 rounded-full bg-red-500"></div>
                            </span>
                            <div
                                class="flex items-center justify-between rounded-xl border border-zinc-100 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-dark-secondary sm:flex">
                                <div class="text-sm text-zinc-600 dark:text-zinc-300">
                                    Kamu melakukan
                                    <span class="font-bold text-red-600 dark:text-red-400">Clock-out</span>
                                    pada
                                    <span
                                        class="rounded-md bg-zinc-100 px-1.5 py-0.5 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                        {{ \Carbon\Carbon::parse($attendance['latest_jam_keluar'])->locale('id')->isoFormat('DD MMM YYYY') }}
                                    </span>
                                    pukul
                                    <span
                                        class="rounded-md bg-zinc-100 px-1.5 py-0.5 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                        {{ \Carbon\Carbon::parse($attendance['latest_jam_keluar'])->format('H:i:s') }}
                                    </span>
                                </div>
                                <div class="mt-2 flex shrink-0 flex-col items-end sm:mt-0">
                                    @php
                                        $status = $attendance['status_out'];
                                        $s = $statusMap[$status] ?? [
                                            'bg' => 'bg-zinc-100 dark:bg-zinc-800',
                                            'text' => 'text-zinc-500',
                                            'label' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span
                                        class="{{ $s['bg'] }} {{ $s['text'] }} rounded-md px-2 py-0.5 text-xs font-semibold">
                                        {{ $s['label'] }}
                                    </span>
                                    <time class="mt-1 text-xs text-zinc-400">
                                        {{ \Carbon\Carbon::parse($attendance['latest_jam_keluar'])->locale('id')->diffForHumans() }}
                                    </time>
                                </div>
                            </div>
                        </li>
                    @endif
                @empty
                    <li class="ms-5">
                        <p class="text-sm italic text-zinc-400 dark:text-zinc-600">Belum ada riwayat absensi.</p>
                    </li>
                @endforelse
            </ol>
        </div>

        {{-- All Menu (Mobile only) --}}
        <div
            class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800 md:hidden lg:p-6">
            <div class="mb-4 flex items-center gap-2 border-b border-zinc-100 pb-4 dark:border-zinc-800">
                <div class="h-2 w-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]"></div>
                <h3 class="text-base font-bold tracking-wide text-zinc-800 dark:text-white">Menu</h3>
            </div>
            <div class="pt-1">
                <x-drawer.dashboard-menu />
            </div>
        </div>

        {{-- Attendance History (Mobile only) --}}
        <div
            class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800 lg:hidden lg:p-6">
            <div class="mb-5 flex items-center gap-2 border-b border-zinc-100 pb-4 dark:border-zinc-800">
                <div class="h-2 w-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]"></div>
                <h3 class="text-base font-bold tracking-wide text-zinc-800 dark:text-white">History Absensi</h3>
            </div>

            <ol class="relative border-s border-zinc-200 pl-4 dark:border-zinc-800">
                @forelse ($attendance_all as $attendance)
                    @if ($attendance['jam_masuk'])
                        <li class="mb-5 ms-5">
                            <span
                                class="absolute -start-2.5 flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100 ring-4 ring-white dark:bg-emerald-900/40 dark:ring-dark-primary">
                                <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                            </span>
                            <div
                                class="rounded-xl border border-zinc-100 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-dark-secondary">
                                <div class="mb-1.5 flex items-center gap-2">
                                    @php
                                        $status = $attendance['status_in'];
                                        $statusMap = [
                                            0 => [
                                                'bg' => 'bg-yellow-100 dark:bg-yellow-900/30',
                                                'text' => 'text-yellow-700 dark:text-yellow-400',
                                                'label' => 'Diajukan',
                                            ],
                                            1 => [
                                                'bg' => 'bg-emerald-100 dark:bg-emerald-900/30',
                                                'text' => 'text-emerald-700 dark:text-emerald-400',
                                                'label' => 'Diterima',
                                            ],
                                            2 => [
                                                'bg' => 'bg-red-100 dark:bg-red-900/30',
                                                'text' => 'text-red-700 dark:text-red-400',
                                                'label' => 'Ditolak',
                                            ],
                                        ];
                                        $s = $statusMap[$status] ?? [
                                            'bg' => 'bg-zinc-100 dark:bg-zinc-800',
                                            'text' => 'text-zinc-500',
                                            'label' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <time class="text-xs text-zinc-400">
                                        {{ \Carbon\Carbon::parse($attendance['jam_masuk'])->locale('id')->diffForHumans() }}
                                    </time>
                                    <span
                                        class="{{ $s['bg'] }} {{ $s['text'] }} rounded-md px-2 py-0.5 text-xs font-semibold">
                                        {{ $s['label'] }}
                                    </span>
                                </div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-300">
                                    <span class="font-bold text-emerald-600 dark:text-emerald-400">Clock-in</span>
                                    pukul
                                    <span
                                        class="rounded-md bg-zinc-100 px-1.5 py-0.5 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                        {{ \Carbon\Carbon::parse($attendance['jam_masuk'])->format('H:i:s') }}
                                    </span>
                                </p>
                            </div>
                        </li>
                    @else
                        <li class="mb-5 ms-5">
                            <p class="text-sm italic text-zinc-400">Data tidak ditemukan</p>
                        </li>
                    @endif

                    @if ($attendance['latest_jam_keluar'])
                        <li class="mb-5 ms-5">
                            <span
                                class="absolute -start-2.5 flex h-5 w-5 items-center justify-center rounded-full bg-red-100 ring-4 ring-white dark:bg-red-900/40 dark:ring-dark-primary">
                                <div class="h-2 w-2 rounded-full bg-red-500"></div>
                            </span>
                            <div
                                class="rounded-xl border border-zinc-100 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-dark-secondary">
                                <div class="mb-1.5 flex items-center gap-2">
                                    @php
                                        $status = $attendance['status_out'];
                                        $s = $statusMap[$status] ?? [
                                            'bg' => 'bg-zinc-100 dark:bg-zinc-800',
                                            'text' => 'text-zinc-500',
                                            'label' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <time class="text-xs text-zinc-400">
                                        {{ \Carbon\Carbon::parse($attendance['latest_jam_keluar'])->locale('id')->diffForHumans() }}
                                    </time>
                                    <span
                                        class="{{ $s['bg'] }} {{ $s['text'] }} rounded-md px-2 py-0.5 text-xs font-semibold">
                                        {{ $s['label'] }}
                                    </span>
                                </div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-300">
                                    <span class="font-bold text-red-600 dark:text-red-400">Clock-out</span>
                                    pukul
                                    <span
                                        class="rounded-md bg-zinc-100 px-1.5 py-0.5 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                        {{ \Carbon\Carbon::parse($attendance['latest_jam_keluar'])->format('H:i:s') }}
                                    </span>
                                </p>
                            </div>
                        </li>
                    @endif
                @empty
                    <li class="ms-5">
                        <p class="text-sm italic text-zinc-400 dark:text-zinc-600">Belum ada riwayat absensi.</p>
                    </li>
                @endforelse
            </ol>
        </div>

    </div>
@endsection
