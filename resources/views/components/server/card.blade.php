{{--
    Goal: Row card satu server — menampilkan identity, metrics bar, system health, uptime chart, dan action menu.
    Livewire: system.server-overview
    Alpine: x-data="serverMonitor(serverId, ip)" diinisialisasi di sini untuk server aktif.
             Menggunakan sub-komponen x-server.detail-modal untuk modal detail metrics.
--}}
@props(['server', 'blocks', 'uptimePct', 'latestLog'])

@php
    $cw = 1000;
    $ch = 160;
    $pad = 4;
    $chartPts = [];
    $count = count($blocks);

    foreach ($blocks as $i => $block) {
        $pct = $block['has_data'] ? (float) $block['uptime_pct'] : 100.0;
        $x = round(($i / max($count - 1, 1)) * $cw, 2);
        $y = round($ch - $pad - ($pct / 100) * ($ch - $pad * 2), 2);
        $chartPts[] = [$x, $y, $block['date'], $block['label'], $block['has_data']];
    }

    $linePoints = implode(' ', array_map(fn($p) => $p[0] . ',' . $p[1], $chartPts));
    $firstPt = $chartPts[0];
    $lastPt = end($chartPts);
    $areaPath =
        'M' .
        $firstPt[0] .
        ',' .
        $firstPt[1] .
        ' ' .
        implode(' ', array_map(fn($p) => 'L' . $p[0] . ',' . $p[1], array_slice($chartPts, 1))) .
        ' L' .
        $lastPt[0] .
        ',' .
        $ch .
        ' L' .
        $firstPt[0] .
        ',' .
        $ch .
        ' Z';

    $lineColor =
        $uptimePct === null
            ? '#a1a1aa'
            : ($uptimePct >= 99
                ? '#22c55e'
                : ($uptimePct >= 90
                    ? '#f59e0b'
                    : ($uptimePct >= 50
                        ? '#f97316'
                        : '#ef4444')));

    $gradId = 'ug' . $server->id;
@endphp

<div class="group relative rounded-xl border border-zinc-200 bg-white px-4 py-3.5 transition-colors hover:bg-zinc-50 dark:border-zinc-800 dark:bg-[#09090b] dark:hover:bg-zinc-900"
    @if ($server->is_active) x-data="serverMonitor({{ $server->id }}, '{{ $server->ip_label }}')" x-init="startPolling()" @endif>

    {{-- Baris 1: Info + Metrics + Actions --}}
    <div class="flex flex-col gap-4 lg:grid lg:grid-cols-[220px_1fr_1fr_1fr_1fr_68px] lg:items-center">

        {{-- ① Server Identity --}}
        <div class="flex min-w-0 items-center gap-3 pr-10 lg:pr-0">
            <div @class([
                'flex h-9 w-9 shrink-0 items-center justify-center rounded-full',
                'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400' =>
                    $server->is_active,
                'bg-zinc-100 text-zinc-400 dark:bg-zinc-800' => !$server->is_active,
            ])>
                <x-icons.computer class="h-4 w-4" />
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                    {{ $server->name }}</p>
                <div class="mt-0.5 flex items-center gap-1.5">
                    <span class="relative flex h-2 w-2 shrink-0">
                        @if ($server->is_active)
                            <span :class="error ? 'bg-red-500' : (loading ? 'bg-amber-400' : 'bg-green-500')"
                                class="relative inline-flex h-full w-full rounded-full transition-colors"></span>
                            <span x-show="!error && !loading"
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                        @else
                            <span class="relative inline-flex h-full w-full rounded-full bg-zinc-400"></span>
                        @endif
                    </span>
                    <span class="truncate font-mono text-[11px] text-zinc-500 dark:text-zinc-400"
                        title="{{ $server->api_url }}">
                        @if ($server->is_active)
                            <span x-text="error ? 'Terputus' : (loading ? 'Menyambungkan...' : 'Terhubung')">--</span>
                        @else
                            Nonaktif
                        @endif
                    </span>
                </div>
            </div>
        </div>

        @if ($server->is_active)
            {{-- ② CPU --}}
            <div class="relative">
                <div class="mb-1 flex justify-between text-[11px]">
                    <div class="flex items-center gap-1">
                        <span class="font-semibold text-zinc-500 dark:text-zinc-400 lg:hidden">CPU</span>
                        <template x-if="stats.cpu >= 90">
                            <svg class="h-3 w-3 animate-bounce text-red-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </template>
                    </div>
                    <span class="font-mono font-bold"
                        :class="stats.cpu >= 90 ? 'text-red-600 animate-pulse' : 'text-zinc-700 dark:text-zinc-300'"
                        x-show="!loading" x-text="stats.cpu + '%'"></span>
                    <span class="font-mono text-zinc-400" x-show="loading">--</span>
                </div>
                <div class="h-1.5 w-full overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-800">
                    <div class="h-1.5 rounded-full transition-all duration-1000 ease-in-out"
                        :class="getColorClass(stats.cpu)" :style="`width: ${stats.cpu}%`"></div>
                </div>
            </div>

            {{-- ③ Memori --}}
            <div class="relative">
                <div class="mb-1 flex justify-between text-[11px]">
                    <div class="flex items-center gap-1">
                        <span class="font-semibold text-zinc-500 dark:text-zinc-400 lg:hidden">Memori</span>
                        <template x-if="stats.mem >= 90">
                            <svg class="h-3 w-3 animate-bounce text-red-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </template>
                    </div>
                    <span class="font-mono font-bold"
                        :class="stats.mem >= 90 ? 'text-red-600 animate-pulse' : 'text-zinc-700 dark:text-zinc-300'"
                        x-show="!loading" x-text="stats.mem + '%'"></span>
                    <span class="font-mono text-zinc-400" x-show="loading">--</span>
                </div>
                <div class="h-1.5 w-full overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-800">
                    <div class="h-1.5 rounded-full transition-all duration-1000 ease-in-out"
                        :class="getColorClass(stats.mem)" :style="`width: ${stats.mem}%`"></div>
                </div>
            </div>

            {{-- ④ Disk --}}
            <div class="relative">
                <div class="mb-1 flex justify-between text-[11px]">
                    <div class="flex items-center gap-1">
                        <span class="font-semibold text-zinc-500 dark:text-zinc-400 lg:hidden">Disk</span>
                        <template x-if="stats.disk >= 90">
                            <svg class="h-3 w-3 animate-bounce text-red-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </template>
                    </div>
                    <span class="font-mono font-bold"
                        :class="stats.disk >= 90 ? 'text-red-600 animate-pulse' : 'text-zinc-700 dark:text-zinc-300'"
                        x-show="!loading" x-text="stats.disk + '%'"></span>
                    <span class="font-mono text-zinc-400" x-show="loading">--</span>
                </div>
                <div class="h-1.5 w-full overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-800">
                    <div class="h-1.5 rounded-full transition-all duration-1000 ease-in-out"
                        :class="getColorClass(stats.disk)" :style="`width: ${stats.disk}%`"></div>
                </div>
            </div>

            {{-- ⑤ Network --}}
            <div class="relative">
                <div class="mb-1 flex items-center justify-between text-[11px]">
                    <span class="font-semibold text-zinc-500 dark:text-zinc-400 lg:hidden">Network</span>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-1 text-green-600 dark:text-green-400">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                            <span class="font-mono font-bold" x-text="formatBytes(stats.net_rx) + '/s'"></span>
                        </div>
                        <div class="flex items-center gap-1 text-blue-600 dark:text-blue-400">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            <span class="font-mono font-bold" x-text="formatBytes(stats.net_tx) + '/s'"></span>
                        </div>
                    </div>
                </div>
                <div class="h-1.5 w-full overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-800">
                    <div class="h-1.5 rounded-full bg-zinc-400 opacity-30" style="width: 100%"></div>
                </div>
            </div>
        @else
            {{-- Inactive placeholder --}}
            <div class="lg:col-span-4">
                <span class="text-xs italic text-zinc-400">Pemantauan dinonaktifkan</span>
            </div>
        @endif

        {{-- ⑥ Actions Dropdown --}}
        <div class="absolute right-4 top-4 flex items-center justify-end lg:relative lg:right-0 lg:top-0"
            x-data="{ openMenu: false }">
            <button @click="openMenu = !openMenu"
                class="flex h-8 w-8 items-center justify-center rounded-lg text-zinc-400 transition-all hover:bg-zinc-100 hover:text-zinc-600 dark:hover:bg-zinc-800 dark:hover:text-zinc-300"
                :class="{ 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300': openMenu }">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
            </button>

            <div x-show="openMenu" @click.away="openMenu = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 top-full z-50 mt-2 w-48 origin-top-right rounded-xl border border-zinc-200 bg-white p-1.5 shadow-xl shadow-zinc-200/50 backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/90 dark:shadow-black/50"
                style="display: none;">

                @if ($server->is_active)
                    <button x-show="typeof loading !== 'undefined' ? (!loading && !error) : false"
                        @click="showDetails = true; openMenu = false"
                        class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-left text-xs font-medium text-zinc-600 transition-colors hover:bg-zinc-50 hover:text-red-600 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-red-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Detail Metrics
                    </button>
                    <div class="my-1 border-t border-zinc-100 dark:border-zinc-800"></div>
                @endif

                <button wire:click="edit({{ $server->id }})" @click="openMenu = false"
                    class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-left text-xs font-medium text-zinc-600 transition-colors hover:bg-zinc-50 hover:text-blue-600 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-blue-400">
                    <x-icons.pen class="h-4 w-4" />
                    Edit Konfigurasi
                </button>

                <button wire:confirm="Yakin ingin menghapus monitoring server ini?"
                    wire:click="delete({{ $server->id }})"
                    class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-left text-xs font-medium text-zinc-600 transition-colors hover:bg-red-50 hover:text-red-600 dark:text-zinc-400 dark:hover:bg-red-900/20 dark:hover:text-red-400">
                    <x-icons.trash class="h-4 w-4" />
                    Hapus Monitor
                </button>
            </div>
        </div>
    </div>

    {{-- System Health Bar (hanya untuk server aktif) --}}
    @if ($server->is_active)
        <div x-show="!loading && !error" x-transition
            class="mt-3 flex flex-wrap items-center gap-x-6 gap-y-2 rounded-lg bg-zinc-50/50 px-3 py-2 text-[11px] dark:bg-zinc-900/40">
            <div class="flex items-center gap-1.5">
                <x-icons.info class="h-3.5 w-3.5 text-zinc-400" />
                <span class="font-medium text-zinc-500">System:</span>
                <span class="text-zinc-700 dark:text-zinc-300" x-text="sysInfo.os || '--'"></span>
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium text-zinc-500">Uptime:</span>
                <span class="text-zinc-700 dark:text-zinc-300" x-text="sysInfo.uptime || '--'"></span>
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium text-zinc-500">Local IP:</span>
                <span class="font-mono text-zinc-700 dark:text-zinc-300" x-text="sysInfo.ip || '--'"></span>
            </div>
        </div>
    @endif

    {{-- Uptime Chart (30 hari) --}}
    <div class="mt-3 border-t border-zinc-100 pt-3 dark:border-zinc-800">
        <div class="mb-1.5 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-medium text-zinc-400">Uptime 30 Hari</span>
                @if ($latestLog)
                    <span @class([
                        'inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 text-[10px] font-medium',
                        'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' =>
                            $latestLog->status === 'online',
                        'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' =>
                            $latestLog->status === 'offline',
                    ])>
                        <span
                            class="{{ $latestLog->status === 'online' ? 'bg-green-500' : 'bg-red-500' }} h-1.5 w-1.5 rounded-full"></span>
                        {{ ucfirst($latestLog->status) }} · {{ $latestLog->logged_at->diffForHumans() }}
                    </span>
                @endif
            </div>
            @if ($uptimePct !== null)
                <span @class([
                    'text-[10px] font-semibold',
                    'text-green-600 dark:text-green-400' => $uptimePct >= 99,
                    'text-amber-600 dark:text-amber-400' => $uptimePct >= 90 && $uptimePct < 99,
                    'text-orange-600 dark:text-orange-400' =>
                        $uptimePct >= 50 && $uptimePct < 90,
                    'text-red-600 dark:text-red-400' => $uptimePct < 50,
                ])>{{ number_format($uptimePct, 1) }}%</span>
            @else
                <span class="text-[10px] text-zinc-400">–</span>
            @endif
        </div>

        <svg viewBox="0 0 {{ $cw }} {{ $ch }}" class="h-10 w-full" preserveAspectRatio="none">
            <defs>
                <linearGradient id="{{ $gradId }}" x1="0" y1="0" x2="0"
                    y2="1">
                    <stop offset="0%" stop-color="{{ $lineColor }}" stop-opacity="0.3" />
                    <stop offset="100%" stop-color="{{ $lineColor }}" stop-opacity="0.02" />
                </linearGradient>
            </defs>
            <path d="{{ $areaPath }}" fill="url(#{{ $gradId }})" />
            <polyline points="{{ $linePoints }}" fill="none" stroke="{{ $lineColor }}" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" />
            @foreach ($chartPts as $pt)
                <title>{{ $pt[2] }}: {{ $pt[4] ? $pt[3] : 'Tidak ada data' }}</title>
            @endforeach
        </svg>
    </div>

    {{-- Modal Detail Metrics (hanya untuk server aktif) --}}
    @if ($server->is_active)
        <x-server.detail-modal :server="$server" />
    @endif

</div>
