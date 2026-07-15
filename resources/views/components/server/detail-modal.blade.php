{{--
    Goal: Modal detail metrics server (CPU, Mem, Disk, Network, Processes).
    Livewire: system.server-overview
    Alpine: Dibaca dari scope serverMonitor() parent (showDetails, fullData, sysInfo, processes, dll)
--}}
@props(['server'])

<x-modal.base-modal show="showDetails" :isAlpine="true" maxWidth="4xl" title="Detail Server: {{ $server->name }}"
    iconContainerClass="bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">

    <x-slot name="icon">
        <x-icons.computer class="h-6 w-6" />
    </x-slot>

    {{-- OS Info Bar --}}
    <div class="mb-6 rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <p class="font-medium text-zinc-600 dark:text-zinc-400" x-text="'OS System: ' + sysInfo.os"></p>
    </div>

    {{-- Stats Grid: CPU / Memory / Network --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

        {{-- CPU & System --}}
        <div class="space-y-4 rounded-xl border border-zinc-100 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <h4 class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-zinc-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2-2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
                Processor
            </h4>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-zinc-500">Model</span>
                    <span class="text-right font-medium text-zinc-900 dark:text-zinc-200"
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
                    <svg class="h-full w-full" viewBox="0 0 120 40" preserveAspectRatio="none">
                        <polyline fill="none" class="stroke-blue-500 dark:stroke-blue-400" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" :points="getSparklinePoints('cpu')" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Memory --}}
        <div class="space-y-4 rounded-xl border border-zinc-100 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <h4 class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-zinc-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
                    <svg class="h-full w-full" viewBox="0 0 120 40" preserveAspectRatio="none">
                        <polyline fill="none" class="stroke-purple-500 dark:stroke-purple-400" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" :points="getSparklinePoints('mem')" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Network Summary --}}
        <div class="space-y-4 rounded-xl border border-zinc-100 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <h4 class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-zinc-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                </svg>
                Network
            </h4>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-zinc-500">IP Public</span>
                    <span class="font-mono font-medium text-zinc-900 dark:text-zinc-200"
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
        <h4 class="mb-3 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400">NETWORK INTERFACES</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-zinc-100 dark:border-zinc-800">
                        <th class="py-2 font-medium text-zinc-500">Interface</th>
                        <th class="py-2 text-center font-medium text-zinc-500">Status</th>
                        <th class="py-2 font-medium text-zinc-500">IP Address</th>
                        <th class="py-2 font-medium text-zinc-500">Download (Rx)</th>
                        <th class="py-2 font-medium text-zinc-500">Upload (Tx)</th>
                        <th class="py-2 font-medium text-zinc-500">Cumulative</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="net in fullData?.network" :key="net.interface_name">
                        <tr class="border-b border-zinc-50 dark:border-zinc-900/50">
                            <td class="py-3 font-medium dark:text-zinc-300" x-text="net.interface_name"></td>
                            <td class="py-3 text-center">
                                <span class="inline-flex h-2 w-2 rounded-full"
                                    :class="net.is_up ? 'bg-green-500' : 'bg-red-500'"></span>
                            </td>
                            <td class="py-3 font-mono text-xs text-zinc-500" x-text="net.ip || net.address || '--'">
                            </td>
                            <td class="py-3 font-mono text-xs dark:text-green-400"
                                x-text="formatBytes(getNetRate(net, 'rx')) + '/s'"></td>
                            <td class="py-3 font-mono text-xs dark:text-blue-400"
                                x-text="formatBytes(getNetRate(net, 'tx')) + '/s'"></td>
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
        <h4 class="mb-3 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400">DISK FILESYSTEMS</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-zinc-100 dark:border-zinc-800">
                        <th class="py-2 font-medium text-zinc-500">Mount Point</th>
                        <th class="py-2 font-medium text-zinc-500">Device</th>
                        <th class="whitespace-nowrap py-2 font-medium text-zinc-500">Total</th>
                        <th class="py-2 font-medium text-zinc-500">Used</th>
                        <th class="whitespace-nowrap py-2 font-medium text-zinc-500">Usage %</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="fs in fullData?.fs" :key="fs.mnt_point">
                        <tr class="border-b border-zinc-50 dark:border-zinc-900/50">
                            <td class="py-3 font-medium dark:text-zinc-300" x-text="fs.mnt_point"></td>
                            <td class="py-3 text-zinc-500" x-text="fs.device_name"></td>
                            <td class="whitespace-nowrap py-3 dark:text-zinc-400"
                                x-text="(fs.size / 1024 / 1024 / 1024).toFixed(1) + ' GB'"></td>
                            <td class="whitespace-nowrap py-3 dark:text-zinc-400"
                                x-text="(fs.used / 1024 / 1024 / 1024).toFixed(1) + ' GB'"></td>
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="h-1 w-16 overflow-hidden whitespace-nowrap rounded-full bg-zinc-100 dark:bg-zinc-800">
                                        <div class="h-full" :style="`width: ${fs.percent}%`"
                                            :class="fs.percent > 90 ? 'bg-red-500' : 'bg-blue-500'"></div>
                                    </div>
                                    <span class="font-mono text-xs" x-text="fs.percent + '%'"></span>
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
        <div class="mb-3 flex items-center justify-between border-b border-zinc-100 pb-2 dark:border-zinc-800">
            <h4 class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400">TOP PROCESSES</h4>
            <span class="font-mono text-[10px] text-zinc-400 opacity-50">SORTED BY CPU %</span>
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
                            class="border-b border-zinc-50 transition-colors last:border-0 hover:bg-zinc-50/50 dark:border-zinc-900/40 dark:hover:"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                            <td class="max-w-[150px] truncate py-2.5 font-medium dark:text-zinc-300" x-text="p.name">
                            </td>
                            <td class="py-2.5 text-right font-mono font-bold"
                                :class="parseFloat(p.cpu_percent) > 50 ? 'text-red-500' : 'text-zinc-700 dark:text-zinc-300'"
                                x-text="(p.cpu_percent || 0).toFixed(1) + '%'"></td>
                            <td class="py-2.5 text-right font-mono text-zinc-500"
                                x-text="(p.memory_percent || 0).toFixed(1) + '%'"></td>
                            <td class="px-2 py-2.5 text-right text-zinc-400" x-text="p.username || 'root'"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

</x-modal.base-modal>
