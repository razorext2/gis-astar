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
                        <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $sc }}">
                            {{ $rujukan->status->label() }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">{{ $rujukan->tanggal_rujukan->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }}</p>
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
                    <div><dt class="text-zinc-400">Nama</dt><dd class="font-semibold">{{ $rujukan->pasien->nama }}</dd></div>
                    <div><dt class="text-zinc-400">NIK</dt><dd>{{ $rujukan->pasien->nik }}</dd></div>
                    <div><dt class="text-zinc-400">Jenis Kelamin</dt><dd>{{ $rujukan->pasien->jenis_kelamin->label() }}</dd></div>
                    @if($rujukan->pasien->no_telepon)
                        <div><dt class="text-zinc-400">Telepon</dt><dd>{{ $rujukan->pasien->no_telepon }}</dd></div>
                    @endif
                    @if($rujukan->pasien->hasCoordinates())
                        <div>
                            <dt class="text-zinc-400">Koordinat</dt>
                            <dd class="font-mono text-xs text-emerald-600">{{ $rujukan->pasien->latitude }}, {{ $rujukan->pasien->longitude }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- RS Tujuan --}}
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-4 flex items-center gap-3">
                    <div class="h-8 w-1 rounded-full bg-emerald-600"></div>
                    <h3 class="font-bold">RS Tujuan</h3>
                </div>
                <dl class="space-y-2 text-sm">
                    <div><dt class="text-zinc-400">Nama RS</dt><dd class="font-semibold">{{ $rujukan->rumahSakit->nama_rumah_sakit }}</dd></div>
                    <div><dt class="text-zinc-400">Alamat</dt><dd>{{ $rujukan->rumahSakit->alamat }}</dd></div>
                    @if($rujukan->rumahSakit->no_telepon)
                        <div><dt class="text-zinc-400">Telepon</dt><dd>{{ $rujukan->rumahSakit->no_telepon }}</dd></div>
                    @endif
                    <div>
                        <dt class="text-zinc-400 mb-1">Layanan</dt>
                        <dd class="flex flex-wrap gap-1">
                            @foreach($rujukan->rumahSakit->layanan_list as $l)
                                <span class="inline-block rounded bg-blue-100 px-1.5 py-0.5 text-xs text-blue-700 dark:bg-blue-900 dark:text-blue-300">{{ $l }}</span>
                            @endforeach
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Detail A* --}}
            @if($rujukan->detailRujukan)
                <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="h-8 w-1 rounded-full bg-purple-600"></div>
                        <h3 class="font-bold">Hasil Algoritma A*</h3>
                    </div>
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-lg font-bold text-purple-600">{{ $rujukan->detailRujukan->jarak }} km</p>
                            <p class="text-xs text-zinc-400">Jarak</p>
                        </div>
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-lg font-bold text-blue-600">{{ $rujukan->detailRujukan->waktu_tempuh }} mnt</p>
                            <p class="text-xs text-zinc-400">Est. Waktu</p>
                        </div>
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-sm font-bold text-emerald-600">Rp {{ number_format($rujukan->detailRujukan->estimasi_biaya, 0, ',', '.') }}</p>
                            <p class="text-xs text-zinc-400">Est. Biaya</p>
                        </div>
                    </div>
                    @if($rujukan->detailRujukan->rute)
                        <div class="mt-3 text-xs text-zinc-400">
                            Algoritma: <span class="font-mono">{{ $rujukan->detailRujukan->rute->algoritma }}</span>
                        </div>
                    @endif
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
                <div id="map-show-rujukan" class="h-80 w-full rounded-lg border border-zinc-200 dark:border-zinc-700"></div>
            </div>

            {{-- Riwayat Status --}}
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-4 flex items-center gap-3">
                    <div class="h-8 w-1 rounded-full bg-amber-600"></div>
                    <h3 class="font-bold">Riwayat Perubahan Status</h3>
                </div>
                @if($rujukan->riwayat->isEmpty())
                    <p class="text-sm text-zinc-400">Belum ada perubahan status.</p>
                @else
                    <div class="space-y-3">
                        @foreach($rujukan->riwayat as $log)
                            <div class="flex gap-3 text-sm">
                                <div class="flex flex-col items-center">
                                    <div class="h-2 w-2 mt-1.5 rounded-full bg-zinc-400"></div>
                                    @if(!$loop->last) <div class="w-px flex-1 bg-zinc-200 dark:bg-zinc-700"></div> @endif
                                </div>
                                <div class="pb-3">
                                    <div class="flex items-center gap-2">
                                        @if($log->status_lama)
                                            <span class="text-xs text-zinc-400">{{ $log->status_lama }}</span>
                                            <span class="text-zinc-300">→</span>
                                        @endif
                                        <span class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $log->status_baru }}</span>
                                    </div>
                                    <p class="text-xs text-zinc-400">
                                        {{ $log->diubahOleh?->name ?? 'Sistem' }} · {{ $log->waktu_perubahan->locale('id')->isoFormat('DD MMM HH:mm') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Keterangan --}}
            @if($rujukan->keterangan)
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
    (function() {
        const mapEl = document.getElementById('map-show-rujukan');
        if (!mapEl || mapEl._leaflet_id) return;

        const pasienLat = {{ $rujukan->pasien->latitude ?? -6.2 }};
        const pasienLng = {{ $rujukan->pasien->longitude ?? 106.8 }};
        const rsLat = {{ $rujukan->rumahSakit->latitude }};
        const rsLng = {{ $rujukan->rumahSakit->longitude }};

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

        // Garis rute
        const line = L.polyline([[pasienLat, pasienLng], [rsLat, rsLng]], {
            color: '#10b981', weight: 4, dashArray: '8,6'
        }).addTo(map);

        map.fitBounds(line.getBounds(), { padding: [40, 40] });
    })();
</script>
@endscript
