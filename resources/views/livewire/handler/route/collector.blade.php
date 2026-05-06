<div class="flex flex-col gap-2 lg:gap-4">

    <div class="z-10 h-96 w-full rounded-lg p-6" id="map"></div>

    <div class="w-full">
        <form class="flex flex-row items-end gap-2 lg:gap-4" wire:submit="search" method="POST">

            <div class="w-full">
                <input id="datepicker-route-collector" name="datepicker-route-colelctor" type="date"
                    class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                    placeholder="Pilih tanggal laporan" wire:model="date">
            </div>

            <x-button.primary class="h-fit items-center" id="submit" type="submit">
                Cari
            </x-button.primary>
        </form>
    </div>

    <h3 class="text-base font-semibold text-gray-800 dark:text-white">
        Laporan {{ $date ? \Carbon\Carbon::parse($date)->locale('id')->isoFormat('D MMMM YYYY') : 'Hari ini' }}
    </h3>

    <ol class="relative ml-3 border-s border-zinc-200 dark:border-zinc-800" id="collectContent">

        @forelse ($data as $row)
            <li class="relative mb-4 ms-8 flex flex-col gap-1 rounded-lg p-2 transition-all duration-300 ease-in-out hover:bg-gray-50 focus:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 dark:focus:ring-offset-dark-primary"
                data-marker-index="{{ $loop->index }}" tabindex="0">
                <span
                    class="absolute -start-11 flex h-6 w-6 items-center justify-center rounded-full bg-green-800 dark:bg-green-900">
                    <x-icons.date class="h-2.5 w-2.5 text-green-100 dark:text-green-300" />
                </span>

                <div class="flex items-center text-sm text-gray-900 dark:text-white">
                    <a class="group" href="{{ route('collect.show', $row->id) }}" target="_blank">
                        {{ $row->title }}
                        <span class="text-blue-500 group-hover:underline">
                            [ 👁 ]
                        </span>
                    </a>

                    @php
                        $status = match ($row->status) {
                            0 => [
                                'color' => 'yellow',
                                'label' => 'Belum diupdate.',
                            ],
                            1 => [
                                'color' => 'green',
                                'label' => 'Disetujui piutang.',
                            ],
                            2 => [
                                'color' => 'yellow',
                                'label' => 'Menunggu validasi.',
                            ],
                            3 => [
                                'color' => 'red',
                                'label' => 'Laporan ditolak.',
                            ],
                            4 => [
                                'color' => 'yellow',
                                'label' => 'Perlu direvisi.',
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

                @php
                    $type = match ($row->bill_type) {
                        'idcnonppn' => 'collectTaskRelasi',
                        'idcppn' => 'collectTaskPpnRelasi',
                        'idyppn' => 'collectIdyPpnRelasi',
                        default => 'collectTaskRelasi',
                    };
                @endphp

                <span class="font-semibold text-gray-800 dark:text-white">
                    {{ $row->$type->customer_name }} - {{ $row->$type->no_sr }}
                </span>


                @if ($row->latitude && !$loop->first)
                    <span class="text-md flex flex-col gap-1 font-normal leading-none text-gray-400 dark:text-gray-300">
                        @php
                            $prevRecord = $data[$loop->index - 1];
                            $currentTime = Carbon\Carbon::parse($row->assign_at);
                            $prevTime = Carbon\Carbon::parse($prevRecord->assign_at);
                            $diffInMinutes = round($prevTime->diffInMinutes($currentTime, true));
                        @endphp

                        <p class="block text-sm font-normal leading-none text-gray-400 dark:text-gray-300">
                            +{{ countDistance($prevRecord->latitude, $prevRecord->longitude, $row->latitude, $row->longitude) != null ? countDistance($prevRecord->latitude, $prevRecord->longitude, $row->latitude, $row->longitude) : 'Tidak ada perubahan koordinat' }}
                            dari titik sebelumnya
                        </p>

                        <p class="block text-sm font-normal leading-none text-gray-400 dark:text-gray-300">
                            Ditempuh dalam waktu ~{{ $diffInMinutes }} menit
                        </p>
                    </span>
                @endif

                <div class="flex items-center lg:gap-x-4">
                    <div class="flex flex-col gap-1 text-xs font-normal leading-none text-gray-400 dark:text-gray-500">
                        <p> Dibuat piutang:</p>
                        <time>
                            {{ \Carbon\Carbon::parse($row->created_at)->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss') }}
                        </time>
                    </div>
                    <div class="flex flex-col gap-1 text-xs font-normal leading-none text-gray-400 dark:text-gray-500">
                        @if ($row->assign_at)
                            <p> Diupdate kolektor:</p>
                            <time>
                                {{ \Carbon\Carbon::parse($row->assign_at)->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss') }}
                            </time>
                        @endif

                    </div>
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
            // Inisialisasi peta tanpa titik awal
            map = L.map('map').setView([3.591516090416829, 98.66902828216554], 4); // Default location

            // Menambahkan Tile Layer dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var defaultCoords = [3.591516090416829, 98.66902828216554];

            // Ambil data rute dari Blade sekali, lalu olah di JS
            var waypointsData = @json($waypointsData);

            var waypoints = (waypointsData || []).map(function(point) {
                var lat = parseFloat(point.lat) || defaultCoords[0];
                var lng = parseFloat(point.lng) || defaultCoords[1];

                return {
                    coords: L.latLng(lat, lng),
                    name: `
                    <div class="flex flex-col">
                        <span class="font-semibold">${point.title ?? '-' } - ${point.customer_name ?? '-'}</span>
                        <span class="text-xs">${point.location ?? ''}</span>
                    </div>`
                };
            });

            // Custom icon untuk marker
            var customIcon = L.icon({
                iconUrl: "{{ asset('assets/img/marker.png') }}", // Ganti dengan path ke ikon Anda
                iconSize: [25, 41], // Ukuran ikon
                iconAnchor: [12, 41], // Titik untuk mengaitkan ikon ke koordinat
                popupAnchor: [0, -25], // Geser popup agar lebih rapi terhadap marker
                shadowUrl: "{{ asset('assets/img/marker-shadow.png') }}", // Ganti dengan path ke bayangan Anda
                shadowSize: [41, 41] // Ukuran bayangan
            });

            // Menambahkan marker untuk setiap titik di waypoints
            waypoints.forEach(function(point) {
                var marker = L.marker(point.coords, {
                        icon: customIcon
                    })
                    .addTo(map)
                    .bindPopup(point.name, {
                        className: 'route-popup',
                        autoPanPaddingTopLeft: [30, 30],
                        autoPanPaddingBottomRight: [30, 30]
                    });

                marker.on('add', function() {
                    var el = marker.getElement();
                    if (el) {
                        el.classList.add('marker-with-transition');
                    }
                });

                markers.push(marker);
            });

            // Menentukan bounds (batas) untuk menampilkan semua marker
            if (waypoints.length > 1) {
                var bounds = L.latLngBounds(waypoints.map(point => point.coords));
                map.fitBounds(bounds); // Otomatis menyesuaikan peta agar mencakup semua titik
            }

            // Menambahkan Routing dari Titik Awal ke Titik Akhir
            if (waypoints.length > 1) {
                L.Routing.control({
                    waypoints: waypoints.map(point => point.coords),
                    routeWhileDragging: false, // Mencegah rute diubah saat dragging
                    createMarker: function(i, waypoint) {
                        // Menambahkan marker dengan pop-up informasi
                        return L.marker(waypoint.latLng, {
                            icon: customIcon,
                            draggable: false // Menonaktifkan draggable pada marker
                        }).bindPopup(waypoints[i].name, {
                            className: 'route-popup',
                            autoPanPaddingTopLeft: [30, 30],
                            autoPanPaddingBottomRight: [30, 30]
                        });
                    },
                    show: false // Menyembunyikan panel rute di map
                }).addTo(map);
            }

            attachHoverEvents();
        }

        // Inisialisasi peta dengan koordinat default
        initializeMap();

        function attachHoverEvents() {
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
                    map.panTo(marker.getLatLng());

                    var mapElement = document.getElementById('map');
                    if (mapElement) {
                        // Scroll dengan offset supaya peta tidak menempel di bagian atas layar.
                        var targetY = mapElement.getBoundingClientRect().top + window.scrollY -
                            135;
                        window.scrollTo({
                            top: targetY,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        }
    });
</script>
