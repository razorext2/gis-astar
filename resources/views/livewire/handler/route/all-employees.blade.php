{{-- Goal: Redesign rute absensi & map tracking dengan tema liquid glass/solid premium, Livewire: App\Livewire\Handler\Route\AllEmployees, Alpine: dynamicBg --}}

<div class="flex flex-col gap-6" x-data="{ activeIndex: null }">

    <!-- Section 1: Filter Panel -->
    <div class="rounded-xl border p-4 shadow-sm transition-all duration-300 md:p-6"
        x-bind:class="dynamicBg
            ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

        <div class="mb-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Filter Pencarian</h3>
        </div>

        <form class="grid grid-cols-1 items-end gap-4 sm:grid-cols-2 lg:grid-cols-4" wire:submit="search" method="POST">
            <div>
                <label class="mb-2 block text-xs font-semibold text-zinc-500 dark:text-zinc-400"
                    for="datepicker-route-collector">
                    Tanggal Laporan
                </label>
                <div class="relative">
                    <input id="datepicker-route-collector" name="datepicker-route-colelctor" type="date"
                        class="block w-full rounded-lg border border-zinc-200 bg-zinc-50 p-2.5 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white dark:placeholder-zinc-500 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        wire:model="date">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-xs font-semibold text-zinc-500 dark:text-zinc-400" for="name">
                    Nama Staff
                </label>
                <x-input.basic id="name" name="name" :labels="false" wire:model="name"
                    placeholder="Nama teknisi/mekanik" />
            </div>

            <div>
                <label class="mb-2 block text-xs font-semibold text-zinc-500 dark:text-zinc-400" for="role">
                    Role Pekerjaan
                </label>
                <x-input.select id="role" name="role" :labels="false" :options="[
                    'Mekanik' => 'Mekanik',
                    'Teknisi' => 'Teknisi',
                ]" :defaultOption="'Pilih role'"
                    wire:model="role" />
            </div>

            <div class="flex items-center gap-3">
                <x-button.primary class="h-10 flex-1 shadow-blue-500/20" id="submit" type="submit">
                    <x-slot name="icon">
                        <x-icons.search class="h-4 w-4" />
                    </x-slot>
                    Cari
                </x-button.primary>

                <x-button.danger class="h-10 flex-1 shadow-red-500/20" type="button" id="cancel"
                    wire:click="cancel">
                    Batal
                </x-button.danger>
            </div>
        </form>
    </div>

    <!-- Section 2: Main Content Grid (Split-screen on desktop) -->
    <div class="grid grid-cols-1 items-stretch gap-6 lg:grid-cols-12">

        <!-- Left Side: List of Staff / Absensi Log (4 Cols on Desktop) -->
        <div class="flex flex-col gap-4 rounded-xl border p-4 shadow-sm transition-all duration-300 md:p-6 lg:col-span-5 xl:col-span-4"
            x-bind:class="dynamicBg
                ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <div
                class="flex flex-row items-center justify-between border-b border-zinc-100 pb-4 dark:border-zinc-800/80">
                <div class="flex flex-col">
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white">
                        Log Absensi Staff
                    </h3>
                    <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">
                        {{ $date ? \Carbon\Carbon::parse($date)->locale('id')->isoFormat('D MMMM YYYY') : 'Hari ini' }}
                    </p>
                </div>

                <div class="w-28 shrink-0">
                    <x-input.select id="sort" class="!p-1.5 text-xs" name="sort" wire:model.live="sort"
                        :labels="false" :options="[
                            'asc' => 'Tercepat',
                            'desc' => 'Terlama',
                        ]" :defaultOption="'Urutkan'" />
                </div>
            </div>

            <!-- Scrollable List Container -->
            <div class="scrollbar-thin scrollbar-thumb-zinc-200 dark:scrollbar-thumb-zinc-800 max-h-[600px] overflow-y-auto pr-2"
                id="collectContent">
                <ol class="relative ml-4 flex flex-col gap-4 border-s-2 border-zinc-200 pl-6 dark:border-zinc-800">
                    @forelse ($datas as $row)
                        @php
                            $status = match ($row->status) {
                                0 => [
                                    'color' => 'amber',
                                    'badge' =>
                                        'border-amber-200/50 bg-amber-50 text-amber-800 dark:border-amber-900/30 dark:bg-amber-950/20 dark:text-amber-400',
                                    'label' => 'Belum divalidasi',
                                ],
                                1 => [
                                    'color' => 'emerald',
                                    'badge' =>
                                        'border-emerald-200/50 bg-emerald-50 text-emerald-800 dark:border-emerald-900/30 dark:bg-emerald-950/20 dark:text-emerald-400',
                                    'label' => 'Diterima',
                                ],
                                2 => [
                                    'color' => 'rose',
                                    'badge' =>
                                        'border-rose-200/50 bg-rose-50 text-rose-800 dark:border-rose-900/30 dark:bg-rose-950/20 dark:text-rose-400',
                                    'label' => 'Ditolak',
                                ],
                                default => [
                                    'color' => 'zinc',
                                    'badge' =>
                                        'border-zinc-200/50 bg-zinc-50 text-zinc-800 dark:border-zinc-700/30 dark:bg-zinc-800/20 dark:text-zinc-400',
                                    'label' => 'Tidak diketahui',
                                ],
                            };
                            $roleName = $row->user->roles?->first()?->name ?? 'Tidak diketahui';
                            $isMekanik = $roleName === 'Mekanik';
                        @endphp

                        <li class="group relative cursor-pointer rounded-xl border border-transparent p-3 outline-none transition-all duration-200 focus:outline-none"
                            :class="activeIndex === {{ $loop->index }} ?
                                'bg-blue-500/10 border-blue-500/30 dark:bg-blue-500/5 dark:border-blue-500/20 shadow-sm' :
                                'hover:bg-zinc-50 dark:hover:bg-zinc-900/40'"
                            data-marker-index="{{ $loop->index }}" @click="activeIndex = {{ $loop->index }}"
                            tabindex="0">

                            <!-- Timeline Dot Indicator -->
                            <span
                                class="h-6.5 w-6.5 absolute -start-[35px] top-4 flex items-center justify-center rounded-full border-2 transition-all duration-300"
                                :class="activeIndex === {{ $loop->index }} ?
                                    'bg-blue-500 border-white dark:border-zinc-950 text-white scale-110 shadow-sm shadow-blue-500/50' :
                                    'bg-zinc-100 border-zinc-200 text-zinc-500 dark:bg-zinc-900 dark:border-zinc-800 dark:text-zinc-400 group-hover:border-zinc-400 dark:group-hover:border-zinc-600'">
                                <x-icons.map-pin class="h-3 w-3" />
                            </span>

                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center justify-between gap-2">
                                    <span
                                        class="{{ $status['badge'] }} rounded-full border px-2 py-0.5 text-xs font-semibold">
                                        {{ $status['label'] }}
                                    </span>
                                    <span class="font-mono text-[10px] text-zinc-400 dark:text-zinc-500">
                                        {{ \Carbon\Carbon::parse($row->created_at)->locale('id')->isoFormat('HH:mm') }}
                                        WIB
                                    </span>
                                </div>

                                <div class="flex flex-col">
                                    <p class="text-sm font-bold text-zinc-800 transition-colors dark:text-zinc-200"
                                        :class="activeIndex === {{ $loop->index }} ? 'text-blue-600 dark:text-blue-400' : ''">
                                        {{ $row->pegawaiRelasi->full_name }}
                                    </p>
                                    <p class="mt-0.5 flex items-center gap-1.5 text-xs font-semibold">
                                        <span
                                            class="{{ $isMekanik ? 'bg-red-500' : 'bg-blue-500' }} inline-block h-2 w-2 rounded-full"></span>
                                        <span
                                            class="{{ $isMekanik ? 'text-red-500 dark:text-red-400' : 'text-blue-500 dark:text-blue-400' }}">
                                            {{ $roleName }}
                                        </span>
                                    </p>
                                </div>

                                @if ($row->keterangan)
                                    <p
                                        class="rounded-lg border border-zinc-100 bg-zinc-50 p-2 text-xs italic text-zinc-500 dark:border-zinc-800/50 dark:bg-zinc-900/60 dark:text-zinc-400">
                                        "{{ $row->keterangan }}"
                                    </p>
                                @endif

                                <div
                                    class="mt-1 flex items-center justify-between border-t border-zinc-100 pt-2 text-[11px] text-zinc-400 dark:border-zinc-800/50 dark:text-zinc-500">
                                    <span class="flex items-center gap-1">
                                        <x-icons.globe class="h-3 w-3 shrink-0" />
                                        {{ $row->latitude ? round($row->latitude, 5) : '0' }},
                                        {{ $row->longitude ? round($row->longitude, 5) : '0' }}
                                    </span>
                                    <span class="text-zinc-300 dark:text-zinc-700">|</span>
                                    <span>
                                        {{ \Carbon\Carbon::parse($row->created_at)->locale('id')->isoFormat('DD MMM YYYY') }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div
                                class="mb-3 rounded-full border border-zinc-200/50 bg-zinc-50 p-3 dark:border-zinc-800/50 dark:bg-zinc-900/60">
                                <x-icons.user-group class="h-6 w-6 text-zinc-400 dark:text-zinc-500" />
                            </div>
                            <h4 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Tidak Ada Data Absensi
                            </h4>
                            <p class="mt-1 max-w-xs text-xs text-zinc-500 dark:text-zinc-400">
                                Silakan coba ubah filter tanggal atau kata kunci pencarian.
                            </p>
                        </div>
                    @endforelse
                </ol>
            </div>
        </div>

        <!-- Right Side: Leaflet Map Container (8 Cols on Desktop) -->
        <div class="relative flex min-h-[550px] flex-col overflow-hidden rounded-xl border shadow-sm transition-all duration-300 lg:col-span-7 lg:h-full xl:col-span-8"
            x-bind:class="dynamicBg
                ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <!-- Map Target -->
            <div class="z-10 h-[550px] min-h-[550px] w-full flex-1 lg:h-full" id="map"></div>

            <!-- Custom Floating Google Layers Toggle -->
            <div class="group absolute bottom-4 left-4 z-20 h-14 w-14 cursor-pointer select-none overflow-hidden rounded-xl border-2 border-white shadow-lg transition-all duration-200 hover:scale-105 active:scale-95 dark:border-zinc-800"
                id="map-layer-toggle" title="Ubah jenis peta">
                <img id="layer-toggle-img" src="https://mt1.google.com/vt/lyrs=s&x=25&y=16&z=5"
                    class="h-full w-full object-cover">
                <div class="absolute inset-x-0 bottom-0 bg-black/60 py-0.5 text-center text-[9px] font-bold uppercase tracking-wider text-white group-hover:bg-black/85"
                    id="layer-toggle-text">
                    Satelit
                </div>
            </div>

            <!-- Legend Overlay (Floating Google Style) -->
            <div class="absolute right-4 top-4 z-20 flex max-w-xs flex-col gap-2.5 rounded-xl border p-3 shadow-lg transition-all duration-300"
                x-bind:class="dynamicBg
                    ?
                    'bg-glass-light/95 dark:bg-glass-dark/95 border-glass-border-light dark:border-glass-border-dark backdrop-blur-md' :
                    'bg-white/95 dark:bg-zinc-900/95 border-zinc-200 dark:border-zinc-800'">

                <h4
                    class="mb-1 border-b border-zinc-100 pb-1.5 text-[10px] font-bold uppercase tracking-wider text-zinc-400 dark:border-zinc-800/60 dark:text-zinc-500">
                    Keterangan Marker
                </h4>

                <div class="flex flex-col gap-2">
                    <span class="flex flex-row items-center gap-2.5 text-xs text-zinc-700 dark:text-zinc-300">
                        <div
                            class="flex h-5 w-5 items-center justify-center rounded-full border border-blue-500/30 bg-blue-500/10 dark:bg-blue-500/20">
                            <img src="{{ asset('assets/img/marker.png') }}" alt="icon-teknisi" class="w-3">
                        </div>
                        <span class="font-medium">Teknisi (Biru)</span>
                    </span>
                    <span class="flex flex-row items-center gap-2.5 text-xs text-zinc-700 dark:text-zinc-300">
                        <div
                            class="flex h-5 w-5 items-center justify-center rounded-full border border-red-500/30 bg-red-500/10 dark:bg-red-500/20">
                            <img src="{{ asset('assets/img/marker-red.png') }}" alt="icon-mekanik" class="w-3">
                        </div>
                        <span class="font-medium">Mekanik (Merah)</span>
                    </span>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map;
        var markers = [];

        // Fungsi untuk inisialisasi peta dengan koordinat yang diberikan
        function initializeMap() {
            // Titik tengah Indonesia
            var defaultCoords = [-2.544021, 118.042905];
            var defaultZoom = 5;
            // Batas kasar wilayah Indonesia (barat ke timur)
            var indoBounds = L.latLngBounds([
                [-11.2, 94.5],
                [6.1, 141.1]
            ]);

            // Inisialisasi peta dengan zoom control dinonaktifkan secara default (kita taruh di bottomright)
            map = L.map('map', {
                zoomControl: false
            }).setView(defaultCoords, defaultZoom);

            // Tambahkan zoom control di bottom-right ala Google Maps
            L.control.zoom({
                position: 'bottomright'
            }).addTo(map);

            // Google Hybrid Layer (Satelit + Label Jalan)
            var googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: 'Map data &copy; Google'
            });

            // Google Roadmap Layer (Peta Standard Terang)
            var googleRoadmap = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: 'Map data &copy; Google'
            });

            // Aktifkan Google Roadmap secara default (seperti Google Maps biasa)
            googleRoadmap.addTo(map);

            // Setup Custom Layer Toggle di Bottom Left
            var currentLayer = 'roadmap';
            var toggleBtn = document.getElementById('map-layer-toggle');
            var toggleImg = document.getElementById('layer-toggle-img');
            var toggleText = document.getElementById('layer-toggle-text');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    if (currentLayer === 'roadmap') {
                        map.removeLayer(googleRoadmap);
                        googleHybrid.addTo(map);
                        currentLayer = 'satellite';
                        toggleText.innerText = 'Peta';
                        // Ganti thumbnail ke gambar peta roadmap
                        toggleImg.src = 'https://mt1.google.com/vt/lyrs=m&x=25&y=16&z=5';
                    } else {
                        map.removeLayer(googleHybrid);
                        googleRoadmap.addTo(map);
                        currentLayer = 'roadmap';
                        toggleText.innerText = 'Satelit';
                        // Ganti thumbnail ke gambar satelit
                        toggleImg.src = 'https://mt1.google.com/vt/lyrs=s&x=25&y=16&z=5';
                    }
                });
            }

            // Ambil data rute dari Blade sekali, lalu olah di JS
            var waypointsData = @json($waypoints);

            var waypoints = (waypointsData || []).map(function(point) {
                var lat = parseFloat(point.lat) || defaultCoords[0];
                var lng = parseFloat(point.lng) || defaultCoords[1];

                return {
                    coords: L.latLng(lat, lng),
                    popup: `
                    <div class="flex flex-col p-1">
                        <span class="font-bold text-sm text-zinc-900">${point.name}</span>
                        <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 mt-0.5">${point.role}</span>
                        ${point.keterangan ? `<span class="text-xs text-zinc-600 bg-zinc-50 border border-zinc-100 rounded p-1.5 mt-1.5 max-w-[200px] break-words">"${point.keterangan}"</span>` : ''}
                    </div>`,
                    role: point.role,
                };
            });

            // Menambahkan marker untuk setiap titik di waypoints
            waypoints.forEach(function(point, idx) {
                var icon = "{{ asset('assets/img/marker-red.png') }}"

                if (point.role == 'Teknisi') {
                    icon = "{{ asset('assets/img/marker.png') }}"
                }

                var marker = L.marker(point.coords, {
                        icon: L.icon({
                            iconUrl: icon,
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [0, -25],
                            shadowUrl: "{{ asset('assets/img/marker-shadow.png') }}",
                            shadowSize: [41, 41]
                        })
                    })
                    .addTo(map)
                    .bindPopup(point.popup, {
                        autoPanPaddingTopLeft: [30, 30],
                        autoPanPaddingBottomRight: [30, 30]
                    });

                // Link marker click to select list item
                marker.on('click', function() {
                    var el = document.querySelector(
                        `#collectContent [data-marker-index="${idx}"]`);
                    if (el) {
                        el.click();
                    }
                });

                markers.push(marker);
            });

            // Menentukan bounds (batas) untuk menampilkan semua marker
            if (waypoints.length > 0) {
                var bounds = L.latLngBounds(waypoints.map(point => point.coords));
                // Perluas bounds agar tetap mencakup wilayah timur Indonesia
                bounds.extend(indoBounds);
                map.fitBounds(bounds, {
                    padding: [30, 30],
                    maxZoom: 18
                });
            } else {
                // Tanpa data, tetap tampilkan keseluruhan Indonesia
                map.fitBounds(indoBounds, {
                    padding: [30, 30],
                    maxZoom: 6
                });
            }

            attachClickEvent();
        }

        // Inisialisasi peta
        initializeMap();

        function attachClickEvent() {
            var listItems = document.querySelectorAll('#collectContent [data-marker-index]');

            listItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    var markerIndex = parseInt(item.dataset.markerIndex, 10);
                    var marker = markers[markerIndex];

                    if (!marker) return;

                    // Pindahkan fokus agar kelas focus:* tampil di item yang diklik.
                    item.focus({
                        preventScroll: true
                    });

                    marker.openPopup();
                    var targetLatLng = marker.getLatLng();
                    var targetZoom = Math.max(map.getZoom(), 7);

                    var mapElement = document.getElementById('map');
                    if (mapElement && window.innerWidth < 1024) {
                        // Scroll dengan offset supaya peta tidak menempel di bagian atas layar (hanya mobile).
                        var targetY = mapElement.getBoundingClientRect().top + window.scrollY -
                            135;
                        window.scrollTo({
                            top: targetY,
                            behavior: 'smooth'
                        });
                        // Setelah scroll selesai, pastikan ukuran map valid lalu pusatkan lagi ke marker
                        setTimeout(function() {
                            map.invalidateSize();
                            map.setView(targetLatLng, targetZoom, {
                                animate: false
                            });
                            marker.openPopup();
                        }, 250);
                    } else {
                        // Pada desktop, langsung set view & open popup secara interaktif tanpa scrolling window
                        map.setView(targetLatLng, targetZoom, {
                            animate: true,
                            duration: 0.4
                        });
                        setTimeout(function() {
                            marker.openPopup();
                        }, 100);
                    }
                });
            });
        }
    });
</script>
