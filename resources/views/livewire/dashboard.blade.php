{{-- SIPROMATA Dashboard --}}
<div class="flex flex-col gap-5">

    {{-- ── 1. Stat Cards ──────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        {{-- Total Pasien --}}
        <div class="flex items-center gap-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-950/50">
                <svg class="h-7 w-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-zinc-400 dark:text-zinc-500">Total Pasien</p>
                <p class="text-3xl font-black text-zinc-900 dark:text-white">{{ number_format($stats['total_pasien']) }}</p>
                <p class="text-xs text-zinc-400">Pasien</p>
            </div>
        </div>

        {{-- Total Rumah Sakit --}}
        <div class="flex items-center gap-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/50">
                <svg class="h-7 w-7 text-emerald-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" /></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-zinc-400 dark:text-zinc-500">Total Rumah Sakit</p>
                <p class="text-3xl font-black text-zinc-900 dark:text-white">{{ number_format($stats['total_rs']) }}</p>
                <p class="text-xs text-zinc-400">Rumah Sakit</p>
            </div>
        </div>

        {{-- Total Rujukan --}}
        <div class="flex items-center gap-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-950/50">
                <svg class="h-7 w-7 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" /></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-zinc-400 dark:text-zinc-500">Total Rujukan</p>
                <p class="text-3xl font-black text-zinc-900 dark:text-white">{{ number_format($stats['total_rujukan']) }}</p>
                <p class="text-xs text-zinc-400">Rujukan</p>
            </div>
        </div>

        {{-- Rujukan Hari Ini --}}
        <div class="flex items-center gap-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-50 dark:bg-red-950/50">
                <svg class="h-7 w-7 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-zinc-400 dark:text-zinc-500">Rujukan Hari Ini</p>
                <p class="text-3xl font-black text-zinc-900 dark:text-white">{{ number_format($stats['rujukan_hari_ini']) }}</p>
                <p class="text-xs text-zinc-400">Rujukan</p>
            </div>
        </div>

    </div>

    {{-- ── 2. Map + Tabel Rujukan Terbaru ─────────────────────────────────── --}}
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-5">

        {{-- Peta Sebaran --}}
        <div class="lg:col-span-3 rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
            <h2 class="mb-3 text-sm font-bold text-zinc-800 dark:text-white">Peta Sebaran Pasien &amp; Rumah Sakit Rujukan</h2>
            <div id="sipromata-map" class="h-72 w-full rounded-xl overflow-hidden border border-zinc-100 dark:border-zinc-700"></div>
            <div class="mt-3 flex items-center gap-5 text-xs text-zinc-500">
                <span class="flex items-center gap-1.5">
                    <span class="inline-block h-3 w-3 rounded-full bg-blue-500"></span>Lokasi Pasien
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="inline-block h-3 w-3 rounded-full bg-red-500"></span>Rumah Sakit Rujukan
                </span>
            </div>
        </div>

        {{-- Rujukan Terbaru --}}
        <div class="lg:col-span-2 flex flex-col rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
            <div class="mb-3 flex items-center justify-between">
                <h2 class="text-sm font-bold text-zinc-800 dark:text-white">Rujukan Terbaru</h2>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">
                            <th class="pb-2 text-left font-semibold text-zinc-400 w-6">No</th>
                            <th class="pb-2 text-left font-semibold text-zinc-400">Pasien</th>
                            <th class="pb-2 text-left font-semibold text-zinc-400">Tujuan Rujukan</th>
                            <th class="pb-2 text-left font-semibold text-zinc-400">Jarak</th>
                            <th class="pb-2 text-left font-semibold text-zinc-400">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800/50">
                        @forelse($rujukanTerbaru as $r)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                <td class="py-2.5 text-zinc-400">{{ $r['no'] }}</td>
                                <td class="py-2.5 font-medium text-zinc-700 dark:text-zinc-300">{{ Str::limit($r['pasien'], 14) }}</td>
                                <td class="py-2.5 text-zinc-500 dark:text-zinc-400">{{ Str::limit($r['rumah_sakit'], 16) }}</td>
                                <td class="py-2.5 text-zinc-500">{{ $r['jarak'] }}</td>
                                <td class="py-2.5 text-zinc-400">{{ $r['tanggal'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-zinc-400">Belum ada rujukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                <a href="{{ route('riwayat.index') }}" wire:navigate
                   class="inline-flex items-center gap-1 rounded-xl border border-zinc-200 dark:border-zinc-700 px-4 py-1.5 text-xs font-semibold text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors float-right">
                    Lihat Semua
                </a>
            </div>
        </div>
    </div>

    {{-- ── 3. Grafik Rujukan per Bulan ─────────────────────────────────────── --}}
    <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary"
         x-data="{
            chart: null,
            chartData: {{ Js::from($chartData) }},
            initChart() {
                const ctx = document.getElementById('rujukanChart').getContext('2d');
                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
                        datasets: [{
                            label: 'Rujukan',
                            data: this.chartData,
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239,68,68,0.08)',
                            borderWidth: 2,
                            pointBackgroundColor: '#ef4444',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 20, color: '#a1a1aa' },
                                grid: { color: 'rgba(161,161,170,0.15)' },
                            },
                            x: {
                                ticks: { color: '#a1a1aa' },
                                grid: { display: false },
                            }
                        }
                    }
                });
            }
         }"
         x-init="initChart()"
         wire:ignore>
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-sm font-bold text-zinc-800 dark:text-white">Grafik Rujukan per Bulan</h2>
            <select wire:model.live="selectedYear"
                class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 py-1.5 text-xs font-medium text-zinc-700 dark:text-zinc-300 focus:outline-none focus:ring-2 focus:ring-red-500/30">
                @foreach($availableYears as $year)
                    <option value="{{ $year }}">Tahun {{ $year }}</option>
                @endforeach
            </select>
        </div>
        <div class="h-52">
            <canvas id="rujukanChart"></canvas>
        </div>
    </div>

</div>

{{-- Leaflet Map & Chart Init --}}
@script
<script>
    const pasienCoords = @json($pasienCoords);
    const rsCoords     = @json($rsCoords);

    const defaultLat = pasienCoords[0]?.lat ?? rsCoords[0]?.lat ?? 3.5952;
    const defaultLng = pasienCoords[0]?.lng ?? rsCoords[0]?.lng ?? 98.6722;

    const mapEl = document.getElementById('sipromata-map');
    if (mapEl && !mapEl._leaflet_id) {
        const map = L.map('sipromata-map').setView([defaultLat, defaultLng], 12);

        L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps',
        }).addTo(map);

        const pasienIcon = L.divIcon({
            className: '',
            html: '<div style="width:12px;height:12px;background:#3b82f6;border:2px solid white;border-radius:50%;box-shadow:0 1px 4px rgba(0,0,0,.3)"></div>',
            iconSize: [12, 12],
            iconAnchor: [6, 6],
        });
        pasienCoords.forEach(p => {
            L.marker([p.lat, p.lng], { icon: pasienIcon })
             .addTo(map)
             .bindPopup(`<b>Pasien</b><br>${p.nama}`);
        });

        const rsIcon = L.divIcon({
            className: '',
            html: '<div style="width:16px;height:16px;background:#ef4444;border:2px solid white;border-radius:4px;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,.3);font-size:10px;color:white;font-weight:bold">+</div>',
            iconSize: [16, 16],
            iconAnchor: [8, 8],
        });
        rsCoords.forEach(rs => {
            L.marker([rs.lat, rs.lng], { icon: rsIcon })
             .addTo(map)
             .bindPopup(`<b>RS</b><br>${rs.nama}`);
        });

        const allCoords = [...pasienCoords, ...rsCoords];
        if (allCoords.length > 1) {
            map.fitBounds(allCoords.map(c => [c.lat, c.lng]), { padding: [30, 30] });
        }
    }
</script>
@endscript

