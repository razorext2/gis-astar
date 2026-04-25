<div x-data="{
    map: null,
    markers: {},
    activeIndex: null,
    waypoints: @js($this->waypoints),
    initMap() {
        if (this.map) {
            this.map.remove();
            this.map = null;
        }
        this.markers = {};
        this.activeIndex = null;

        const pts = this.waypoints; // already a JS array — no JSON.parse() needed
        const defaultCoord = [3.5915, 98.6690];

        this.map = L.map('sales-route-map').setView(defaultCoord, 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(this.map);

        if (pts.length === 0) return;

        const icon = L.icon({
            iconUrl: '{{ asset('assets/img/marker.png') }}',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            shadowUrl: '{{ asset('assets/img/marker-shadow.png') }}',
            shadowSize: [41, 41]
        });

        const latlngs = pts.map(p => L.latLng(p.lat, p.lng));

        // Instantiate markers and store references for focusPin,
        // keyed by ID so we can look them up even if timeline items are skipped
        pts.forEach((p, i) => {
            const marker = L.marker(latlngs[i], { icon })
                .bindPopup(`<b>${p.name}</b>`);
            this.markers[p.id] = marker;
        });

        if (latlngs.length > 1) {
            this.map.fitBounds(L.latLngBounds(latlngs));

            L.Routing.control({
                waypoints: latlngs,
                routeWhileDragging: false,
                // Pass the pre-created markers to Routing Control.
                createMarker: (i, wp) => this.markers[pts[i].id],
                router: L.Routing.osrmv1({ serviceUrl: 'https://router.project-osrm.org/route/v1/' }),
                show: false
            }).addTo(this.map);
        } else if (latlngs.length === 1) {
            this.map.setView(latlngs[0], 15);
            // Manually add the single marker since there's no Routing.control
            this.markers[pts[0].id].addTo(this.map);
        }
    },
    focusPin(id) {
        this.activeIndex = id;
        const marker = this.markers[id];
        if (!marker) return;
        this.map.flyTo(marker.getLatLng(), 17, { duration: 0.8 });
        marker.openPopup();
    }
}" x-init="initMap()"
    x-on:map-waypoints-updated.window="waypoints = $event.detail.waypoints; activeIndex = null; $nextTick(() => initMap())"
    class="grid w-full gap-6 md:grid-cols-2">

    {{-- Left column: header + timeline --}}
    <div
        class="flex w-full flex-col gap-5 rounded-3xl border border-zinc-200 bg-white/70 p-5 shadow-sm backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/70 md:p-6">

        {{-- Header --}}
        <div class="flex items-center gap-3 border-b border-zinc-200 pb-5 dark:border-zinc-800/50">
            <a href="{{ route('routes.sales') }}"
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-zinc-200 bg-white text-zinc-500 transition hover:border-red-300 hover:bg-red-50 hover:text-red-600 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-400 dark:hover:border-red-800 dark:hover:bg-red-950/20 dark:hover:text-red-400">
                <x-icons.angle-left class="h-5 w-5" />
            </a>
            <div>
                <h2 class="text-xl font-black tracking-tight text-zinc-900 dark:text-white">
                    {{ $this->pegawai->full_name ?? 'N/A' }}
                </h2>
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
                    Laporan Rute &mdash; {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('D MMMM YYYY') }}
                </p>
            </div>
        </div>

        {{-- Date filter --}}
        <div class="flex items-center gap-3">
            <input type="date" wire:model.live="date"
                class="block w-full rounded-xl border border-zinc-200 bg-white/50 px-4 py-2.5 text-sm font-medium text-zinc-900 backdrop-blur-sm transition-all focus:border-emerald-500 focus:ring-emerald-500 dark:border-zinc-800 dark:bg-zinc-900/50 dark:text-white">

            <div
                class="shrink-0 rounded-2xl border border-emerald-100 bg-emerald-50/50 px-4 py-2.5 text-xs font-bold text-emerald-700 dark:border-emerald-900/30 dark:bg-emerald-950/20 dark:text-emerald-400">
                {{ $this->report->count() }} titik
            </div>
        </div>

        {{-- Timeline --}}
        <ol class="relative ms-3 border-s border-zinc-200 dark:border-zinc-800">
            @forelse ($this->report as $data)
                @php
                    $hasPrev = !$loop->first && $data->latitude;
                    $prevRecord = $hasPrev ? $this->report[$loop->index - 1] : null;
                    $diffInMinutes = $hasPrev
                        ? round(\Carbon\Carbon::parse($prevRecord->created_at)->diffInMinutes($data->created_at, true))
                        : null;
                    $distance = $hasPrev
                        ? countDistance(
                            $prevRecord->latitude,
                            $prevRecord->longitude,
                            $data->latitude,
                            $data->longitude,
                        )
                        : null;
                @endphp

                <li class="relative mb-8 ms-8" @click="focusPin({{ $data->id }})">
                    {{-- Dot — center aligned with border-s --}}
                    <span
                        class="absolute -start-11 flex h-6 w-6 items-center justify-center rounded-full shadow-lg ring-4 ring-white transition-colors duration-200 dark:ring-zinc-900"
                        :class="activeIndex === {{ $data->id }} ? 'bg-blue-600 shadow-blue-500/20' :
                            'bg-emerald-600 shadow-emerald-500/20'">
                        <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0-2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </span>

                    {{-- Content --}}
                    <div class="cursor-pointer rounded-2xl border p-3 transition-all duration-200"
                        :class="activeIndex === {{ $data->id }} ?
                            'border-blue-300 bg-blue-50/60 dark:border-blue-800/50 dark:bg-blue-950/20' :
                            'border-zinc-200 bg-zinc-50/50 hover:border-zinc-200 hover:bg-zinc-100/50 dark:border-zinc-800/50 dark:bg-zinc-900/30 dark:hover:bg-zinc-800/30'">
                        <div class="mb-1 flex flex-wrap items-start justify-between gap-2">
                            <a href="{{ route('sales.show', $data->id) }}" target="_blank"
                                class="group flex items-center gap-1 text-sm font-black text-zinc-900 hover:text-emerald-600 dark:text-white dark:hover:text-emerald-400">
                                {{ $data->title }}
                                <x-icons.arrow-right
                                    class="h-3.5 w-3.5 -rotate-45 opacity-0 transition-opacity group-hover:opacity-100" />
                            </a>

                            @if ($data->status == 0)
                                <span
                                    class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">Perlu
                                    Verifikasi</span>
                            @elseif ($data->status == 1)
                                <span
                                    class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">Disetujui</span>
                            @else
                                <span
                                    class="rounded-full bg-red-100 px-2 py-0.5 text-[10px] font-bold text-red-800 dark:bg-red-900/30 dark:text-red-400">Ditolak</span>
                            @endif
                        </div>

                        <time class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                            {{ $data->created_at->locale('id')->isoFormat('DD MMM YYYY, HH:mm:ss') }}
                        </time>

                        @if ($hasPrev && ($distance || $diffInMinutes))
                            <div
                                class="mt-2 flex flex-wrap gap-2 border-t border-zinc-200 pt-2 dark:border-zinc-800/50">
                                @if ($distance)
                                    <span
                                        class="flex items-center gap-1 rounded-xl bg-blue-50 px-2.5 py-1 text-[11px] font-bold text-blue-700 dark:bg-blue-950/20 dark:text-blue-400">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        +{{ $distance }}
                                    </span>
                                @endif
                                @if ($diffInMinutes !== null)
                                    <span
                                        class="flex items-center gap-1 rounded-xl bg-zinc-100 px-2.5 py-1 text-[11px] font-bold text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                                        <x-icons.clock class="h-3 w-3" />
                                        ~{{ $diffInMinutes }} menit
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </li>
            @empty
                <li class="flex flex-col items-center justify-center py-12 text-center">
                    <div
                        class="mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-zinc-50 text-zinc-400 dark:bg-zinc-900">
                        <x-icons.question-circle class="h-6 w-6" />
                    </div>
                    <p class="text-sm font-bold text-zinc-900 dark:text-white">Tidak Ada Data</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Tidak ada laporan rute pada tanggal ini.</p>
                </li>
            @endforelse
        </ol>
    </div>

    {{-- Right column: map --}}
    <div
        class="flex h-max w-full flex-col gap-5 rounded-3xl border border-zinc-200 bg-white/70 p-5 shadow-sm backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/70 md:p-6">
        <div class="flex items-center gap-3 border-b border-zinc-200 pb-4 dark:border-zinc-800/50">
            <div
                class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-500/20">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-black tracking-tight text-zinc-900 dark:text-white">Peta Rute</h3>
            </div>
        </div>

        <div id="sales-route-map" wire:ignore
            class="z-10 h-[520px] w-full overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-800">
        </div>
    </div>
</div>
