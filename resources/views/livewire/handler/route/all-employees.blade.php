<div class="flex flex-col gap-2 lg:gap-4">

    <div class="relative h-[500px] w-full">
        <div class="z-10 h-[500px] w-full rounded-lg p-6" id="map"></div>
        <div class="absolute bottom-2 left-2 z-10 flex flex-col gap-1 rounded-lg bg-white p-2 dark:bg-dark-secondary">
            <p class="text-sm font-semibold text-gray-800 dark:text-white">Legend:</p>
            <span class="flex flex-row items-center gap-2 text-xs text-gray-600 dark:text-white">
                <img src="{{ asset('assets/img/marker.png') }}" alt="icon-teknisi" class="w-2.5">
                <span class="text-gray-600 dark:text-white">Teknisi</span>
            </span>
            <span class="flex flex-row items-center gap-2 text-xs text-gray-600 dark:text-white">
                <img src="{{ asset('assets/img/marker-red.png') }}" alt="icon-teknisi" class="w-2.5">
                <span class="text-gray-600 dark:text-white">Mekanik</span>
            </span>
        </div>
    </div>

    <div class="w-full">
        <p class="text-sm text-gray-600 dark:text-white">
            Filter:
        </p>

        <form class="grid grid-cols-2 items-end gap-2 lg:flex lg:grid-cols-none lg:flex-row" wire:submit="search"
            method="POST">

            <div class="w-full">
                <input id="datepicker-route-collector" name="datepicker-route-colelctor" type="date"
                    class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                    placeholder="Pilih tanggal laporan" wire:model="date">
            </div>

            <div class="w-full">
                <x-input.basic id="name" name="name" wire:model="name" placeholder="Nama teknisi/mekanik" />
            </div>

            <div class="w-full">
                <x-input.select id="role" name="role" :labels="false" :options="[
                    'Mekanik' => 'Mekanik',
                    'Teknisi' => 'Teknisi',
                ]" :defaultOption="'Pilih role'"
                    wire:model="role" />
            </div>

            <div class="flex flex-row justify-end gap-2">
                <x-button.primary class="h-fit items-center" id="submit" type="submit">
                    Cari
                </x-button.primary>

                <x-button.danger class="h-fit items-center" type="button" id="cancel" wire:click="cancel">
                    Batal
                </x-button.danger>
            </div>
        </form>
    </div>

    <div class="flex flex-row items-center justify-between">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white">
            Track Posisi Staff by Absensi
            {{ $date ? \Carbon\Carbon::parse($date)->locale('id')->isoFormat('D MMMM YYYY') : 'Hari ini' }}
        </h3>

        <div class="w-fit">
            <x-input.select id="sort" class="text-xs" name="sort" wire:model.live="sort" :labels="false"
                :options="[
                    'asc' => 'Tercepat',
                    'desc' => 'Terlama',
                ]" :defaultOption="'Urutkan'" />
        </div>
    </div>

    <ol class="relative ml-3 border-s border-zinc-200 dark:border-zinc-800" id="collectContent">

        @forelse ($datas as $row)
            <li class="relative mb-4 ms-8 flex flex-col gap-1 rounded-lg p-2 transition-all duration-300 ease-in-out hover:bg-gray-50 focus:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 dark:focus:ring-offset-dark-primary"
                data-marker-index="{{ $loop->index }}" tabindex="0">
                <span
                    class="absolute -start-11 flex h-6 w-6 items-center justify-center rounded-full bg-green-800 dark:bg-green-900">
                    <x-icons.date class="h-2.5 w-2.5 text-green-100 dark:text-green-300" />
                </span>

                <div class="flex items-center text-sm text-gray-900 dark:text-white">
                    <span class="text-gray-600 dark:text-gray-400">
                        {{ $row->keterangan ?? 'Absensi masuk' }}
                    </span>

                    @php
                        $status = match ($row->status) {
                            0 => [
                                'color' => 'yellow',
                                'label' => 'Belum divalidasi.',
                            ],
                            1 => [
                                'color' => 'green',
                                'label' => 'Diterima.',
                            ],
                            2 => [
                                'color' => 'red',
                                'label' => 'Ditolak.',
                            ],
                            default => [
                                'color' => 'red',
                                'label' => 'Tidak diketahui.',
                            ],
                        };
                    @endphp

                    <span
                        class="bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800 dark:bg-{{ $status['color'] }}-900 dark:text-{{ $status['color'] }}-300 me-2 ms-3 rounded-lg px-1 py-0.5 text-xs">
                        {{ $status['label'] }}
                    </span>
                </div>

                <p class="font-semibold text-gray-800 dark:text-white">
                    {{ $row->pegawaiRelasi->full_name }} -
                    <span
                        class="{{ $row->user->roles?->first()?->name == 'Mekanik' ? 'text-red-500' : 'text-blue-500' }}">{{ $row->user->roles?->first()?->name ?? 'Tidak diketahui.' }}</span>
                </p>

                <p class="block text-sm font-normal leading-none text-gray-400 dark:text-gray-300">
                    {{ $row->latitude }}, {{ $row->longitude }}
                </p>

                <div class="flex flex-col gap-1 text-xs font-normal leading-none text-gray-400 dark:text-gray-500">
                    <p> Waktu dibuat:</p>
                    <time>
                        {{ \Carbon\Carbon::parse($row->created_at)->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss') }}
                    </time>
                </div>
            </li>
        @empty
            <h1 class="text-center text-lg font-semibold text-gray-500">Tidak ada data</h1>
        @endforelse
    </ol>

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

            // Inisialisasi peta tanpa titik awal
            map = L.map('map').setView(defaultCoords, defaultZoom); // Default location

            // Menambahkan Tile Layer satelit (Esri World Imagery)
            L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 18
                }).addTo(map);


            // Ambil data rute dari Blade sekali, lalu olah di JS
            var waypointsData = @json($waypoints);

            var waypoints = (waypointsData || []).map(function(point) {
                var lat = parseFloat(point.lat) || defaultCoords[0];
                var lng = parseFloat(point.lng) || defaultCoords[1];

                return {
                    coords: L.latLng(lat, lng),
                    popup: `
                    <div class="flex flex-col">
                        <span class="font-semibold">${point.name} -  ${point.role}</span>
                        <span class="text-xs">${point.keterangan}</span>
                    </div>`,
                    role: point.role,
                };
            });

            // Menambahkan marker untuk setiap titik di waypoints
            waypoints.forEach(function(point) {
                var icon = "{{ asset('assets/img/marker-red.png') }}"

                if (point.role == 'Teknisi') {
                    icon = "{{ asset('assets/img/marker.png') }}"
                }

                var marker = L.marker(point.coords, {
                        icon: L.icon({
                            iconUrl: icon, // Ganti dengan path ke ikon Anda
                            iconSize: [25, 41], // Ukuran ikon
                            iconAnchor: [12, 41],
                            popupAnchor: [0, -25],
                            shadowUrl: "{{ asset('assets/img/marker-shadow.png') }}", // Ganti dengan path ke bayangan Anda
                            shadowSize: [41, 41] // Ukuran bayangan
                        })
                    })
                    .addTo(map)
                    .bindPopup(point.popup, {
                        autoPanPaddingTopLeft: [30, 30],
                        autoPanPaddingBottomRight: [30, 30]
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

        // Inisialisasi peta dengan koordinat default
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
                    map.setView(targetLatLng, targetZoom, {
                        animate: true,
                        duration: 0.4
                    });
                    map.once('moveend', function() {
                        marker.openPopup();
                    });

                    var mapElement = document.getElementById('map');
                    if (mapElement) {
                        // Scroll dengan offset supaya peta tidak menempel di bagian atas layar.
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
                    }
                });
            });
        }
    });
</script>
