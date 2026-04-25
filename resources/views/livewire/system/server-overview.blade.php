<div
    class="mx-auto max-w-screen-2xl rounded-2xl border border-white/60 bg-white/70 p-4 shadow-lg shadow-zinc-200/50 backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60 dark:shadow-black/30 md:p-6">


    {{-- Column Headers --}}
    @if (count($servers) > 0)
        <div class="mb-1 hidden grid-cols-[220px_1fr_1fr_1fr_68px] gap-4 px-4 text-[11px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-600 lg:grid">
            <span>Server</span>
            <span>CPU</span>
            <span>Memori</span>
            <span>Disk</span>
            <span></span>
        </div>
    @endif

    {{-- Server Rows --}}
    <div class="space-y-2">
        @foreach ($servers as $server)
            @php
                $blocks    = $this->computeUptimeBlocks($server);
                $uptimePct = $this->computeUptimePct30Days($server);
                $latestLog = \App\Models\ServerMonitorLog::where('server_monitor_id', $server->id)
                                 ->orderByDesc('logged_at')->first();
            @endphp

            <div class="group rounded-xl border border-zinc-200 bg-white px-4 py-3.5 transition-colors hover:bg-zinc-50 dark:border-zinc-800 dark:bg-[#09090b] dark:hover:bg-zinc-900"
                @if ($server->is_active) x-data="serverMonitor({{ $server->id }})" x-init="startPolling()" @endif>

                {{-- Baris 1: Info + Metrics + Actions --}}
                <div class="flex flex-col gap-4 lg:grid lg:grid-cols-[220px_1fr_1fr_1fr_68px] lg:items-center">

                    {{-- ① Server Identity --}}
                    <div class="flex min-w-0 items-center gap-3">
                        <div @class([
                            'flex h-9 w-9 shrink-0 items-center justify-center rounded-full',
                            'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400' => $server->is_active,
                            'bg-zinc-100 text-zinc-400 dark:bg-zinc-800' => !$server->is_active,
                        ])>
                            <x-icons.computer class="h-4 w-4" />
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $server->name }}</p>
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
                                <span class="truncate font-mono text-[11px] text-zinc-500 dark:text-zinc-400" title="{{ $server->api_url }}">
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
                        <div>
                            <div class="mb-1 flex justify-between text-xs">
                                <span class="text-zinc-500 dark:text-zinc-400 lg:hidden">CPU</span>
                                <span class="font-mono text-zinc-700 dark:text-zinc-300" x-show="!loading" x-text="stats.cpu + '%'"></span>
                                <span class="font-mono text-zinc-400" x-show="loading">--</span>
                            </div>
                            <div class="h-1.5 w-full rounded-full bg-zinc-100 dark:bg-zinc-800">
                                <div class="h-1.5 rounded-full transition-all duration-1000 ease-in-out"
                                    :class="getColorClass(stats.cpu)" :style="`width: ${stats.cpu}%`"></div>
                            </div>
                        </div>

                        {{-- ③ Memori --}}
                        <div>
                            <div class="mb-1 flex justify-between text-xs">
                                <span class="text-zinc-500 dark:text-zinc-400 lg:hidden">Memori</span>
                                <span class="font-mono text-zinc-700 dark:text-zinc-300" x-show="!loading" x-text="stats.mem + '%'"></span>
                                <span class="font-mono text-zinc-400" x-show="loading">--</span>
                            </div>
                            <div class="h-1.5 w-full rounded-full bg-zinc-100 dark:bg-zinc-800">
                                <div class="h-1.5 rounded-full transition-all duration-1000 ease-in-out"
                                    :class="getColorClass(stats.mem)" :style="`width: ${stats.mem}%`"></div>
                            </div>
                        </div>

                        {{-- ④ Disk --}}
                        <div>
                            <div class="mb-1 flex justify-between text-xs">
                                <span class="text-zinc-500 dark:text-zinc-400 lg:hidden">Disk</span>
                                <span class="font-mono text-zinc-700 dark:text-zinc-300" x-show="!loading" x-text="stats.disk + '%'"></span>
                                <span class="font-mono text-zinc-400" x-show="loading">--</span>
                            </div>
                            <div class="h-1.5 w-full rounded-full bg-zinc-100 dark:bg-zinc-800">
                                <div class="h-1.5 rounded-full transition-all duration-1000 ease-in-out"
                                    :class="getColorClass(stats.disk)" :style="`width: ${stats.disk}%`"></div>
                            </div>
                        </div>
                    @else
                        {{-- Inactive placeholder --}}
                        <div class="lg:col-span-3">
                            <span class="text-xs italic text-zinc-400">Pemantauan dinonaktifkan</span>
                        </div>
                    @endif

                    {{-- ⑥ Actions --}}
                    <div class="flex items-center justify-end gap-1.5">
                        <button wire:click="edit({{ $server->id }})"
                            class="rounded-lg bg-zinc-100 p-1.5 text-zinc-500 transition-colors hover:bg-blue-50 hover:text-blue-500 dark:bg-zinc-800 dark:hover:text-blue-400"
                            title="Edit">
                            <x-icons.pen class="h-4 w-4" />
                        </button>
                        <button wire:confirm="Yakin ingin menghapus monitoring server ini?"
                            wire:click="delete({{ $server->id }})"
                            class="rounded-lg bg-zinc-100 p-1.5 text-zinc-500 transition-colors hover:bg-red-50 hover:text-red-500 dark:bg-zinc-800"
                            title="Hapus">
                            <x-icons.trash class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                {{-- Baris 2: Uptime Line Chart (full width) --}}
                @php
                    $cw = 1000; $ch = 160; $pad = 4;
                    $chartPts = [];
                    $count = count($blocks);
                    foreach ($blocks as $i => $block) {
                        $pct = $block['has_data'] ? (float) $block['uptime_pct'] : 100.0;
                        $x = round(($i / max($count - 1, 1)) * $cw, 2);
                        $y = round($ch - $pad - (($pct / 100) * ($ch - $pad * 2)), 2);
                        $chartPts[] = [$x, $y, $block['date'], $block['label'], $block['has_data']];
                    }
                    $linePoints = implode(' ', array_map(fn($p) => $p[0].','.$p[1], $chartPts));
                    $firstPt = $chartPts[0]; $lastPt = end($chartPts);
                    $areaPath = 'M'.$firstPt[0].','.$firstPt[1]
                        .' '.implode(' ', array_map(fn($p) => 'L'.$p[0].','.$p[1], array_slice($chartPts, 1)))
                        .' L'.$lastPt[0].','.$ch.' L'.$firstPt[0].','.$ch.' Z';
                    $lineColor = $uptimePct === null ? '#a1a1aa'
                        : ($uptimePct >= 99 ? '#22c55e' : ($uptimePct >= 90 ? '#f59e0b' : ($uptimePct >= 50 ? '#f97316' : '#ef4444')));
                    $gradId = 'ug'.$server->id;
                @endphp

                <div class="mt-3 border-t border-zinc-100 pt-3 dark:border-zinc-800">
                    <div class="mb-1.5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-medium text-zinc-400">Uptime 30 Hari</span>
                            @if ($latestLog)
                                <span @class([
                                    'inline-flex items-center gap-1 rounded-full px-1.5 py-0.5 text-[10px] font-medium',
                                    'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' => $latestLog->status === 'online',
                                    'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'         => $latestLog->status === 'offline',
                                ])>
                                    <span class="{{ $latestLog->status === 'online' ? 'bg-green-500' : 'bg-red-500' }} h-1.5 w-1.5 rounded-full"></span>
                                    {{ ucfirst($latestLog->status) }} · {{ $latestLog->logged_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                        @if ($uptimePct !== null)
                            <span @class([
                                'text-[10px] font-semibold',
                                'text-green-600 dark:text-green-400'   => $uptimePct >= 99,
                                'text-amber-600 dark:text-amber-400'   => $uptimePct >= 90 && $uptimePct < 99,
                                'text-orange-600 dark:text-orange-400' => $uptimePct >= 50 && $uptimePct < 90,
                                'text-red-600 dark:text-red-400'       => $uptimePct < 50,
                            ])>{{ number_format($uptimePct, 1) }}%</span>
                        @else
                            <span class="text-[10px] text-zinc-400">–</span>
                        @endif
                    </div>

                    <svg viewBox="0 0 {{ $cw }} {{ $ch }}" class="w-full" style="height:160px" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="{{ $gradId }}" x1="0" x2="0" y1="0" y2="1">
                                <stop offset="0%"   stop-color="{{ $lineColor }}" stop-opacity="0.25"/>
                                <stop offset="100%" stop-color="{{ $lineColor }}" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <path d="{{ $areaPath }}" fill="url(#{{ $gradId }})"/>
                        <line x1="0" y1="{{ $pad }}" x2="{{ $cw }}" y2="{{ $pad }}" stroke="#a1a1aa" stroke-width="0.5" stroke-dasharray="6 4" opacity="0.35"/>
                        <polyline points="{{ $linePoints }}" fill="none" stroke="{{ $lineColor }}" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"/>
                        @foreach ($chartPts as $pt)
                            @if ($pt[4])
                                <circle cx="{{ $pt[0] }}" cy="{{ $pt[1] }}" r="2.5" fill="{{ $lineColor }}" opacity="0.55">
                                    <title>{{ $pt[2] }}: {{ $pt[3] }}</title>
                                </circle>
                            @endif
                        @endforeach
                    </svg>
                </div>
            </div>
        @endforeach

        @if (count($servers) === 0)
            <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-zinc-300 bg-zinc-50 py-16 text-center dark:border-zinc-700 dark:bg-[#09090b]">
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
                    {{ (($page - 1) * $perPage) + 1 }}–{{ min($page * $perPage, $totalServers) }}
                </span>
                dari <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $totalServers }}</span> server
            </p>

            <div class="flex items-center gap-2">
                {{-- Prev --}}
                <button
                    wire:click="prevPage"
                    @disabled($page <= 1)
                    class="inline-flex items-center gap-1.5 rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm font-medium text-zinc-700 transition-all hover:bg-zinc-50 disabled:cursor-not-allowed disabled:opacity-40 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 0 1-.02 1.06L8.832 10l3.938 3.71a.75.75 0 1 1-1.04 1.08l-4.5-4.25a.75.75 0 0 1 0-1.08l4.5-4.25a.75.75 0 0 1 1.06.02z" clip-rule="evenodd"/></svg>
                    Sebelumnya
                </button>

                {{-- Page indicator --}}
                <span class="px-2 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ $page }} / {{ $this->totalPages() }}
                </span>

                {{-- Next --}}
                <button
                    wire:click="nextPage"
                    @disabled($page >= $this->totalPages())
                    class="inline-flex items-center gap-1.5 rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm font-medium text-zinc-700 transition-all hover:bg-zinc-50 disabled:cursor-not-allowed disabled:opacity-40 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800">
                    Selanjutnya
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 0 1 .02-1.06L11.168 10 7.23 6.29a.75.75 0 1 1 1.04-1.08l4.5 4.25a.75.75 0 0 1 0 1.08l-4.5 4.25a.75.75 0 0 1-1.06-.02z" clip-rule="evenodd"/></svg>
                </button>
            </div>
        </div>
    @endif

    {{-- Modal diletakkan di luar container agar tidak terpotong oleh backdrop-blur parent --}}
    <div x-data="{ show: @entangle('showModal').live }">
        <template x-teleport="body">
            <div x-show="show"
                class="fixed inset-0 z-[100] overflow-y-auto"
                style="display: none;"
                aria-labelledby="modal-title"
                role="dialog"
                aria-modal="true">

                {{-- Overlay --}}
                <div x-show="show"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-zinc-900/50 backdrop-blur-sm transition-opacity"></div>

                <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                    {{-- Modal panel --}}
                    <div x-show="show"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-xl border border-zinc-200 bg-white text-left shadow-xl transition-all dark:border-zinc-800 dark:bg-zinc-900 sm:my-8 sm:w-full sm:max-w-lg">

                        <form wire:submit="save">
                            <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
                                        <h3 class="text-xl font-bold leading-6 text-zinc-900 dark:text-zinc-100"
                                            id="modal-title">
                                            {{ $serverId ? 'Edit Server' : 'Tambah Server Baru' }}
                                        </h3>

                                        <p class="mb-6 mt-1 text-sm text-zinc-500">Konfigurasi endpoint API Glances untuk
                                            monitoring.</p>

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
                                                <p class="mt-1 text-xs text-zinc-500">Masukkan URL Glances tanpa trailing slash
                                                    dan tanpa <code>/api/4/all</code>.</p>
                                                @error('api_url')
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
                                </div>
                            </div>

                            <div class="mt-4 gap-2 border-t border-zinc-200 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-zinc-800/50 sm:flex sm:flex-row-reverse sm:px-6">
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
            Alpine.data('serverMonitor', (serverId) => ({
                loading: true,
                error: false,
                pollInterval: null,
                stats: {
                    cpu: 0,
                    mem: 0,
                    disk: 0
                },

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
                        };

                        this.error = false;
                    } catch (e) {
                        console.error('Glances fetch error for server ' + serverId, e);
                        this.error = true;
                    } finally {
                        this.loading = false;
                    }
                },

                getColorClass(value) {
                    const val = parseFloat(value);
                    if (val >= 90) return 'bg-red-500';
                    if (val >= 70) return 'bg-amber-500';
                    return 'bg-green-500';
                }
            }));
        });
    </script>
@endpush
