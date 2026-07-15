{{--
    Goal: Halaman utama monitoring server dengan CRUD dan visualisasi uptime.
    Livewire: system.server-overview
    Alpine: serverMonitor() — didefinisikan di @push('script') bawah, diinisialisasi oleh x-server.card.
--}}
<div
    class="mx-auto max-w-screen-2xl rounded-2xl border border-white/60 p-4 shadow-zinc-200/50 dark:border-zinc-800 dark:shadow-black/30 md:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

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

            <x-server.card :server="$server" :blocks="$blocks" :uptimePct="$uptimePct" :latestLog="$latestLog" />
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

    {{-- Pagination --}}
    @if ($this->totalPages() > 1)
        <div class="mt-6 flex items-center justify-between border-t border-zinc-200 pt-4 dark:border-zinc-800">
            <p class="text-sm text-zinc-500">
                Menampilkan
                <span class="font-semibold text-zinc-700 dark:text-zinc-200">
                    {{ ($page - 1) * $perPage + 1 }}–{{ min($page * $perPage, $totalServers) }}
                </span>
                dari <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $totalServers }}</span> server
            </p>

            <div class="flex items-center gap-2">
                <button wire:click="prevPage" @disabled($page <= 1)
                    class="inline-flex items-center gap-1.5 rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm font-medium text-zinc-700 transition-all hover:bg-zinc-50 disabled:cursor-not-allowed disabled:opacity-40 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.79 5.23a.75.75 0 0 1-.02 1.06L8.832 10l3.938 3.71a.75.75 0 1 1-1.04 1.08l-4.5-4.25a.75.75 0 0 1 0-1.08l4.5-4.25a.75.75 0 0 1 1.06.02z"
                            clip-rule="evenodd" />
                    </svg>
                    Sebelumnya
                </button>

                <span class="px-2 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ $page }} / {{ $this->totalPages() }}
                </span>

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

    {{-- Modal Form Tambah/Edit Server --}}
    <x-server.form-modal :serverId="$serverId" />

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

                        const cpuTotal = data.cpu && data.cpu.total !== undefined ? data.cpu.total :
                            0;
                        const memPercent = data.mem && data.mem.percent !== undefined ? data.mem
                            .percent : 0;

                        let diskPercent = 0;
                        if (data.fs && data.fs.length > 0) {
                            const rootFs = data.fs.find(f => f.mnt_point === '/' || f
                                .device_name === '/dev/root' || f.mnt_point?.includes(':'));
                            diskPercent = rootFs?.percent ?? data.fs[0].percent ?? 0;
                        }

                        this.stats = {
                            cpu: parseFloat(cpuTotal).toFixed(1),
                            mem: parseFloat(memPercent).toFixed(1),
                            disk: parseFloat(diskPercent).toFixed(1),
                            net_rx: this.calculateTotalNet(data.network, 'rx'),
                            net_tx: this.calculateTotalNet(data.network, 'tx'),
                        };

                        this.sysInfo = {
                            os: (data.system.os_name || '') + ' ' + (data.system.os_version ||
                                ''),
                            uptime: data.uptime || '--',
                            ip: this.manualIp || this.calculateLocalIp(data)
                        };

                        ['cpu', 'mem', 'disk'].forEach(type => {
                            if (!this.history[type]) this.history[type] = [];
                            this.history[type].push(parseFloat(this.stats[type]));
                            if (this.history[type].length > this.historyLimit) {
                                this.history[type].shift();
                            }
                        });

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
                    return networks.reduce((acc, net) => acc + parseFloat(this.getNetRate(net, type)),
                        0);
                },

                getNetRate(net, type) {
                    if (!net) return 0;
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
                    const sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
                    const i = Math.floor(Math.log(b) / Math.log(k));
                    return parseFloat((b / Math.pow(k, i)).toFixed(decimals < 0 ? 0 : decimals)) + ' ' +
                        (sizes[i] || 'B');
                },

                calculateLocalIp(data) {
                    if (!data) return '--';
                    const possibleIps = [
                        data.ip_forwarded, data.ip, data.public_ip,
                        data.system?.ip, data.core?.ip,
                        data.core?.public_ip?.address, data.core?.public_ip
                    ];

                    if (data.ip_list && Array.isArray(data.ip_list)) {
                        data.ip_list.forEach(item => {
                            if (typeof item === 'string') possibleIps.push(item);
                            else if (item.address) possibleIps.push(item.address);
                        });
                    }

                    for (let rawIp of possibleIps) {
                        const formatted = this.formatIp(rawIp);
                        if (formatted && formatted !== '--' && formatted !== '127.0.0.1' &&
                            formatted !== '::1' && formatted !== 'localhost') {
                            return formatted;
                        }
                    }

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
