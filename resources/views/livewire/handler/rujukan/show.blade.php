{{-- Goal: Detail rujukan + peta rute + riwayat status --}}
<div class="w-full space-y-4">

    {{-- Header --}}
    <div class="rounded-xl border border-zinc-200 p-6 shadow-sm dark:border-zinc-800"
        x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div class="flex items-center gap-4">
                <x-button.danger wire:navigate href="{{ route('riwayat.index') }}">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $rujukan->no_rujukan }}</h2>
                        @php $sc = ['pending'=>'bg-amber-100 text-amber-700','disetujui'=>'bg-emerald-100 text-emerald-700','ditolak'=>'bg-red-100 text-red-700','selesai'=>'bg-blue-100 text-blue-700'][$rujukan->status->value] @endphp
                        <span class="{{ $sc }} inline-block rounded-full px-3 py-1 text-xs font-semibold">
                            {{ $rujukan->status->label() }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">
                        {{ $rujukan->tanggal_rujukan->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }}</p>
                </div>
            </div>
            @can('rujukan-update-status')
                <x-button.primary href="{{ route('rujukan.update-status', $rujukan->id_rujukan) }}" wire:navigate>
                    Ubah Status
                </x-button.primary>
            @endcan
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        {{-- Info --}}
        <div class="space-y-4">
            {{-- Pasien --}}
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-4 flex items-center gap-3">
                    <div class="h-8 w-1 rounded-full bg-blue-600"></div>
                    <h3 class="font-bold">Data Pasien</h3>
                </div>
                <dl class="space-y-2 text-sm">
                    <div>
                        <dt class="text-zinc-400">Nama</dt>
                        <dd class="font-semibold">{{ $rujukan->pasien->nama }}</dd>
                    </div>
                    <div>
                        <dt class="text-zinc-400">NIK</dt>
                        <dd>{{ $rujukan->pasien->nik }}</dd>
                    </div>
                    <div>
                        <dt class="text-zinc-400">Jenis Kelamin</dt>
                        <dd>{{ $rujukan->pasien->jenis_kelamin->label() }}</dd>
                    </div>
                    @if ($rujukan->pasien->no_telepon)
                        <div>
                            <dt class="text-zinc-400">Telepon</dt>
                            <dd>{{ $rujukan->pasien->no_telepon }}</dd>
                        </div>
                    @endif
                    @if ($rujukan->pasien->hasCoordinates())
                        <div>
                            <dt class="text-zinc-400">Koordinat</dt>
                            <dd class="font-mono text-xs text-emerald-600">{{ $rujukan->pasien->latitude }},
                                {{ $rujukan->pasien->longitude }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- RS Tujuan --}}
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-5 flex items-center justify-between border-b border-zinc-100 pb-4 dark:border-zinc-800">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-400">
                            <x-icons.office-building class="h-4.5 w-4.5" />
                        </div>
                        <h3 class="font-bold text-zinc-900 dark:text-white">RS Tujuan</h3>
                    </div>
                </div>

                <div class="space-y-4">
                    {{-- Detail RS --}}
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-xs text-zinc-400 block mb-0.5">Nama Rumah Sakit</span>
                            <p class="font-bold text-zinc-900 dark:text-white text-base leading-tight">
                                {{ $rujukan->rumahSakit->nama_rumah_sakit }}
                            </p>
                        </div>

                        <div class="flex items-start gap-2.5">
                            <x-icons.map-pin class="h-4 w-4 text-zinc-400 mt-0.5 shrink-0" />
                            <div>
                                <span class="text-xs text-zinc-400 block mb-0.5">Alamat</span>
                                <p class="text-zinc-600 dark:text-zinc-300 text-xs leading-normal">
                                    {{ $rujukan->rumahSakit->alamat }}
                                </p>
                            </div>
                        </div>

                        @if ($rujukan->rumahSakit->no_telepon)
                            <div class="flex items-center gap-2.5">
                                <x-icons.phone class="h-4 w-4 text-zinc-400 shrink-0" />
                                <div>
                                    <span class="text-xs text-zinc-400 block">Telepon</span>
                                    <p class="text-zinc-700 dark:text-zinc-300 text-xs font-semibold">
                                        {{ $rujukan->rumahSakit->no_telepon }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Layanan List --}}
                    <div class="border-t border-zinc-100 pt-4 dark:border-zinc-800">
                        <span class="text-xs font-semibold text-zinc-400 block mb-2">Layanan Spesialis</span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($rujukan->rumahSakit->layanan_list as $l)
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-[10px] font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-900/20 dark:text-blue-300 dark:ring-blue-800/30">
                                    {{ $l }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail A* --}}
            @if ($rujukan->detailRujukan)
                <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                    <div class="mb-5 flex items-center justify-between border-b border-zinc-100 pb-4 dark:border-zinc-800">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-950/30 dark:text-purple-400">
                                <x-icons.cpu class="h-4.5 w-4.5" />
                            </div>
                            <h3 class="font-bold text-zinc-900 dark:text-white">Hasil Analisis A*</h3>
                        </div>
                        @if ($rujukan->detailRujukan->rute)
                            <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-0.5 text-[10px] font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10 dark:bg-purple-900/30 dark:text-purple-300">
                                {{ strtoupper($rujukan->detailRujukan->rute->algoritma) }}
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        {{-- Jarak --}}
                        <div class="rounded-xl border border-zinc-100 bg-zinc-50/30 p-3 text-center dark:border-zinc-800/50 dark:bg-zinc-900/20">
                            <p class="text-sm font-bold text-purple-600 dark:text-purple-400">
                                {{ $rujukan->detailRujukan->jarak }}
                            </p>
                            <p class="text-[10px] text-zinc-400 uppercase tracking-wider font-semibold mt-0.5">Jarak (Km)</p>
                        </div>
                        
                        {{-- Waktu --}}
                        <div class="rounded-xl border border-zinc-100 bg-zinc-50/30 p-3 text-center dark:border-zinc-800/50 dark:bg-zinc-900/20">
                            <p class="text-sm font-bold text-blue-600 dark:text-blue-400">
                                {{ $rujukan->detailRujukan->waktu_tempuh }}
                            </p>
                            <p class="text-[10px] text-zinc-400 uppercase tracking-wider font-semibold mt-0.5">Waktu (Mnt)</p>
                        </div>

                        {{-- Biaya --}}
                        <div class="rounded-xl border border-zinc-100 bg-zinc-50/30 p-3 text-center dark:border-zinc-800/50 dark:bg-zinc-900/20">
                            <p class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 leading-tight">
                                Rp {{ number_format($rujukan->detailRujukan->estimasi_biaya, 0, ',', '.') }}
                            </p>
                            <p class="text-[10px] text-zinc-400 uppercase tracking-wider font-semibold mt-0.5">Est. Biaya</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Kanan: Peta + Riwayat --}}
        <div class="space-y-4 lg:col-span-2">
            {{-- Peta Leaflet --}}
            <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-3 flex items-center gap-3">
                    <div class="h-8 w-1 rounded-full bg-blue-600"></div>
                    <h3 class="font-bold">Peta Rute Rujukan</h3>
                </div>
                <div id="map-show-rujukan" class="h-80 w-full rounded-lg border border-zinc-200 dark:border-zinc-700">
                </div>
            </div>

            {{-- Riwayat Status --}}
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-5 flex items-center justify-between border-b border-zinc-100 pb-4 dark:border-zinc-800">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-950/30 dark:text-amber-400">
                            <x-icons.clock class="h-4.5 w-4.5" />
                        </div>
                        <h3 class="font-bold text-zinc-900 dark:text-white">Riwayat Perubahan Status</h3>
                    </div>
                </div>

                @if ($rujukan->riwayat->isEmpty())
                    <div class="flex flex-col items-center justify-center py-6 text-center">
                        <span class="text-3xl">⏳</span>
                        <p class="mt-2 text-sm text-zinc-400 dark:text-zinc-500">Belum ada perubahan status untuk rujukan ini.</p>
                    </div>
                @else
                    <div class="relative pl-6 before:absolute before:bottom-2 before:left-[11px] before:top-2 before:w-0.5 before:bg-zinc-100 dark:before:bg-zinc-800">
                        @foreach ($rujukan->riwayat as $log)
                            @php
                                $getBadgeStyles = function($status) {
                                    return match(strtolower($status)) {
                                        'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/10 dark:bg-amber-500/10 dark:text-amber-400 dark:ring-amber-400/20',
                                        'disetujui' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/10 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-400/20',
                                        'ditolak' => 'bg-red-50 text-red-700 ring-red-600/10 dark:bg-red-500/10 dark:text-red-400 dark:ring-red-400/20',
                                        'selesai' => 'bg-blue-50 text-blue-700 ring-blue-600/10 dark:bg-blue-500/10 dark:text-blue-400 dark:ring-blue-400/20',
                                        default => 'bg-zinc-50 text-zinc-600 ring-zinc-500/10 dark:bg-zinc-500/10 dark:text-zinc-400 dark:ring-zinc-400/20'
                                    };
                                };
                            @endphp
                            <div class="relative mb-6 last:mb-0">
                                {{-- Timeline Indicator --}}
                                <div class="absolute -left-[21px] top-1 flex h-4 w-4 items-center justify-center rounded-full bg-white ring-4 ring-white dark:bg-dark-primary dark:ring-dark-primary">
                                    <div class="h-2.5 w-2.5 rounded-full border-2 border-zinc-300 bg-white dark:border-zinc-600 dark:bg-dark-primary"></div>
                                </div>

                                {{-- Log Content --}}
                                <div class="flex flex-col gap-1.5 pl-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        @if ($log->status_lama)
                                            <span class="{{ $getBadgeStyles($log->status_lama) }} inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-medium ring-1 ring-inset capitalize">
                                                {{ $log->status_lama }}
                                            </span>
                                            <span class="text-zinc-300 dark:text-zinc-600 text-xs">
                                                <x-icons.arrow-right class="h-3 w-3" />
                                            </span>
                                        @endif
                                        <span class="{{ $getBadgeStyles($log->status_baru) }} inline-flex items-center rounded-md px-2.5 py-0.5 text-[11px] font-semibold ring-1 ring-inset capitalize">
                                            {{ $log->status_baru }}
                                        </span>
                                    </div>
                                    
                                    @if ($log->keterangan)
                                        <p class="text-xs text-zinc-600 dark:text-zinc-300 italic mt-0.5 bg-zinc-50/50 dark:bg-zinc-800/20 p-2 rounded-lg border border-zinc-100/50 dark:border-zinc-800/50">
                                            "{{ $log->keterangan }}"
                                        </p>
                                    @endif

                                    <div class="flex items-center gap-1.5 text-[11px] text-zinc-400 dark:text-zinc-500">
                                        <span class="font-medium text-zinc-600 dark:text-zinc-400">
                                            {{ $log->diubahOleh?->name ?? 'Sistem' }}
                                        </span>
                                        <span>•</span>
                                        <span>
                                            {{ $log->waktu_perubahan->locale('id')->isoFormat('DD MMM YYYY, HH:mm') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Keterangan --}}
            @if ($rujukan->keterangan)
                <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-800"
                    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                    <p class="text-sm font-medium text-zinc-500">Keterangan</p>
                    <p class="mt-1 text-sm text-zinc-800 dark:text-zinc-200">{{ $rujukan->keterangan }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@script
    <script>
        (async function () {
            const mapEl = document.getElementById('map-show-rujukan');
            if (!mapEl || mapEl._leaflet_id) return;

            const pasienLat = {{ $rujukan->pasien->latitude ?? -6.2 }};
            const pasienLng = {{ $rujukan->pasien->longitude ?? 106.8 }};
            const rsLat     = {{ $rujukan->rumahSakit->latitude }};
            const rsLng     = {{ $rujukan->rumahSakit->longitude }};

            const map = L.map('map-show-rujukan');
            L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '&copy; Google Maps'
            }).addTo(map);

            // Marker pasien
            const pasienIcon = L.divIcon({ html: '📍', className: '', iconSize: [24, 24] });
            L.marker([pasienLat, pasienLng], { icon: pasienIcon }).addTo(map)
                .bindPopup('<strong>{{ addslashes($rujukan->pasien->nama) }}</strong><br>Lokasi Pasien');

            // Marker RS
            const rsIcon = L.divIcon({ html: '🏥', className: '', iconSize: [24, 24] });
            L.marker([rsLat, rsLng], { icon: rsIcon }).addTo(map)
                .bindPopup('<strong>{{ addslashes($rujukan->rumahSakit->nama_rumah_sakit) }}</strong>');

            // Fallback straight line — akan digantikan oleh rute OSRM jika berhasil
            let routeLayer = L.polyline([[pasienLat, pasienLng], [rsLat, rsLng]], {
                color: '#94a3b8', weight: 3, dashArray: '6,5', opacity: 0.5
            }).addTo(map);
            map.fitBounds(routeLayer.getBounds(), { padding: [40, 40] });

            // Fetch rute jalan aktual dari OSRM (sama dengan halaman analisis)
            try {
                const osrmUrl = `https://router.project-osrm.org/route/v1/driving/${pasienLng},${pasienLat};${rsLng},${rsLat}?overview=full&geometries=geojson`;
                const res  = await fetch(osrmUrl);
                const data = await res.json();

                if (data.routes && data.routes.length > 0) {
                    map.removeLayer(routeLayer);
                    routeLayer = L.geoJSON(data.routes[0].geometry, {
                        style: { color: '#10b981', weight: 5, opacity: 0.85 }
                    }).addTo(map);
                    map.fitBounds(routeLayer.getBounds(), { padding: [40, 40] });
                }
            } catch (e) {
                // Biarkan fallback straight line tetap tampil
            }
        })();
    </script>
@endscript
