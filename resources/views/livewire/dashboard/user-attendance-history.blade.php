<div>
    {{-- Attendance History (Desktop) --}}
    <div
        class="hidden rounded-2xl bg-white/70 p-4 ring-1 ring-zinc-200 backdrop-blur-sm dark:bg-zinc-900/60 dark:ring-zinc-800 lg:block lg:p-6">
        <div class="mb-5 flex items-center gap-2 border-b border-zinc-200 pb-4 dark:border-zinc-800">
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
                            class="flex items-center justify-between rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-dark-secondary sm:flex">
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
                            class="flex items-center justify-between rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-dark-secondary sm:flex">
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

    {{-- Attendance History (Mobile only) --}}
    <div
        class="rounded-2xl bg-white p-4 ring-1 ring-zinc-200 backdrop-blur-sm dark:bg-zinc-900/60 dark:ring-zinc-800 lg:hidden lg:p-6">
        <div class="mb-5 flex items-center gap-2 border-b border-zinc-200 pb-4 dark:border-zinc-800">
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
                            class="rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-dark-secondary">
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
                            class="rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-dark-secondary">
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
