{{-- Goal: Calendar day popover layout showing check-in/check-out and leave status, Livewire: components.pegawai.attendance-calendar-popover, Alpine: - --}}
@php
    $isSunday = \Carbon\Carbon::parse($date)->isSunday();
    $hasHolidayOrSunday = !empty($holiday) || $isSunday;
    $totalItems = $attendance->count() + $attendanceOut->count() + ($leave ? 1 : 0) + ($hasHolidayOrSunday ? 1 : 0);
@endphp
<div id="popover-click-{{ $date }}" data-popover role="tooltip"
    class="invisible absolute z-20 inline-block w-80 overflow-hidden rounded-xl border border-zinc-200 p-4 text-sm opacity-0 shadow-md transition-opacity duration-300 dark:border-zinc-800"
    :class="dynamicBg ? 'bg-white/80 backdrop-blur-md dark:bg-dark-primary/80' : 'bg-white dark:bg-dark-primary'">

    <div class="{{ $totalItems > 2 ? 'max-h-[380px] overflow-y-auto pr-2 custom-scrollbar' : '' }} space-y-4">

        {{-- Holiday / Sunday (Tanggal Merah) Section --}}
        @if ($hasHolidayOrSunday)
            <div class="rounded-xl border border-red-200 bg-red-50/50 p-2.5 dark:border-red-900/50 dark:bg-red-950/20">
                <div class="mb-1 flex items-center gap-2">
                    <x-icons.calendar class="h-3.5 w-3.5 text-red-500" />
                    <span class="text-xs font-bold text-red-800 dark:text-red-300">
                        {{ !empty($holiday) ? 'Hari Libur Nasional' : 'Hari Minggu (Libur Pekan)' }}
                    </span>
                </div>
                <div class="space-y-1 text-[11px] text-red-700 dark:text-red-400">
                    @if (!empty($holiday))
                        <p><strong>Nama:</strong> {{ $holiday->name }}</p>
                    @else
                        <p>Hari libur akhir pekan.</p>
                    @endif
                </div>
            </div>
        @endif

        {{-- Leave (Cuti) Section --}}
        @if ($leave)
            <div
                class="rounded-xl border border-amber-200 bg-amber-50/50 p-2.5 dark:border-amber-900/50 dark:bg-amber-950/20">
                <div class="mb-1 flex items-center gap-2">
                    <x-icons.clock class="h-3.5 w-3.5 text-amber-500" />
                    <span class="text-xs font-bold text-amber-800 dark:text-amber-300">Pegawai Cuti (Disetujui)</span>
                </div>
                <div class="space-y-1 text-[11px] text-amber-700 dark:text-amber-400">
                    <p><strong>Tipe Cuti:</strong> {{ $leave->leaveType->name ?? 'N/A' }}</p>
                    <p><strong>Alasan:</strong> {{ $leave->reason }}</p>
                    <p><strong>Durasi:</strong> {{ \Carbon\Carbon::parse($leave->start_date)->isoFormat('D MMM Y') }}
                        s/d {{ \Carbon\Carbon::parse($leave->end_date)->isoFormat('D MMM Y') }}</p>
                </div>
            </div>
        @endif

        {{-- Attendance In Section --}}
        <div>
            <div class="mb-2 flex items-center gap-2 border-b border-zinc-200 pb-1 dark:border-zinc-800">
                <div class="h-2 w-2 rounded-full bg-green-500"></div>
                <h4 class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                    Absensi Masuk
                </h4>
            </div>

            @if ($attendance->isNotEmpty())
                <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <table class="w-full text-left text-[11px]">
                        <thead class="bg-gray-50 dark:bg-white/5">
                            <tr>
                                <th class="px-3 py-1.5 font-bold text-gray-500">Info</th>
                                <th class="px-3 py-1.5 text-center font-bold text-gray-500">Foto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                            @foreach ($attendance as $item)
                                @php
                                    $status = $this->getPositionStatus($item->position_status);
                                    $path = asset(sha1('libs') . '/' . $item->photoURL . '.png');
                                @endphp
                                <tr class="bg-white transition-colors hover:bg-gray-50 dark:bg-transparent">
                                    <td class="px-3 py-2">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="{{ $status['class'] }} w-fit rounded-lg px-2 py-0.5 text-[9px] font-bold uppercase">
                                                {{ $status['label'] }}
                                            </span>
                                            <span class="font-bold text-gray-800 dark:text-white">
                                                {{ \Carbon\Carbon::parse($item->jam_masuk)->isoFormat('HH:mm:ss') }}
                                            </span>
                                            <p class="line-clamp-2 italic text-gray-500">{{ $item->keterangan }}</p>
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $item->latitude }},{{ $item->longitude }}"
                                                target="_blank"
                                                class="flex items-center gap-1 text-blue-500 hover:underline">
                                                <x-icons.map-pin class="h-2.5 w-2.5" />
                                                <span>{{ round($item->latitude, 4) }},
                                                    {{ round($item->longitude, 4) }}</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-3 py-2">
                                        <img src="{{ $path }}"
                                            onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                            class="h-12 w-12 rounded-lg bg-gray-100 object-cover shadow-sm"
                                            alt="Foto">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-[10px] italic text-gray-400">Tidak ada data masuk</p>
            @endif
        </div>

        {{-- Attendance Out Section --}}
        <div>
            <div class="mb-2 flex items-center gap-2 border-b border-zinc-200 pb-1 dark:border-zinc-800">
                <div class="h-2 w-2 rounded-full bg-red-500"></div>
                <h4 class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Absensi
                    Keluar</h4>
            </div>

            @if ($attendanceOut->isNotEmpty())
                <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <table class="w-full text-left text-[11px]">
                        <thead class="bg-gray-50 dark:bg-white/5">
                            <tr>
                                <th class="px-3 py-1.5 font-bold text-gray-500">Info</th>
                                <th class="px-3 py-1.5 text-center font-bold text-gray-500">Foto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                            @foreach ($attendanceOut as $item)
                                @php
                                    $status = $this->getPositionStatus($item->position_status);
                                    $path = asset(sha1('libs') . '/' . $item->photoURL . '.png');
                                @endphp
                                <tr class="bg-white transition-colors hover:bg-gray-50 dark:bg-transparent">
                                    <td class="px-3 py-2">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="{{ $status['class'] }} w-fit rounded-lg px-2 py-0.5 text-[9px] font-bold uppercase">
                                                {{ $status['label'] }}
                                            </span>
                                            <span class="font-bold text-gray-800 dark:text-white">
                                                {{ \Carbon\Carbon::parse($item->jam_keluar)->isoFormat('HH:mm:ss') }}
                                            </span>
                                            <p class="line-clamp-2 italic text-gray-500">{{ $item->keterangan }}</p>
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $item->latitude }},{{ $item->longitude }}"
                                                target="_blank"
                                                class="flex items-center gap-1 text-blue-500 hover:underline">
                                                <x-icons.map-pin class="h-2.5 w-2.5" />
                                                <span>{{ round($item->latitude, 4) }},
                                                    {{ round($item->longitude, 4) }}</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-3 py-2">
                                        <img src="{{ $path }}"
                                            onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                            class="h-12 w-12 rounded-lg bg-gray-100 object-cover shadow-sm"
                                            alt="Foto">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-[10px] italic text-gray-400">Tidak ada data keluar</p>
            @endif
        </div>
    </div>

    <div data-popper-arrow></div>
</div>
