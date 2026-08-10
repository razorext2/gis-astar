{{-- Goal: Menampilkan visualisasi peta & rute interaktif berdasarkan data rujukan yang tersimpan, Caller: web routes --}}
<div class="w-full space-y-4" x-data="{
    pasienId: @entangle('pasienId'),
    rsId: @entangle('rsId'),
    metode: @entangle('metode'),
    steps: [],
    currentDistance: '-',
    currentDuration: '-',
    estimasiTiba: '-',
    kondisi: 'Lancar',
    ruteMelalui: [],
    map: null,
    markerPasien: null,
    markerRs: null,
    routeLayer: null,
    baseOSM: null,
    baseSatelit: null,
    currentLayerType: 'peta', // 'peta' atau 'satelit'

    initMap() {
        // Default koordinat Medan
        this.map = L.map('peta-rute-canvas', {
            center: [3.595196, 98.672223],
            zoom: 12,
            zoomControl: false
        });

        L.control.zoom({ position: 'bottomright' }).addTo(this.map);

        // Tile layers
        this.baseOSM = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        });

        this.baseSatelit = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Satellite'
        });

        // Set default ke OSM
        this.baseOSM.addTo(this.map);
    },

    toggleLayer(type) {
        if (this.currentLayerType === type) return;
        this.currentLayerType = type;

        if (type === 'satelit') {
            this.map.removeLayer(this.baseOSM);
            this.baseSatelit.addTo(this.map);
        } else {
            this.map.removeLayer(this.baseSatelit);
            this.baseOSM.addTo(this.map);
        }
    },

    loadRoute(data) {
        // Hapus layer lama jika ada
        if (this.markerPasien) this.map.removeLayer(this.markerPasien);
        if (this.markerRs) this.map.removeLayer(this.markerRs);
        if (this.routeLayer) this.map.removeLayer(this.routeLayer);

        const latPasien = data.pasien.lat;
        const lngPasien = data.pasien.lng;
        const latRs = data.rs.lat;
        const lngRs = data.rs.lng;

        // Custom marker icons
        const redIcon = L.divIcon({
            html: `<div class='flex items-center justify-center w-8 h-8 rounded-full bg-red-500 text-white shadow-lg border border-white font-bold text-xs'>P</div>`,
            className: '',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        const blueIcon = L.divIcon({
            html: `<div class='flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white shadow-lg border border-white font-bold text-xs'>RS</div>`,
            className: '',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        // Tambah marker baru
        this.markerPasien = L.marker([latPasien, lngPasien], { icon: redIcon })
            .addTo(this.map)
            .bindPopup(`<b>${data.pasien.nama}</b><br>${data.pasien.alamat}`);

        this.markerRs = L.marker([latRs, lngRs], { icon: blueIcon })
            .addTo(this.map)
            .bindPopup(`<b>${data.rs.nama}</b><br>${data.rs.alamat}`);

        // Fetch rute dari OSRM
        const url = `https://router.project-osrm.org/route/v1/driving/${lngPasien},${latPasien};${lngRs},${latRs}?overview=full&geometries=geojson&steps=true`;

        fetch(url)
            .then(res => res.json())
            .then(osrmData => {
                if (osrmData.routes && osrmData.routes.length > 0) {
                    const route = osrmData.routes[0];
                    
                    // Draw polyline
                    this.routeLayer = L.geoJSON(route.geometry, {
                        style: {
                            color: '#e11d48',
                            weight: 5,
                            opacity: 0.85
                        }
                    }).addTo(this.map);

                    // Fit bounds
                    this.map.fitBounds(this.routeLayer.getBounds(), { padding: [50, 50] });

                    // Set summary statistics
                    this.currentDistance = data.jarak.toFixed(1).replace('.', ',') + ' km';
                    this.currentDuration = Math.ceil(data.waktu / 60) + ' menit';
                    this.estimasiTiba = data.estimasi_tiba;
                    this.kondisi = data.kondisi;

                    // Parse turn-by-turn steps
                    const parsedSteps = [];
                    const uniqueStreets = new Set();

                    parsedSteps.push({
                        icon: '📍',
                        title: `Lokasi Pasien (${data.pasien.nama})`,
                        address: data.pasien.alamat,
                        distance: '0 km'
                    });

                    route.legs[0].steps.forEach(step => {
                        if (step.name && step.name.trim() !== '') {
                            const street = step.name.trim();
                            uniqueStreets.add(street);

                            const modifier = step.maneuver.modifier;
                            const type = step.maneuver.type;

                            let icon = '⬆';
                            let action = 'Lurus terus';

                            if (modifier === 'left') {
                                icon = '↰';
                                action = 'Belok kiri';
                            } else if (modifier === 'right') {
                                icon = '↱';
                                action = 'Belok kanan';
                            } else if (modifier === 'sharp left') {
                                icon = '↶';
                                action = 'Belok tajam kiri';
                            } else if (modifier === 'sharp right') {
                                icon = '↷';
                                action = 'Belok tajam kanan';
                            } else if (modifier === 'slight left') {
                                icon = '↖';
                                action = 'Serong kiri';
                            } else if (modifier === 'slight right') {
                                icon = '↗';
                                action = 'Serong kanan';
                            } else if (modifier === 'uturn') {
                                icon = '↲';
                                action = 'Putar balik';
                            } else if (type === 'merge') {
                                icon = '⤳';
                                action = 'Bergabung';
                            } else if (type === 'roundabout' || type === 'rotary') {
                                icon = '↻';
                                action = 'Masuk bundaran';
                            }

                            parsedSteps.push({
                                icon: icon,
                                title: `${action} ke ${street}`,
                                address: '',
                                distance: (step.distance / 1000).toFixed(1).replace('.', ',') + ' km'
                            });
                        }
                    });

                    parsedSteps.push({
                        icon: '📍',
                        title: `Tujuan: ${data.rs.nama}`,
                        address: data.rs.alamat,
                        distance: `Total ${this.currentDistance} (${this.currentDuration})`
                    });

                    this.steps = parsedSteps;
                    this.ruteMelalui = Array.from(uniqueStreets).slice(0, 5);
                }
            })
            .catch(err => {
                console.error('OSRM Fetch Error:', err);
            });
    }
}" x-init="initMap()" x-on:rute-loaded.window="loadRoute($event.detail)" class="print:space-y-0 print:bg-white print:p-0">

    {{-- Header --}}
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between print:hidden">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Peta & Rute</h2>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Dashboard / Peta & Rute</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 print:grid-cols-1 print:gap-0">
        
        {{-- Sidebar Kiri Form / Detail --}}
        <div class="space-y-6 lg:col-span-1 print:hidden">
            
            {{-- Form Pemilihan --}}
            <div class="rounded-2xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                
                <form wire:submit.prevent="search" class="space-y-4">
                    {{-- Pasien --}}
                    <div class="space-y-1.5">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Lokasi Pasien</label>
                        <select wire:model.live="pasienId" 
                            class="w-full rounded-xl border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 focus:border-red-500 focus:ring-1 focus:ring-red-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white [&>option]:dark:bg-zinc-800 [&>option]:dark:text-white">
                            <option value="">-- Pilih Pasien --</option>
                            @foreach($pasienList as $pasien)
                                <option value="{{ $pasien->id_pasien }}">{{ $pasien->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Detail Pasien Terpilih --}}
                    @if($selectedPasien)
                        <div class="rounded-xl bg-zinc-50 p-4 text-xs text-zinc-600 dark:bg-zinc-900/60 dark:text-zinc-400 border border-zinc-100 dark:border-zinc-800/80 space-y-1">
                            <p class="font-medium text-zinc-800 dark:text-zinc-200">{{ $selectedPasien->alamat ?? '-' }}</p>
                            <p>Lat: {{ $selectedPasien->latitude }}, Long: {{ $selectedPasien->longitude }}</p>
                        </div>
                    @endif

                    {{-- Rumah Sakit Tujuan --}}
                    <div class="space-y-1.5">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Tujuan Rujukan</label>
                        <select wire:model.live="rsId" :disabled="!$wire.pasienId"
                            class="w-full rounded-xl border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 focus:border-red-500 focus:ring-1 focus:ring-red-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white [&>option]:dark:bg-zinc-800 [&>option]:dark:text-white disabled:opacity-50">
                            <option value="">-- Pilih Rumah Sakit --</option>
                            @foreach($rsList as $rs)
                                <option value="{{ $rs->id_rumah_sakit }}">{{ $rs->nama_rumah_sakit }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Metode Pencarian --}}
                    <div class="space-y-1.5">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Metode Pencarian Rute</label>
                        <select wire:model="metode"
                            class="w-full rounded-xl border border-zinc-300 bg-white px-3.5 py-2.5 text-sm text-zinc-900 focus:border-red-500 focus:ring-1 focus:ring-red-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white [&>option]:dark:bg-zinc-800 [&>option]:dark:text-white">
                            <option value="Rute Terpendek">Rute Terpendek</option>
                            <option value="Rute Alternatif">Rute Alternatif</option>
                        </select>
                    </div>

                    {{-- Submit Button --}}
                    <x-button.primary type="submit" class="w-full py-3 mt-2 text-sm justify-center" wire:loading.attr="disabled" wire:target="search">
                        <x-slot name="icon">
                            <x-icons.search wire:loading.remove wire:target="search" class="h-4 w-4" />
                            <x-icons.loading wire:loading wire:target="search" class="h-4 w-4 animate-spin" />
                        </x-slot>
                        <span>Cari Rute Terbaik</span>
                    </x-button.primary>
                </form>

            </div>

            {{-- Hasil Rute Ringkasan --}}
            <div x-show="steps.length > 0" x-cloak
                class="rounded-2xl border border-zinc-200 p-6 dark:border-zinc-800 space-y-5"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                
                <div>
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-white border-b border-zinc-100 pb-3 dark:border-zinc-800/80">Hasil Rute Terpendek</h3>
                </div>

                <div class="space-y-3.5">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5"><x-icons.globe class="h-4 w-4" /> Jarak</span>
                        <span class="font-bold text-zinc-900 dark:text-white" x-text="currentDistance"></span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5"><x-icons.clock class="h-4 w-4" /> Waktu Tempuh</span>
                        <span class="font-bold text-zinc-900 dark:text-white" x-text="currentDuration"></span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5"><x-icons.clock class="h-4 w-4" /> Estimasi Tiba</span>
                        <span class="font-bold text-zinc-900 dark:text-white" x-text="estimasiTiba"></span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5"><x-icons.truck class="h-4 w-4" /> Kondisi</span>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold dark:bg-emerald-950/40 dark:text-emerald-400" x-text="kondisi"></span>
                    </div>
                </div>

                {{-- Rute Melalui --}}
                <div class="pt-3 border-t border-zinc-100 dark:border-zinc-800/80 space-y-2">
                    <span class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Rute Melalui:</span>
                    <ol class="space-y-1 text-xs text-zinc-700 dark:text-zinc-300 list-decimal pl-4">
                        <template x-for="(street, idx) in ruteMelalui" :key="idx">
                            <li x-text="street"></li>
                        </template>
                    </ol>
                </div>

                {{-- Cetak Action --}}
                <x-button.secondary type="button" class="w-full text-xs py-2.5 justify-center border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800" onclick="window.print()">
                    <x-slot name="icon"><x-icons.clipboard-list class="h-4 w-4" /></x-slot>
                    <span>Cetak Detail Rute</span>
                </x-button.secondary>

            </div>

        </div>

        {{-- Map View Area --}}
        <div class="lg:col-span-2 space-y-6 print:w-full print:p-0">
            
            {{-- Map Container --}}
            <div class="relative rounded-2xl border border-zinc-200 overflow-hidden dark:border-zinc-800 bg-zinc-100 dark:bg-zinc-950 h-[480px] print:h-[400px] print:w-full print:border-none print:shadow-none print:m-0" wire:ignore>
                <div id="peta-rute-canvas" class="w-full h-full"></div>

                {{-- Custom Layer Toggles --}}
                <div class="absolute top-4 left-4 z-[999] flex gap-1 rounded-xl bg-white/90 p-1 shadow-md dark:bg-zinc-900/90 backdrop-blur-sm print:hidden">
                    <button type="button" @click="toggleLayer('peta')" 
                        :class="currentLayerType === 'peta' ? 'bg-red-600 text-white font-bold' : 'text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800'"
                        class="px-3.5 py-1.5 text-[11px] rounded-lg transition-all duration-200">
                        Peta
                    </button>
                    <button type="button" @click="toggleLayer('satelit')" 
                        :class="currentLayerType === 'satelit' ? 'bg-red-600 text-white font-bold' : 'text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800'"
                        class="px-3.5 py-1.5 text-[11px] rounded-lg transition-all duration-200">
                        Satelit
                    </button>
                </div>

                {{-- Custom Legend --}}
                <div class="absolute top-4 right-4 z-[999] rounded-xl bg-white/95 p-4 shadow-md dark:bg-zinc-900/95 backdrop-blur-sm space-y-2 border border-zinc-100 dark:border-zinc-800/80 text-[10px] text-zinc-700 dark:text-zinc-300 print:bg-white print:text-zinc-900 print:shadow-none print:border-zinc-200">
                    <h4 class="font-bold text-zinc-900 dark:text-white print:text-zinc-900">Legenda</h4>
                    <div class="space-y-1.5 font-medium">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex w-3 h-3 rounded-full bg-red-500 border border-white shadow-sm"></span>
                            <span>Lokasi Pasien</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex w-3 h-3 rounded-full bg-blue-600 border border-white shadow-sm"></span>
                            <span>Rumah Sakit Rujukan</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex w-5 h-1 bg-red-600 rounded"></span>
                            <span>Rute Terpendek</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Turn-by-Turn Steps Detail --}}
            <div x-show="steps.length > 0" x-cloak
                class="rounded-2xl border border-zinc-200 p-6 dark:border-zinc-800 space-y-4 print:border-none print:shadow-none print:p-0 print:mt-6"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                
                <div class="flex justify-between items-center border-b border-zinc-100 pb-3 dark:border-zinc-800/80 print:pb-1">
                    <h3 class="font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                        <x-icons.checklist-stepper class="h-4.5 w-4.5 text-red-600" />
                        <span>Detail Rute</span>
                    </h3>
                    <x-button.secondary type="button" class="text-[11px] py-1.5 px-3 border-zinc-200 dark:border-zinc-700 print:hidden" onclick="window.print()">
                        <x-slot name="icon"><x-icons.paper-clip class="h-3.5 w-3.5" /></x-slot>
                        <span>Export PDF</span>
                    </x-button.secondary>
                </div>

                {{-- Table Navigation Steps --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 dark:text-zinc-400 font-semibold">
                                <th class="pb-2.5 w-12 text-center">Arah</th>
                                <th class="pb-2.5 pl-3">Instruksi Rute Jalan</th>
                                <th class="pb-2.5 text-right w-24">Jarak</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/50">
                            <template x-for="(st, idx) in steps" :key="idx">
                                <tr class="text-zinc-800 dark:text-zinc-200 hover:bg-zinc-50/50 dark:hover:bg-zinc-900/30 transition-colors">
                                    <td class="py-3 text-center">
                                        <span class="inline-flex w-7 h-7 items-center justify-center rounded-lg bg-zinc-100 dark:bg-zinc-800 text-sm font-bold text-zinc-700 dark:text-zinc-300 font-mono" x-text="st.icon"></span>
                                    </td>
                                    <td class="py-3 pl-3">
                                        <div class="font-semibold text-zinc-900 dark:text-white" x-text="st.title"></div>
                                        <div class="text-[10px] text-zinc-400 mt-0.5" x-show="st.address" x-text="st.address"></div>
                                    </td>
                                    <td class="py-3 text-right font-bold text-zinc-600 dark:text-zinc-400 font-mono" x-text="st.distance"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>

    {{-- Print Layout Stylesheet --}}
    <style>
        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            /* Sembunyikan sidebar, navbar, footer utama */
            aside, header, nav, #logo-sidebar, #tombolSidebar, .print\:hidden {
                display: none !important;
            }
            /* Rapikan main content space */
            main, .content-wrapper, .print\:space-y-0 {
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                box-shadow: none !important;
            }
            /* Map canvas set print scale */
            #peta-rute-canvas {
                width: 100% !important;
                height: 420px !important;
                border: 1px solid #ccc !important;
            }
            /* Table formatting */
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            th, td {
                color: #000 !important;
                border-bottom: 1px solid #ddd !important;
            }
        }
    </style>

</div>
