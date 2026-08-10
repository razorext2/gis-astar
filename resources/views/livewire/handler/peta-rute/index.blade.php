{{-- Goal: Menampilkan visualisasi peta & rute interaktif berdasarkan data rujukan yang tersimpan, Livewire: Handler.PetaRute.Index --}}
<div class="flex flex-col gap-4" x-data="{
    rujukanId: @entangle('rujukanId'),
    pasienId: @entangle('pasienId'),
    rsId: @entangle('rsId'),
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
    hasRouteLoaded: false,

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

        // Pastikan ukuran peta terhitung dengan benar setelah init
        setTimeout(() => {
            if (this.map) this.map.invalidateSize();
        }, 200);
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

    clearRoute() {
        if (this.markerPasien) this.map.removeLayer(this.markerPasien);
        if (this.markerRs) this.map.removeLayer(this.markerRs);
        if (this.routeLayer) this.map.removeLayer(this.routeLayer);
        this.markerPasien = null;
        this.markerRs = null;
        this.routeLayer = null;
        this.steps = [];
        this.currentDistance = '-';
        this.currentDuration = '-';
        this.estimasiTiba = '-';
        this.ruteMelalui = [];
        this.hasRouteLoaded = false;
        if (this.map) {
            this.map.setView([3.595196, 98.672223], 12);
            this.map.invalidateSize();
        }
    },

    loadRoute(evt) {
        let payload = evt;
        if (Array.isArray(evt) && evt.length > 0) {
            payload = evt[0];
        }
        if (payload && payload.detail) {
            payload = Array.isArray(payload.detail) ? payload.detail[0] : payload.detail;
        }
        if (!payload || !payload.pasien || !payload.rs) {
            console.error('Payload rute invalid:', payload);
            return;
        }

        // Re-evaluate Leaflet canvas size
        setTimeout(() => {
            if (this.map) this.map.invalidateSize();
        }, 100);

        // Hapus layer lama jika ada
        if (this.markerPasien) this.map.removeLayer(this.markerPasien);
        if (this.markerRs) this.map.removeLayer(this.markerRs);
        if (this.routeLayer) this.map.removeLayer(this.routeLayer);

        const latPasien = payload.pasien.lat;
        const lngPasien = payload.pasien.lng;
        const latRs = payload.rs.lat;
        const lngRs = payload.rs.lng;

        // Custom marker icons
        const pasienIcon = L.divIcon({
            html: `<div class='flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white shadow-lg border-2 border-white font-bold text-xs'>P</div>`,
            className: '',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        const rsIcon = L.divIcon({
            html: `<div class='flex items-center justify-center w-8 h-8 rounded-full bg-emerald-600 text-white shadow-lg border-2 border-white font-bold text-xs'>RS</div>`,
            className: '',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        // Tambah marker baru
        this.markerPasien = L.marker([latPasien, lngPasien], { icon: pasienIcon })
            .addTo(this.map)
            .bindPopup(`<div class='p-1'><b class='text-xs text-zinc-900 dark:text-zinc-100'>${payload.pasien.nama}</b><br><span class='text-[11px] text-zinc-500 dark:text-zinc-400'>${payload.pasien.alamat}</span></div>`);

        this.markerRs = L.marker([latRs, lngRs], { icon: rsIcon })
            .addTo(this.map)
            .bindPopup(`<div class='p-1'><b class='text-xs text-zinc-900 dark:text-zinc-100'>${payload.rs.nama}</b><br><span class='text-[11px] text-zinc-500 dark:text-zinc-400'>${payload.rs.alamat}</span></div>`);

        // Immediately fit bounds to patient & hospital markers
        const bounds = L.latLngBounds([[latPasien, lngPasien], [latRs, lngRs]]);
        this.map.fitBounds(bounds, { padding: [60, 60] });

        // Set summary statistics
        this.currentDistance = payload.jarak.toFixed(1).replace('.', ',') + ' km';
        this.currentDuration = Math.ceil(payload.waktu / 60) + ' menit';
        this.estimasiTiba = payload.estimasi_tiba;
        this.kondisi = payload.kondisi;
        this.hasRouteLoaded = true;

        const fallbackSteps = [
            {
                icon: '📍',
                title: `Lokasi Pasien (${payload.pasien.nama})`,
                address: payload.pasien.alamat,
                distance: '0 km',
                isEndpoint: true
            },
            {
                icon: '⬆',
                title: `Rute Perjalanan ke ${payload.rs.nama}`,
                address: `Jalur langsung rujukan`,
                distance: `${this.currentDistance}`,
                isEndpoint: false
            },
            {
                icon: '🏥',
                title: `Tujuan: ${payload.rs.nama}`,
                address: payload.rs.alamat,
                distance: `Total ${this.currentDistance} (${this.currentDuration})`,
                isEndpoint: true
            }
        ];

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
                            color: '#10b981',
                            weight: 5,
                            opacity: 0.85
                        }
                    }).addTo(this.map);

                    this.map.fitBounds(this.routeLayer.getBounds(), { padding: [50, 50] });

                    // Parse turn-by-turn steps
                    const parsedSteps = [];
                    const uniqueStreets = new Set();

                    parsedSteps.push({
                        icon: '📍',
                        title: `Lokasi Pasien (${payload.pasien.nama})`,
                        address: payload.pasien.alamat,
                        distance: '0 km',
                        isEndpoint: true
                    });

                    route.legs[0].steps.forEach(step => {
                        if (step.name && step.name.trim() !== '') {
                            const street = step.name.trim();
                            uniqueStreets.add(street);

                            const modifier = step.maneuver.modifier;
                            const type = step.maneuver.type;

                            let icon = '⬆';
                            let action = 'Lurus terus';

                            if (modifier === 'left') { icon = '↰'; action = 'Belok kiri'; }
                            else if (modifier === 'right') { icon = '↱'; action = 'Belok kanan'; }
                            else if (modifier === 'sharp left') { icon = '↶'; action = 'Belok tajam kiri'; }
                            else if (modifier === 'sharp right') { icon = '↷'; action = 'Belok tajam kanan'; }
                            else if (modifier === 'slight left') { icon = '↖'; action = 'Serong kiri'; }
                            else if (modifier === 'slight right') { icon = '↗'; action = 'Serong kanan'; }
                            else if (modifier === 'uturn') { icon = '↲'; action = 'Putar balik'; }
                            else if (type === 'merge') { icon = '⤳'; action = 'Bergabung'; }
                            else if (type === 'roundabout' || type === 'rotary') { icon = '↻'; action = 'Masuk bundaran'; }

                            parsedSteps.push({
                                icon: icon,
                                title: `${action} ke ${street}`,
                                address: '',
                                distance: (step.distance / 1000).toFixed(1).replace('.', ',') + ' km',
                                isEndpoint: false
                            });
                        }
                    });

                    parsedSteps.push({
                        icon: '🏥',
                        title: `Tujuan: ${payload.rs.nama}`,
                        address: payload.rs.alamat,
                        distance: `Total ${this.currentDistance} (${this.currentDuration})`,
                        isEndpoint: true
                    });

                    this.steps = parsedSteps;
                    this.ruteMelalui = Array.from(uniqueStreets).filter(s => s && s.trim() !== '' && s !== '-').slice(0, 5);
                } else {
                    this.drawFallbackPolyline(latPasien, lngPasien, latRs, lngRs);
                    this.steps = fallbackSteps;
                    this.ruteMelalui = ['Rute Langsung Koordinat Pasien & RS'];
                }
            })
            .catch(err => {
                console.error('OSRM Fetch error, using fallback polyline:', err);
                this.drawFallbackPolyline(latPasien, lngPasien, latRs, lngRs);
                this.steps = fallbackSteps;
                this.ruteMelalui = ['Rute Langsung Koordinat Pasien & RS'];
            });
    },

    drawFallbackPolyline(latPasien, lngPasien, latRs, lngRs) {
        if (this.routeLayer) this.map.removeLayer(this.routeLayer);
        this.routeLayer = L.polyline([[latPasien, lngPasien], [latRs, lngRs]], {
            color: '#10b981',
            weight: 5,
            dashArray: '8, 8',
            opacity: 0.9
        }).addTo(this.map);
        this.map.fitBounds(this.routeLayer.getBounds(), { padding: [50, 50] });
    }
}" x-init="initMap()" x-on:rute-loaded.window="loadRoute($event.detail)" x-on:clear-route.window="clearRoute()" class="print:space-y-0 print:bg-white print:p-0">

    {{-- ───── Row 1: Form Filter Pasien & Rumah Sakit ───── --}}
    @include('livewire.handler.peta-rute.partials.filter-card')

    {{-- ───── Row 2: Peta & Hasil Ringkasan ───── --}}
    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:grid-cols-12 print:grid-cols-1 print:gap-0">
        {{-- Peta Rute Container (7/12) --}}
        <div class="lg:col-span-7 print:w-full">
            @include('livewire.handler.peta-rute.partials.peta-canvas')
        </div>

        {{-- Hasil Ringkasan (5/12) --}}
        <div class="lg:col-span-5 print:hidden">
            @include('livewire.handler.peta-rute.partials.summary-card')
        </div>
    </div>

    {{-- ───── Row 3: Detail Navigasi Belokan Table ───── --}}
    @include('livewire.handler.peta-rute.partials.navigation-steps')

    {{-- Leaflet Dark Mode Custom Stylesheet --}}
    <style>
        .dark .leaflet-tile {
            filter: brightness(0.65) invert(1) contrast(3) hue-rotate(200deg) saturate(0.3) brightness(0.7) !important;
        }
        .dark .leaflet-container {
            background-color: #09090b !important;
        }
        .dark .leaflet-popup-content-wrapper,
        .dark .leaflet-popup-tip {
            background-color: #18181b !important;
            color: #fafafa !important;
            border: 1px solid #27272a !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.6) !important;
        }
        .dark .leaflet-popup-content b {
            color: #ffffff !important;
        }
        .dark .leaflet-popup-content span {
            color: #a1a1aa !important;
        }
        .dark .leaflet-control-zoom a {
            background-color: #18181b !important;
            color: #fafafa !important;
            border-color: #27272a !important;
        }
        .dark .leaflet-control-zoom a:hover {
            background-color: #27272a !important;
        }
    </style>

</div>
