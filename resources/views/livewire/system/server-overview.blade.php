<div
    class="mx-auto max-w-screen-2xl rounded-2xl border border-white/60 bg-white/70 p-4 shadow-lg shadow-zinc-200/50 backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60 dark:shadow-black/30 md:p-6">


    {{-- Column Headers --}}
    @if (count($servers) > 0)
        <div
            class="mb-1 hidden grid-cols-[220px_1fr_1fr_1fr_1fr_68px] gap-4 px-4 text-[11px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-600 lg:grid">
            <span>Server</span>
            <span>CPU</span>
            <span>Memori</span>
            <span>Disk</span>
            <span>Network</span>
            <span>Aksi</span>
        </div>
    @endif

    {{-- Server Rows --}}
    <div class="space-y-4">
        @foreach ($servers as $server)
            @php
                $blocks = $this->computeUptimeBlocks($server);
                $uptimePct = $this->computeUptimePct30Days($server);
                $latestLog = \App\Models\ServerMonitorLog::where('server_monitor_id', $server->id)
                    ->orderByDesc('logged_at')
                    ->first();
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
                                        <span
                                            :class="error ? 'bg-red-500' : (loading ? 'bg-amber-400' : 'bg-green-500')"
                                            class="relative inline-flex h-full w-full rounded-full transition-colors"></span>
                                        <span x-show="!error && !loading"
                                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                                    @else
                                        <span
                                            class="relative inline-flex h-full w-full rounded-full bg-zinc-400"></span>
                                    @endif
                                </span>
                                <span class="truncate font-mono text-[11px] text-zinc-500 dark:text-zinc-400"
                                    title="{{ $server->api_url }}">
                                    @if ($server->is_active)
                                        <span
                                            x-text="error ? 'Terputus' : (loading ? 'Menyambungkan...' : 'Terhubung')">--</span>
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
                                        <svg class="h-3 w-3 animate-bounce text-red-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
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
                                        <svg class="h-3 w-3 animate-bounce text-red-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
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
                                        <svg class="h-3 w-3 animate-bounce text-red-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
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
                        {{-- ⑤ Network (Langkah Baru) --}}
                        <div class="relative">
                            <div class="mb-1 flex items-center justify-between text-[11px]">
                                <span class="font-semibold text-zinc-500 dark:text-zinc-400 lg:hidden">Network</span>
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-1 text-green-600 dark:text-green-400">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                        </svg>
                                        <span class="font-mono font-bold"
                                            x-text="formatBytes(stats.net_rx) + '/s'"></span>
                                    </div>
                                    <div class="flex items-center gap-1 text-blue-600 dark:text-blue-400">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                        </svg>
                                        <span class="font-mono font-bold"
                                            x-text="formatBytes(stats.net_tx) + '/s'"></span>
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
                            class="absolute right-0 top-full z-50 mt-2 w-48 origin-top-right rounded-xl border border-zinc-200 bg-white p-1.5 shadow-xl shadow-zinc-200/50 backdrop-blur-xl dark:border-zinc-800 dark:bg-zinc-900/90 dark:shadow-black/50"
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
                                wire:click="delete({{ $server->id }})" @click="openMenu = false"
                                class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-left text-xs font-medium text-zinc-600 transition-colors hover:bg-red-50 hover:text-red-600 dark:text-zinc-400 dark:hover:bg-red-900/20 dark:hover:text-red-400">
                                <x-icons.trash class="h-4 w-4" />
                                Hapus Monitor
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Baris tambahan: System Health & Info (Langkah 2) --}}
                @if ($server->is_active)
                    <div x-show="!loading && !error" x-transition
                        class="mt-3 flex flex-wrap items-center gap-x-6 gap-y-2 rounded-lg bg-zinc-50/50 px-3 py-2 text-[11px] dark:bg-zinc-900/40">
                        <div class="flex items-center gap-1.5">
                            <x-icons.info class="h-3.5 w-3.5 text-zinc-400" />
                            <span class="font-medium text-zinc-500">System:</span>
                            <span class="text-zinc-700 dark:text-zinc-300" x-text="sysInfo.os || '--'"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="h-3.5 w-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium text-zinc-500">Uptime:</span>
                            <span class="text-zinc-700 dark:text-zinc-300" x-text="sysInfo.uptime || '--'"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="h-3.5 w-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium text-zinc-500">Local IP:</span>
                            <span class="font-mono text-zinc-700 dark:text-zinc-300"
                                x-text="sysInfo.ip || '--'"></span>
                        </div>
                    </div>
                @endif

                {{-- Baris 2: Uptime Line Chart (full width) --}}
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

                    </svg>
                </div>

                {{-- Modal Detail Server (Langkah 3) - Sekarang di dalam scope x-data row --}}
                <template x-teleport="body">
                    <div x-show="showDetails" class="fixed inset-0 z-[110] overflow-y-auto" style="display: none;">
                        <div x-show="showDetails" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 bg-zinc-900/60 backdrop-blur-md transition-opacity"></div>

                        <div class="flex min-h-screen items-center justify-center p-4">
                            <div x-show="showDetails" @click.away="showDetails = false"
                                class="relative flex max-h-[70vh] w-full max-w-4xl transform flex-col overflow-hidden rounded-2xl border border-white/20 bg-white/90 shadow-2xl backdrop-blur-2xl transition-all dark:border-zinc-800 dark:bg-zinc-950/90">

                                {{-- Header - Fixed at top --}}
                                <div
                                    class="flex items-center justify-between border-b border-zinc-100 p-4 dark:border-zinc-800 sm:p-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">
                                            <x-icons.computer class="h-6 w-6" />
                                        </div>
                                        <div>
                                            <h2 class="text-xl font-bold text-zinc-900 dark:text-white"
                                                x-text="'Detail Server: ' + '{{ $server->name }}'"></h2>
                                            <p class="text-sm text-zinc-500" x-text="'System: ' + sysInfo.os"></p>
                                        </div>
                                    </div>
                                    <button @click="showDetails = false"
                                        class="rounded-lg p-2 text-zinc-400 hover:bg-zinc-100 hover:text-zinc-600 dark:hover:bg-zinc-800">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                {{-- Scrollable Body --}}
                                <div class="overflow-y-auto p-4 sm:p-6">
                                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                        {{-- CPU & System --}}
                                        <div
                                            class="space-y-4 rounded-xl border border-zinc-100 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:bg-white/5">
                                            <h4
                                                class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-zinc-400">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2-2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                                </svg>
                                                Processor
                                            </h4>
                                            <div class="space-y-2">
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-zinc-500">Model</span>
                                                    <span
                                                        class="text-right font-medium text-zinc-900 dark:text-zinc-200"
                                                        x-text="fullData?.cpu?.processor || '--'"></span>
                                                </div>
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-zinc-500">Cores</span>
                                                    <span class="font-medium text-zinc-900 dark:text-zinc-200"
                                                        x-text="fullData?.cpu?.cpucore || '--'"></span>
                                                </div>
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-zinc-500">CPU Load (1m)</span>
                                                    <span class="font-medium text-zinc-900 dark:text-zinc-200"
                                                        x-text="(fullData?.load?.cpucore || '0')"></span>
                                                </div>
                                                {{-- Sparkline CPU --}}
                                                <div class="mt-3 h-10 w-full opacity-50">
                                                    <svg class="h-full w-full" viewBox="0 0 120 40"
                                                        preserveAspectRatio="none">
                                                        <polyline fill="none"
                                                            class="stroke-blue-500 dark:stroke-blue-400"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            :points="getSparklinePoints('cpu')" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Memory --}}
                                        <div
                                            class="space-y-4 rounded-xl border border-zinc-100 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:bg-white/5">
                                            <h4
                                                class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-zinc-400">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                                Memory
                                            </h4>
                                            <div class="space-y-2">
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-zinc-500">Total</span>
                                                    <span class="font-medium text-zinc-900 dark:text-zinc-200"
                                                        x-text="fullData?.mem ? (fullData.mem.total / 1024 / 1024 / 1024).toFixed(2) + ' GB' : '--'"></span>
                                                </div>
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-zinc-500">Used</span>
                                                    <span class="font-medium text-zinc-900 dark:text-zinc-200"
                                                        x-text="fullData?.mem ? (fullData.mem.used / 1024 / 1024 / 1024).toFixed(2) + ' GB' : '--'"></span>
                                                </div>
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-zinc-500">Free</span>
                                                    <span class="font-medium text-zinc-900 dark:text-zinc-200"
                                                        x-text="fullData?.mem ? (fullData.mem.free / 1024 / 1024 / 1024).toFixed(2) + ' GB' : '--'"></span>
                                                </div>
                                                {{-- Sparkline MEM --}}
                                                <div class="mt-3 h-10 w-full opacity-50">
                                                    <svg class="h-full w-full" viewBox="0 0 120 40"
                                                        preserveAspectRatio="none">
                                                        <polyline fill="none"
                                                            class="stroke-purple-500 dark:stroke-purple-400"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            :points="getSparklinePoints('mem')" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Network --}}
                                        <div
                                            class="space-y-4 rounded-xl border border-zinc-100 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:bg-white/5">
                                            <h4
                                                class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-zinc-400">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                                                </svg>
                                                Network
                                            </h4>
                                            <div class="space-y-2">
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-zinc-500">IP Public</span>
                                                    <span
                                                        class="font-mono font-medium text-zinc-900 dark:text-zinc-200"
                                                        x-text="formatIp(fullData?.core?.public_ip)"></span>
                                                </div>
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-zinc-500">Hostname</span>
                                                    <span class="font-medium text-zinc-900 dark:text-zinc-200"
                                                        x-text="fullData?.system?.hostname || '--'"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Network Interfaces --}}
                                    <div class="mt-6">
                                        <h4
                                            class="mb-3 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400">
                                            NETWORK INTERFACES</h4>
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-left text-sm">
                                                <thead>
                                                    <tr class="border-b border-zinc-100 dark:border-zinc-800">
                                                        <th class="py-2 font-medium text-zinc-500">Interface</th>
                                                        <th class="py-2 text-center font-medium text-zinc-500">Status
                                                        </th>
                                                        <th class="py-2 font-medium text-zinc-500">IP Address</th>
                                                        <th class="py-2 font-medium text-zinc-500">Download (Rx)</th>
                                                        <th class="py-2 font-medium text-zinc-500">Upload (Tx)</th>
                                                        <th class="py-2 font-medium text-zinc-500">Cumulative</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template x-for="net in fullData?.network"
                                                        :key="net.interface_name">
                                                        <tr class="border-b border-zinc-50 dark:border-zinc-900/50">
                                                            <td class="py-3 font-medium dark:text-zinc-300"
                                                                x-text="net.interface_name"></td>
                                                            <td class="py-3 text-center">
                                                                <span class="inline-flex h-2 w-2 rounded-full"
                                                                    :class="net.is_up ? 'bg-green-500' : 'bg-red-500'"></span>
                                                            </td>
                                                            <td class="py-3 font-mono text-xs text-zinc-500"
                                                                x-text="net.ip || net.address || '--'">
                                                            </td>
                                                            <td class="py-3 font-mono text-xs dark:text-green-400"
                                                                x-text="formatBytes(getNetRate(net, 'rx')) + '/s'">
                                                            </td>
                                                            <td class="py-3 font-mono text-xs dark:text-blue-400"
                                                                x-text="formatBytes(getNetRate(net, 'tx')) + '/s'">
                                                            </td>
                                                            <td class="py-3 text-xs text-zinc-500">
                                                                <div
                                                                    x-text="'↓ ' + formatBytes(net.bytes_recv_gauge || net.cumulative_rx || net.cumulative_recv || net.rx)">
                                                                </div>
                                                                <div
                                                                    x-text="'↑ ' + formatBytes(net.bytes_sent_gauge || net.cumulative_tx || net.cumulative_send || net.tx)">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Disk Filesystems --}}
                                    <div class="mt-6">
                                        <h4
                                            class="mb-3 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400">
                                            DISK FILESYSTEMS</h4>
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-left text-sm">
                                                <thead>
                                                    <tr class="border-b border-zinc-100 dark:border-zinc-800">
                                                        <th class="py-2 font-medium text-zinc-500">Mount Point</th>
                                                        <th class="py-2 font-medium text-zinc-500">Device</th>
                                                        <th class="whitespace-nowrap py-2 font-medium text-zinc-500">
                                                            Total</th>
                                                        <th class="py-2 font-medium text-zinc-500">Used</th>
                                                        <th class="whitespace-nowrap py-2 font-medium text-zinc-500">
                                                            Usage %</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template x-for="fs in fullData?.fs" :key="fs.mnt_point">
                                                        <tr class="border-b border-zinc-50 dark:border-zinc-900/50">
                                                            <td class="py-3 font-medium dark:text-zinc-300"
                                                                x-text="fs.mnt_point"></td>
                                                            <td class="py-3 text-zinc-500" x-text="fs.device_name">
                                                            </td>
                                                            <td class="whitespace-nowrap py-3 dark:text-zinc-400"
                                                                x-text="(fs.size / 1024 / 1024 / 1024).toFixed(1) + ' GB'">
                                                            </td>
                                                            <td class="whitespace-nowrap py-3 dark:text-zinc-400"
                                                                x-text="(fs.used / 1024 / 1024 / 1024).toFixed(1) + ' GB'">
                                                            </td>
                                                            <td class="py-3">
                                                                <div class="flex items-center gap-2">
                                                                    <div
                                                                        class="h-1 w-16 overflow-hidden whitespace-nowrap rounded-full bg-zinc-100 dark:bg-zinc-800">
                                                                        <div class="h-full"
                                                                            :style="`width: ${fs.percent}%`"
                                                                            :class="fs.percent > 90 ? 'bg-red-500' :
                                                                                'bg-blue-500'">
                                                                        </div>
                                                                    </div>
                                                                    <span class="font-mono text-xs"
                                                                        x-text="fs.percent + '%'"></span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Top Processes --}}
                                    <div class="mb-8 mt-8 px-1">
                                        <div
                                            class="mb-3 flex items-center justify-between border-b border-zinc-100 pb-2 dark:border-zinc-800">
                                            <h4 class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400">
                                                TOP PROCESSES</h4>
                                            <span class="font-mono text-[10px] text-zinc-400 opacity-50">SORTED BY CPU
                                                %</span>
                                        </div>
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-left text-xs">
                                                <thead>
                                                    <tr class="text-[9px] uppercase tracking-wider text-zinc-400">
                                                        <th class="py-2">Process</th>
                                                        <th class="py-2 text-right">CPU%</th>
                                                        <th class="py-2 text-right font-normal">MEM%</th>
                                                        <th class="px-2 py-2 text-right font-normal">User</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template x-for="p in processes" :key="p.pid || p.name">
                                                        <tr
                                                            class="border-b border-zinc-50 transition-colors last:border-0 hover:bg-zinc-50/50 dark:border-zinc-900/40 dark:hover:bg-white/5">
                                                            <td class="max-w-[150px] truncate py-2.5 font-medium dark:text-zinc-300"
                                                                x-text="p.name"></td>
                                                            <td class="py-2.5 text-right font-mono font-bold"
                                                                :class="parseFloat(p.cpu_percent) > 50 ? 'text-red-500' :
                                                                    'text-zinc-700 dark:text-zinc-300'"
                                                                x-text="(p.cpu_percent || 0).toFixed(1) + '%'"></td>
                                                            <td class="py-2.5 text-right font-mono text-zinc-500"
                                                                x-text="(p.memory_percent || 0).toFixed(1) + '%'"></td>
                                                            <td class="px-2 py-2.5 text-right text-zinc-400"
                                                                x-text="p.username || 'root'"></td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </template>
            </div>
        @endforeach

        @if (count($servers) === 0)
            <div
                class="flex flex-col items-center justify-center rounded-xl border border-dashed border-zinc-300 bg-zinc-50 py-16 text-center dark:border-zinc-700 dark:bg-[#09090b]">
                <x-icons.computer class="mb-3 h-12 w-12 text-zinc-400" />
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">Belum Ada Server</h3>
                <p class="mb-4 mt-1 text-sm text-zinc-500">Tambahkan konfigurasi server Glances pertama Anda.</p>
                <x-button.danger wire:click="create">
                    Tambah Konfigurasi
                </x-button.danger>
            </div>
        @endif
    </div>


    {{-- Pagination Navigation --}}
    @if ($this->totalPages() > 1)
        <div class="mt-6 flex items-center justify-between border-t border-zinc-200 pt-4 dark:border-zinc-800">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Menampilkan
                <span class="font-semibold text-zinc-700 dark:text-zinc-200">
                    {{ ($page - 1) * $perPage + 1 }}–{{ min($page * $perPage, $totalServers) }}
                </span>
                dari <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $totalServers }}</span> server
            </p>

            <div class="flex items-center gap-2">
                {{-- Prev --}}
                <button wire:click="prevPage" @disabled($page <= 1)
                    class="inline-flex items-center gap-1.5 rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm font-medium text-zinc-700 transition-all hover:bg-zinc-50 disabled:cursor-not-allowed disabled:opacity-40 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.79 5.23a.75.75 0 0 1-.02 1.06L8.832 10l3.938 3.71a.75.75 0 1 1-1.04 1.08l-4.5-4.25a.75.75 0 0 1 0-1.08l4.5-4.25a.75.75 0 0 1 1.06.02z"
                            clip-rule="evenodd" />
                    </svg>
                    Sebelumnya
                </button>

                {{-- Page indicator --}}
                <span class="px-2 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ $page }} / {{ $this->totalPages() }}
                </span>

                {{-- Next --}}
                <button wire:click="nextPage" @disabled($page >= $this->totalPages())
                    class="inline-flex items-center gap-1.5 rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm font-medium text-zinc-700 transition-all hover:bg-zinc-50 disabled:cursor-not-allowed disabled:opacity-40 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800">
                    Selanjutnya
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.21 14.77a.75.75 0 0 1 .02-1.06L11.168 10 7.23 6.29a.75.75 0 1 1 1.04-1.08l4.5 4.25a.75.75 0 0 1 0 1.08l-4.5 4.25a.75.75 0 0 1-1.06-.02z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    {{-- Modal diletakkan di luar container agar tidak terpotong oleh backdrop-blur parent --}}
    <div x-data="{ show: @entangle('showModal').live }">
        <template x-teleport="body">
            <div x-show="show" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;"
                aria-labelledby="modal-title" role="dialog" aria-modal="true">

                {{-- Overlay --}}
                <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-zinc-900/50 backdrop-blur-sm transition-opacity"></div>

                <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                    {{-- Modal panel --}}
                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-xl border border-zinc-200 bg-white text-left shadow-xl transition-all dark:border-zinc-800 dark:bg-zinc-900 sm:my-8 sm:w-full sm:max-w-lg">

                        <form wire:submit="save">
                            <div class="border-b border-zinc-100 p-4 dark:border-zinc-800 sm:px-6">
                                <h3 class="text-xl font-bold leading-6 text-zinc-900 dark:text-zinc-100"
                                    id="modal-title">
                                    {{ $serverId ? 'Edit Server' : 'Tambah Server Baru' }}
                                </h3>

                                <p class="mt-1 text-sm text-zinc-500">Konfigurasi endpoint API Glances untuk
                                    monitoring.</p>
                            </div>

                            <div class="px-4 pb-4 pt-5 sm:p-6">
                                <div class="space-y-4">
                                    <div>
                                        <x-input.basic id="server-name" name="name" wire:model="name"
                                            placeholder="Misal: Production Database" required>
                                            Nama Server
                                        </x-input.basic>
                                        @error('name')
                                            <x-input-error :messages="$message" class="mt-1" />
                                        @enderror
                                    </div>

                                    <div>
                                        <x-input.basic id="api-url" name="api_url" type="url"
                                            wire:model="api_url" placeholder="http://192.168.1.1:61208" required>
                                            Glances API URL
                                        </x-input.basic>
                                        <p class="mt-1 text-xs text-zinc-500">Masukkan URL Glances tanpa
                                            trailing slash
                                            dan tanpa <code>/api/4/all</code>.</p>
                                        @error('api_url')
                                            <x-input-error :messages="$message" class="mt-1" />
                                        @enderror
                                    </div>

                                    <div>
                                        <x-input.basic id="ip-label" name="ip_label" wire:model="ip_label"
                                            placeholder="Misal: 192.168.11.250">
                                            IP Display (Manual Override)
                                        </x-input.basic>
                                        <p class="mt-1 text-[10px] italic text-zinc-400">Kosongkan jika ingin dideteksi
                                            otomatis oleh Glances.</p>
                                        @error('ip_label')
                                            <x-input-error :messages="$message" class="mt-1" />
                                        @enderror
                                    </div>

                                    <div class="pt-2">
                                        <label class="flex cursor-pointer items-center gap-3">
                                            <input type="checkbox" wire:model="is_active"
                                                class="h-5 w-5 rounded border-zinc-300 text-red-600 focus:ring-red-600 dark:border-zinc-700 dark:bg-zinc-900">
                                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Aktifkan
                                                Pemantauan (Polling)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mt-4 gap-2 border-t border-zinc-200 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-zinc-800/50 sm:flex sm:flex-row-reverse sm:px-6">
                                <x-button.danger type="submit">
                                    Simpan Data
                                </x-button.danger>
                                <x-button.secondary @click="show = false">
                                    Batal
                                </x-button.secondary>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

@push('script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('serverMonitor', (serverId, manualIp = '') => ({
                loading: true,
                error: false,
                pollInterval: null,
                manualIp: manualIp,
                stats: {
                    cpu: 0,
                    mem: 0,
                    disk: 0,
                    net_rx: 0,
                    net_tx: 0
                },
                history: {
                    cpu: [],
                    mem: [],
                    disk: []
                },
                processes: [],
                historyLimit: 30,
                sysInfo: {
                    os: '',
                    uptime: '',
                    ip: manualIp || '--'
                },
                fullData: null,
                showDetails: false,

                startPolling() {
                    this.fetchData();
                    // 10 second polling
                    this.pollInterval = setInterval(() => {
                        this.fetchData();
                    }, 10000);
                },

                async fetchData() {
                    try {
                        const response = await fetch(`/proxy/glances/${serverId}`);
                        if (!response.ok) {
                            throw new Error('Connection failed');
                        }

                        const data = await response.json();

                        // Extracts from standard Glances API /api/3/all payload
                        const cpuTotal = data.cpu && data.cpu.total !== undefined ? data.cpu.total :
                            0;
                        const memPercent = data.mem && data.mem.percent !== undefined ? data.mem
                            .percent : 0;

                        // For disk, typically there is an fs array. let's find root '/' or first item
                        let diskPercent = 0;
                        if (data.fs && data.fs.length > 0) {
                            // find root
                            const rootFs = data.fs.find(f => f.mnt_point === '/' || f
                                .device_name === '/dev/root' || f.mnt_point?.includes(':'));
                            if (rootFs && rootFs.percent) {
                                diskPercent = rootFs.percent;
                            } else {
                                diskPercent = data.fs[0].percent || 0;
                            }
                        }

                        this.stats = {
                            cpu: parseFloat(cpuTotal).toFixed(1),
                            mem: parseFloat(memPercent).toFixed(1),
                            disk: parseFloat(diskPercent).toFixed(1),
                            net_rx: this.calculateTotalNet(data.network, 'rx'),
                            net_tx: this.calculateTotalNet(data.network, 'tx'),
                        };

                        // Detail system untuk langkah 2
                        this.sysInfo = {
                            os: (data.system.os_name || '') + ' ' + (data.system.os_version ||
                                ''),
                            uptime: data.uptime || '--',
                            ip: this.manualIp || this.calculateLocalIp(data)
                        };

                        // Update History for Sparklines (Rolling 30 points)
                        ['cpu', 'mem', 'disk'].forEach(type => {
                            if (!this.history[type]) this.history[type] = [];
                            this.history[type].push(parseFloat(this.stats[type]));
                            if (this.history[type].length > this.historyLimit) {
                                this.history[type].shift();
                            }
                        });

                        // Update Top Processes
                        if (data.processlist) {
                            this.processes = [...data.processlist]
                                .sort((a, b) => (b.cpu_percent || 0) - (a.cpu_percent || 0))
                                .slice(0, 10);
                        }

                        this.fullData = data;
                        this.error = false;
                    } catch (e) {
                        console.error('Glances fetch error for server ' + serverId, e);
                        this.error = true;
                    } finally {
                        this.loading = false;
                    }
                },

                calculateTotalNet(networks, type) {
                    if (!networks || !Array.isArray(networks)) return 0;
                    return networks.reduce((acc, net) => {
                        return acc + parseFloat(this.getNetRate(net, type));
                    }, 0);
                },

                getNetRate(net, type) {
                    if (!net) return 0;

                    // 1. Coba cari dengan kunci yang sudah pasti (Priority)
                    const priorityKeys = type === 'rx' ? ['bytes_recv_rate_per_sec', 'rx_rate',
                        'rx_rate_per_sec', 'rx_bytes_per_sec',
                        'rx_kbps', 'rx'
                    ] : ['bytes_sent_rate_per_sec', 'tx_rate', 'tx_rate_per_sec',
                        'tx_bytes_per_sec',
                        'tx_kbps', 'tx'
                    ];

                    for (let key of priorityKeys) {
                        if (net[key] !== undefined && net[key] !== null) {
                            const val = parseFloat(net[key]);
                            if (val > 0) return val;
                        }
                    }

                    // 2. Fuzzy Search (Cari yang mengandung rx/tx dan punya nilai > 0)
                    for (let key in net) {
                        if (key.toLowerCase().includes(type)) {
                            const val = parseFloat(net[key]);
                            if (!isNaN(val) && val > 0 && !key.includes('cumulative') && !key.includes(
                                    'total')) {
                                return val;
                            }
                        }
                    }

                    return 0;
                },

                formatBytes(bytes, decimals = 2) {
                    const b = parseFloat(bytes);
                    if (isNaN(b) || b <= 0) return '0 B';
                    const k = 1024;
                    const dm = decimals < 0 ? 0 : decimals;
                    const sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
                    const i = Math.floor(Math.log(b) / Math.log(k));
                    const unit = sizes[i] || 'B';
                    return parseFloat((b / Math.pow(k, i)).toFixed(dm)) + ' ' + unit;
                },

                calculateLocalIp(data) {
                    if (!data) return '--';

                    // 1. Koleksi semua kemungkinan field IP
                    const possibleIps = [
                        data.ip_forwarded,
                        data.ip,
                        data.public_ip,
                        data.system?.ip,
                        data.core?.ip,
                        data.core?.public_ip?.address,
                        data.core?.public_ip
                    ];

                    // Cek di array ip_list (versi Glances tertentu)
                    if (data.ip_list && Array.isArray(data.ip_list)) {
                        data.ip_list.forEach(item => {
                            if (typeof item === 'string') possibleIps.push(item);
                            else if (item.address) possibleIps.push(item.address);
                        });
                    }

                    // 2. Filter dan cari yang valid (bukan loopback)
                    for (let rawIp of possibleIps) {
                        const formatted = this.formatIp(rawIp);
                        if (formatted && formatted !== '--' && formatted !== '127.0.0.1' &&
                            formatted !== '::1' && formatted !== 'localhost') {
                            return formatted;
                        }
                    }

                    // 3. Scan list network interfaces secara mendalam
                    if (data.network && Array.isArray(data.network)) {
                        for (let net of data.network) {
                            const netIp = net.ip || net.address || net.inet || (Array.isArray(net.ips) ?
                                net.ips[0] : null);
                            const formatted = this.formatIp(netIp);
                            if (formatted && formatted !== '--' && formatted !== '127.0.0.1' &&
                                formatted !== '::1') {
                                return formatted;
                            }
                        }
                    }

                    return this.formatIp(data.ip);
                },

                formatIp(ip) {
                    if (!ip) return '--';
                    if (typeof ip === 'object') return ip.forwarded || ip.address || ip.ip || '--';
                    return ip;
                },

                getColorClass(value) {
                    const val = parseFloat(value);
                    if (val >= 90) return 'bg-red-500';
                    if (val >= 70) return 'bg-amber-500';
                    return 'bg-green-500';
                },

                getSparklinePoints(type) {
                    const data = this.history[type];
                    if (data.length < 2) return '';
                    const width = 120;
                    const height = 40;
                    const max = 100;

                    return data.map((val, i) => {
                        const x = (i / (this.historyLimit - 1)) * width;
                        const y = height - ((val / max) * height);
                        return `${x},${y}`;
                    }).join(' ');
                }
            }));
        });
    </script>
@endpush
