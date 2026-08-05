{{-- Goal: Form perujukan otomatis A* — inti sistem --}}
<div class="w-full space-y-4" x-data="{ showResult: @entangle('showResult') }">

    {{-- Header --}}
    <div class="rounded-xl border border-zinc-200 p-6 shadow-sm dark:border-zinc-800"
        x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div class="flex items-center gap-4">
                <x-button.danger wire:navigate href="{{ route('rujukan.index') }}">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Cari Rujukan Otomatis A*</h2>
                    <p class="text-sm text-gray-500">Algoritma A* mencari RS terdekat berdasarkan koordinat pasien</p>
                </div>
            </div>
            <div class="flex gap-3">
                <x-button.primary wire:click="searchReferral" wire:loading.attr="disabled" wire:target="searchReferral">
                    <x-slot name="icon">
                        <x-icons.loading wire:loading wire:target="searchReferral" class="h-4 w-4 animate-spin" />
                    </x-slot>
                    <span wire:loading.remove wire:target="searchReferral">🔍 Cari RS Terbaik</span>
                    <span wire:loading wire:target="searchReferral">Menjalankan A*...</span>
                </x-button.primary>
                @if($showResult)
                    <x-button.primary wire:click="confirmReferral" wire:loading.attr="disabled" wire:target="confirmReferral"
                        class="!bg-emerald-600 hover:!bg-emerald-700">
                        <span wire:loading.remove wire:target="confirmReferral">✓ Konfirmasi Rujukan</span>
                        <span wire:loading wire:target="confirmReferral">Menyimpan...</span>
                    </x-button.primary>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        {{-- Kiri: Form Input --}}
        <div class="space-y-4">
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-6 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-blue-600"></div>
                    <h3 class="text-lg font-bold">Parameter Rujukan</h3>
                </div>

                {{-- Pilih Pasien --}}
                <div class="space-y-1 mb-4">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Pilih Pasien</label>
                    <select wire:model.live="pasienId" id="pasien-select"
                        class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach($pasienList as $p)
                            <option value="{{ $p->id_pasien }}" {{ $pasienId == $p->id_pasien ? 'selected' : '' }}>
                                {{ $p->nama }} ({{ $p->nik }})
                                {{ $p->latitude ? '📍' : '⚠️' }}
                            </option>
                        @endforeach
                    </select>
                    @error('pasienId') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                {{-- Layanan dibutuhkan --}}
                <div class="space-y-1 mb-4">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Layanan yang Dibutuhkan</label>
                    <select wire:model.live="layanan" id="layanan-select"
                        class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($layananList as $l)
                            <option value="{{ $l }}">{{ $l }}</option>
                        @endforeach
                    </select>
                    @error('layanan') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                {{-- Radius --}}
                <div class="space-y-2 mb-4">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Radius Pencarian: <span class="font-bold text-blue-600">{{ $radiusKm }} km</span>
                    </label>
                    <input type="range" wire:model.live="radiusKm" min="5" max="200" step="5"
                        class="w-full h-2 bg-zinc-200 rounded-lg appearance-none cursor-pointer dark:bg-zinc-700">
                    <div class="flex justify-between text-xs text-zinc-400">
                        <span>5 km</span><span>200 km</span>
                    </div>
                </div>

                {{-- Info koordinat pasien --}}
                @if($pasienId)
                    <div class="rounded-lg border p-3 text-sm
                        {{ $pasienLat ? 'border-emerald-200 bg-emerald-50 dark:border-emerald-800 dark:bg-emerald-900/20' : 'border-amber-200 bg-amber-50 dark:border-amber-800 dark:bg-amber-900/20' }}">
                        @if($pasienLat)
                            <p class="text-emerald-700 dark:text-emerald-300">
                                📍 Koordinat: {{ $pasienLat }}, {{ $pasienLng }}
                            </p>
                        @else
                            <p class="text-amber-600 dark:text-amber-400">
                                ⚠️ Pasien belum punya koordinat. Gunakan peta di bawah untuk atur lokasi.
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Map Picker Koordinat Pasien --}}
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-1 rounded-full bg-emerald-600"></div>
                        <h3 class="text-lg font-bold">Lokasi Pasien</h3>
                    </div>
                    <button type="button" onclick="detectGPSRujukan()"
                        class="flex items-center gap-1.5 rounded-lg border border-emerald-300 bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-100 dark:border-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300">
                        📡 GPS
                    </button>
                </div>
                <div id="map-rujukan-picker" class="h-56 w-full rounded-lg border border-zinc-200 dark:border-zinc-700"></div>
                <p class="mt-2 text-xs text-zinc-400">Klik peta untuk atur/koreksi lokasi pasien</p>
            </div>
        </div>

        {{-- Kanan: Hasil A* --}}
        <div class="lg:col-span-2">
            {{-- Status loading --}}
            <div wire:loading wire:target="searchReferral" class="flex items-center justify-center rounded-xl border border-blue-200 bg-blue-50 p-12 dark:border-blue-900 dark:bg-blue-900/20">
                <div class="text-center">
                    <div class="mx-auto mb-4 h-12 w-12 animate-spin rounded-full border-4 border-blue-200 border-t-blue-600"></div>
                    <p class="font-semibold text-blue-700 dark:text-blue-300">Menjalankan Algoritma A*...</p>
                    <p class="text-sm text-blue-500">Mencari rumah sakit terbaik</p>
                </div>
            </div>

            {{-- Empty state --}}
            <div x-show="!showResult" wire:loading.remove wire:target="searchReferral"
                class="flex items-center justify-center rounded-xl border border-dashed border-zinc-300 bg-zinc-50/50 p-16 dark:border-zinc-700 dark:bg-zinc-900/20">
                <div class="text-center">
                    <div class="mb-4 text-6xl">🏥</div>
                    <h3 class="mb-2 text-lg font-semibold text-zinc-600 dark:text-zinc-400">Siap Mencari Rujukan</h3>
                    <p class="text-sm text-zinc-400">Pilih pasien dan layanan, lalu klik "Cari RS Terbaik"</p>
                </div>
            </div>

            {{-- Hasil A* --}}
            @if($showResult && $astarResult)
                <div class="space-y-4" wire:loading.remove wire:target="searchReferral">
                    {{-- Peta hasil rute --}}
                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-800"
                        x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                        <div class="mb-3 flex items-center gap-3">
                            <div class="h-8 w-1 rounded-full bg-emerald-600"></div>
                            <h3 class="text-lg font-bold">Peta Rute Terbaik</h3>
                        </div>
                        <div id="map-astar-result" class="h-72 w-full rounded-lg border border-zinc-200 dark:border-zinc-700"></div>
                    </div>

                    {{-- Info RS Terpilih --}}
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-6 dark:border-emerald-800 dark:bg-emerald-900/10">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-xs font-medium uppercase tracking-wide text-emerald-600">🏆 RS Terpilih (A*)</span>
                                <h3 class="mt-1 text-xl font-bold text-emerald-800 dark:text-emerald-200">
                                    {{ $astarResult['astar']['best_hospital']['nama'] }}
                                </h3>
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-3 gap-4">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-emerald-700">{{ $astarResult['astar']['total_distance'] }} km</p>
                                <p class="text-xs text-emerald-600">Jarak</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-emerald-700">{{ $astarResult['astar']['estimated_time'] }} mnt</p>
                                <p class="text-xs text-emerald-600">Est. Waktu</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-emerald-700">Rp {{ number_format($astarResult['astar']['estimated_cost'], 0, ',', '.') }}</p>
                                <p class="text-xs text-emerald-600">Est. Biaya</p>
                            </div>
                        </div>
                    </div>

                    {{-- Ranking semua kandidat --}}
                    <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-800"
                        x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                        <div class="mb-3 flex items-center gap-3">
                            <div class="h-8 w-1 rounded-full bg-blue-600"></div>
                            <h3 class="text-lg font-bold">Ranking Semua Kandidat RS</h3>
                        </div>
                        <div class="space-y-2">
                            @foreach($astarResult['astar']['all_ranked'] as $idx => $candidate)
                                <div class="flex items-center gap-3 rounded-lg border p-3 text-sm
                                    {{ $idx === 0 ? 'border-emerald-300 bg-emerald-50 dark:border-emerald-700 dark:bg-emerald-900/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-xs font-bold
                                        {{ $idx === 0 ? 'bg-emerald-600 text-white' : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800' }}">
                                        {{ $idx + 1 }}
                                    </span>
                                    <div class="flex-1">
                                        <p class="font-semibold {{ $idx === 0 ? 'text-emerald-800 dark:text-emerald-200' : 'text-zinc-800 dark:text-zinc-200' }}">
                                            {{ $candidate['hospital']['nama'] }}
                                        </p>
                                        <p class="text-xs text-zinc-400">
                                            {{ $candidate['distance'] }} km · {{ $candidate['estimated_time'] }} mnt · Rp {{ number_format($candidate['estimated_cost'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <span class="text-xs font-mono text-zinc-400">f={{ number_format($candidate['f_score'], 3) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@script
<script>
    // Map picker pasien
    (function() {
        const mapEl = document.getElementById('map-rujukan-picker');
        if (!mapEl || mapEl._leaflet_id) return;
        const initLat = {{ $pasienLat ?? -6.2 }};
        const initLng = {{ $pasienLng ?? 106.8 }};
        const map = L.map('map-rujukan-picker').setView([initLat, initLng], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);
        const marker = L.marker([initLat, initLng], { draggable: true }).addTo(map);
        function setCoords(lat, lng) {
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], 14);
            @this.updateCoordinates(lat, lng);
        }
        marker.on('dragend', e => { const p = e.target.getLatLng(); setCoords(p.lat, p.lng); });
        map.on('click', e => setCoords(e.latlng.lat, e.latlng.lng));
        window._mapRujukanPicker = { map, marker, setCoords };
    })();

    window.detectGPSRujukan = function() {
        navigator.geolocation?.getCurrentPosition(
            pos => window._mapRujukanPicker?.setCoords(pos.coords.latitude, pos.coords.longitude),
            () => Swal.fire('Gagal', 'GPS tidak tersedia', 'warning'),
            { enableHighAccuracy: true }
        );
    };

    // Render peta hasil A* setelah hasil tersedia
    $wire.on('astar-result-ready', (payload) => {
        const result = payload.result;
        setTimeout(() => {
            const mapEl = document.getElementById('map-astar-result');
            if (!mapEl || mapEl._leaflet_id) return;

            const waypoints = result.waypoints;
            const center = [waypoints[0].lat, waypoints[0].lng];
            const map = L.map('map-astar-result').setView(center, 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);

            // Marker pasien (biru)
            const pasienIcon = L.divIcon({ html: '📍', className: '', iconSize: [24,24] });
            L.marker([waypoints[0].lat, waypoints[0].lng], { icon: pasienIcon })
                .addTo(map).bindPopup('Lokasi Pasien').openPopup();

            // Marker RS terpilih (merah)
            const rsIcon = L.divIcon({ html: '🏥', className: '', iconSize: [24,24] });
            L.marker([waypoints[waypoints.length-1].lat, waypoints[waypoints.length-1].lng], { icon: rsIcon })
                .addTo(map).bindPopup(result.best_hospital.nama);

            // Line rute
            const latlngs = waypoints.map(w => [w.lat, w.lng]);
            L.polyline(latlngs, { color: '#10b981', weight: 4, dashArray: '8,6' }).addTo(map);

            // Semua kandidat lain (abu-abu)
            result.all_ranked.slice(1).forEach(c => {
                L.circleMarker([c.hospital.lat, c.hospital.lng], { radius: 6, color: '#94a3b8', fillOpacity: 0.6 })
                    .addTo(map).bindPopup(c.hospital.nama + ' (' + c.distance + ' km)');
            });

            map.fitBounds(L.polyline(latlngs).getBounds(), { padding: [30,30] });
        }, 100);
    });
</script>
@endscript
