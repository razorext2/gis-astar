<div id="popover-click-{{ $date }}" data-popover role="tooltip"
    class="invisible absolute z-[100] inline-block w-80 overflow-hidden rounded-2xl border border-white/30 bg-white/95 p-4 text-sm opacity-0 shadow-2xl backdrop-blur-md transition-opacity duration-300 dark:border-white/10 dark:bg-zinc-900/95">

    <div class="space-y-4">
        {{-- Attendance In Section --}}
        <div>
            <div class="mb-2 flex items-center gap-2 border-b border-zinc-200 pb-1 dark:border-zinc-800">
                <div class="h-2 w-2 rounded-full bg-green-500"></div>
                <h4 class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Absensi Masuk
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
