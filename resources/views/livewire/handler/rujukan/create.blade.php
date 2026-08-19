{{-- Goal: Analisis Rujukan page — Mobile-first redesigned to match reference image while preserving desktop layout --}}
<div class="w-full space-y-5 sm:space-y-6" x-data="analisisRujukanPage()">

    {{-- Row 1: Filter Card --}}
    @include('livewire.handler.rujukan.partials.filter-card')

    {{-- Row 2: Peta & Hasil Analisis (ditampilkan setelah Proses Analisis) --}}
    <div x-show="hasSearched"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="grid grid-cols-1 gap-4 sm:gap-5 lg:grid-cols-12">
        @include('livewire.handler.rujukan.partials.peta-rute')
        @include('livewire.handler.rujukan.partials.hasil-analisis')
    </div>

    {{-- Row 3: Rekomendasi & Detail Rute (ditampilkan setelah Proses Analisis) --}}
    <div x-show="hasSearched"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="grid grid-cols-1 gap-4 sm:gap-5 lg:grid-cols-12">
        @include('livewire.handler.rujukan.partials.rekomendasi')
        @include('livewire.handler.rujukan.partials.detail-rute')
    </div>

</div>

@script
    <script>
        Alpine.data('analisisRujukanPage', () => ({
            pasienId: @entangle('pasienId'),
            rumahSakitTarget: @entangle('rumahSakitTarget'),
            metode: @entangle('metode'),
            prioritasRute: @entangle('prioritasRute'),
            pasienList: @js($pasienList),
            rsList: @js($rumahSakitList),
            astarResult: @entangle('astarResult'),
            costPerKm: @js(config('services.ambulance.cost_per_km', 5000)),
            selectedIndex: 0,
            hasSearched: false,

            map: null,
            routeLayer: null,
            pasienMarker: null,
            rsMarker: null,

            steps: [],
            currentDistance: '-',
            currentDuration: '-',
            currentCost: '-',

            init() {
                this.$watch('astarResult', (val) => {
                    if (val) {
                        this.hasSearched = true;
                        this.$nextTick(() => {
                            setTimeout(() => {
                                this.initMap();
                                if (this.map) this.map.invalidateSize();
                                this.updateRouteDisplay();
                            }, 320); // > transition duration (300ms)
                        });
                        return;
                    }

                    // Reset state saat astarResult di-set null/falsy
                    this.hasSearched = false;
                    this.selectedIndex = 0;
                    this.steps = [];
                    this.currentDistance = '-';
                    this.currentDuration = '-';
                    this.currentCost = '-';

                    if (this.map) {
                        try {
                            this.map.remove();
                        } catch (e) {
                            console.error("Error removing map:", e);
                        }
                        this.map = null;
                        this.routeLayer = null;
                        this.pasienMarker = null;
                        this.rsMarker = null;
                    }
                });
                this.$watch('selectedIndex', () => this.updateRouteDisplay());
            },

            initMap() {
                const mapEl = document.getElementById('analisis-map');
                if (!mapEl) return;

                // Bersihkan _leaflet_id lama jika instansi Alpine.js map sudah direset (null)
                if (mapEl._leaflet_id && !this.map) {
                    try {
                        delete mapEl._leaflet_id;
                    } catch (e) {
                        mapEl._leaflet_id = undefined;
                    }
                }

                if (this.map) return;

                this.map = L.map('analisis-map').setView([3.5952, 98.6722], 13);

                L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                    attribution: '&copy; Google Maps'
                }).addTo(this.map);
            },

            selectCandidate(idx) {
                this.selectedIndex = idx;
                this.updateRouteDisplay();
            },

            async updateRouteDisplay() {
                if (!this.map) return;

                const pasien = this.pasienList.find(p => p.id_pasien == this.pasienId) || this.pasienList[
                0];
                if (!pasien || !pasien.latitude || !pasien.longitude) return;

                let activeHospital = null;
                if (this.astarResult && this.astarResult.all_ranked && this.astarResult.all_ranked[this
                        .selectedIndex]) {
                    activeHospital = this.astarResult.all_ranked[this.selectedIndex].hospital;
                } else if (this.rsList && this.rsList.length > 0) {
                    activeHospital = this.rsList[this.selectedIndex] || this.rsList[0];
                }

                if (!activeHospital) return;

                // Markers
                if (this.pasienMarker) this.map.removeLayer(this.pasienMarker);
                const pasienIcon = L.divIcon({
                    html: '<div style="width:16px;height:16px;background:#3b82f6;border:3px solid white;border-radius:50%;box-shadow:0 2px 6px rgba(59,130,246,.5)"></div>',
                    className: '',
                    iconSize: [16, 16],
                    iconAnchor: [8, 8]
                });
                this.pasienMarker = L.marker([pasien.latitude, pasien.longitude], {
                        icon: pasienIcon
                    })
                    .addTo(this.map)
                    .bindPopup(`<b>Lokasi Pasien</b><br>${pasien.nama}`);

                if (this.rsMarker) this.map.removeLayer(this.rsMarker);
                const rsIcon = L.divIcon({
                    html: '<div style="width:22px;height:22px;background:#ef4444;border:3px solid white;border-radius:6px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(239,68,68,.5);font-size:12px;color:white;font-weight:900">+</div>',
                    className: '',
                    iconSize: [22, 22],
                    iconAnchor: [11, 11]
                });
                this.rsMarker = L.marker([activeHospital.latitude, activeHospital.longitude], {
                        icon: rsIcon
                    })
                    .addTo(this.map)
                    .bindPopup(`<b>${activeHospital.nama_rumah_sakit}</b>`);

                // Fetch OSRM route
                const url =
                    `https://router.project-osrm.org/route/v1/driving/${pasien.longitude},${pasien.latitude};${activeHospital.longitude},${activeHospital.latitude}?overview=full&geometries=geojson&steps=true`;

                try {
                    const res = await fetch(url);
                    const data = await res.json();

                    if (data.routes && data.routes.length > 0) {
                        const route = data.routes[0];

                        this.currentDistance = (route.distance / 1000).toFixed(1).replace('.', ',');
                        this.currentDuration = Math.ceil(route.duration / 60);
                        this.currentCost = Math.round((route.distance / 1000) * this.costPerKm)
                            .toLocaleString('id-ID');

                        if (this.routeLayer) this.map.removeLayer(this.routeLayer);
                        this.routeLayer = L.geoJSON(route.geometry, {
                            style: {
                                color: '#10b981',
                                weight: 5,
                                opacity: 0.85
                            }
                        }).addTo(this.map);

                        this.map.fitBounds(this.routeLayer.getBounds(), {
                            padding: [35, 35]
                        });

                        // Format steps
                        const stepsFormatted = [];
                        stepsFormatted.push({
                            type: 'start',
                            icon: '📍',
                            title: `Lokasi Pasien [${pasien.nama}]`,
                            address: pasien.alamat || '-',
                            distance: '0 km'
                        });

                        route.legs[0].steps.forEach((step) => {
                            if (step.name && step.name.trim() !== "") {
                                const streetName = step.name.trim();
                                const mvr = step.maneuver || {};
                                const modifier = mvr.modifier;
                                const type = mvr.type;

                                let icon = '⬆';
                                let actionText = 'Lurus terus';

                                if (modifier === 'left') {
                                    icon = '↰';
                                    actionText = 'Belok kiri';
                                } else if (modifier === 'right') {
                                    icon = '↱';
                                    actionText = 'Belok kanan';
                                } else if (modifier === 'sharp left') {
                                    icon = '↶';
                                    actionText = 'Belok tajam kiri';
                                } else if (modifier === 'sharp right') {
                                    icon = '↷';
                                    actionText = 'Belok tajam kanan';
                                } else if (modifier === 'slight left') {
                                    icon = '↖';
                                    actionText = 'Serong kiri';
                                } else if (modifier === 'slight right') {
                                    icon = '↗';
                                    actionText = 'Serong kanan';
                                } else if (modifier === 'uturn') {
                                    icon = '↲';
                                    actionText = 'Putar balik';
                                } else if (type === 'merge') {
                                    icon = '⤳';
                                    actionText = 'Bergabung';
                                } else if (type === 'roundabout' || type === 'rotary') {
                                    icon = '↻';
                                    actionText = 'Masuk bundaran';
                                }

                                stepsFormatted.push({
                                    type: 'step',
                                    icon: icon,
                                    title: `${actionText} ke ${streetName}`,
                                    address: '',
                                    distance: `${(step.distance / 1000).toFixed(1).replace('.', ',')} km`
                                });
                            }
                        });

                        stepsFormatted.push({
                            type: 'end',
                            icon: '📍',
                            title: `Tujuan: ${activeHospital.nama_rumah_sakit}`,
                            address: activeHospital.alamat || '-',
                            distance: `Total ${this.currentDistance} km (${this.currentDuration} menit)`
                        });

                        this.steps = stepsFormatted;
                    }
                } catch (e) {
                    console.error("OSRM Error:", e);
                }
            }
        }));
    </script>
@endscript
