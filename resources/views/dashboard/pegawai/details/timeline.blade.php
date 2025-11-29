@extends('dashboard.pegawai.detail')
@section('menus')
    <div class="rounded-lg" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
        <div class="w-full">
            <div class="grid gap-6 md:grid-cols-2">

                {{-- search --}}
                <div class="w-full md:col-span-2">
                    <form id="dateForm" action="{{ route('pegawai.timeline', ['pegawai' => $pegawai->kode_pegawai]) }}"
                        method="GET">
                        <x-dashboard.date-picker id="datepicker-actions" name="date" form="dateForm" :text="'Filter tanggal'" />
                    </form>
                </div>
                {{-- endsearch --}}

                <div
                    class="w-full rounded-xl border border-gray-200 bg-white p-6 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none">
                    <div class="mb-4">
                        <p class="text-xl font-bold leading-none text-gray-900 dark:text-white md:text-2xl">
                            {{ $pegawai->full_name }}</p>
                        <p class="text-lg font-semibold leading-none text-gray-900 dark:text-white md:text-xl">
                            @if (Request::query('date'))
                                Lini masa,
                                {{ \Carbon\Carbon::parse(Request::query('date'))->locale('id')->isoFormat('D MMMM YYYY') }}
                            @else
                                Lini masa,
                                {{ \Carbon\Carbon::today()->locale('id')->isoFormat('D MMMM YYYY') }}
                            @endif
                        </p>
                    </div>

                    <ol class="relative ml-3 border-s border-gray-200 dark:border-gray-700" id="timelineContent">
                        @if ($attendances->isNotEmpty())
                            @foreach ($attendances as $data)
                                @php
                                    $path = asset(sha1('libs') . '/' . $data->photoURL . '.png'); // Gabungkan URL

                                    if (is_null($data->longitude)) {
                                        $isOnsite = true;
                                    } else {
                                        $isOnsite = false;
                                    }
                                    for ($i = 0; $i <= $attendances->count(); $i++);
                                @endphp

                                <li class="relative mb-10 ms-8">

                                    @if ($data->type == 'Check-in')
                                        <span
                                            class="absolute -start-11 flex h-6 w-6 items-center justify-center rounded-full bg-green-800 dark:bg-green-900">
                                            <x-icons.date class="h-2.5 w-2.5 text-green-100 dark:text-green-300" />
                                        </span>
                                    @elseif ($data->type == 'Checkpoint')
                                        <span
                                            class="absolute -start-11 flex h-6 w-6 items-center justify-center rounded-full bg-yellow-800 dark:bg-yellow-900">
                                            <x-icons.date class="h-2.5 w-2.5 text-yellow-100 dark:text-yellow-300" />
                                        </span>
                                    @else
                                        <span
                                            class="absolute -start-11 flex h-6 w-6 items-center justify-center rounded-full bg-red-800 dark:bg-red-900">
                                            <x-icons.date class="h-2.5 w-2.5 text-red-100 dark:text-red-300" />
                                        </span>
                                    @endif

                                    <h3 class="mb-1 flex items-center text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $data->type }}
                                    </h3>
                                    <span
                                        class="text-md mb-2 block font-normal leading-none text-gray-400 dark:text-gray-300">
                                        {{ $isOnsite ? 'Tidak ada data koordinat' : $data->longitude . ', ' . $data->latitude }}
                                    </span>

                                    <time
                                        class="mb-2 block text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
                                        {{ Carbon\Carbon::parse($data->created_at)->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss') }}
                                    </time>

                                    @if (!$loop->first)
                                        @php
                                            $prevRecord = $attendances[$loop->index - 1];
                                            $currentTime = Carbon\Carbon::parse($data->created_at);
                                            $prevTime = Carbon\Carbon::parse($prevRecord->created_at);
                                            $diffInMinutes = round($prevTime->diffInMinutes($currentTime, true));
                                        @endphp

                                        <p
                                            class="mb-2 block text-sm font-normal leading-none text-gray-400 dark:text-gray-300">
                                            +{{ countDistance($prevRecord->latitude, $prevRecord->longitude, $data->latitude, $data->longitude) != null ? countDistance($prevRecord->latitude, $prevRecord->longitude, $data->latitude, $data->longitude) : 'Tidak ada perubahan koordinat' }}
                                            dari titik sebelumnya
                                        </p>

                                        <p
                                            class="mb-2 block text-sm font-normal leading-none text-gray-400 dark:text-gray-300">
                                            Ditempuh dalam waktu ~{{ $diffInMinutes }} menit
                                        </p>
                                    @endif

                                    <img class="absolute !-top-2.5 right-0 h-16 w-16 rounded-lg object-cover"
                                        src="{{ $path }}" alt="" loading="lazy"
                                        onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';">
                                </li>
                            @endforeach
                        @else
                            <h1 class="text-center text-lg font-semibold text-gray-500">Tidak ada data</h1>
                        @endif

                    </ol>

                </div>

                <div
                    class="h-max w-full rounded-xl border border-gray-200 bg-white p-6 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none">
                    <div class="mb-4">
                        <p class="text-xl font-bold leading-none text-gray-900 dark:text-white md:text-2xl">
                            Mapping
                        </p>
                    </div>

                    <div class="z-10 h-[500px] rounded-lg" id="map"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk inisialisasi peta dengan koordinat yang diberikan
            function initializeMap() {
                // Inisialisasi peta tanpa titik awal
                var map = L.map('map').setView([3.591516090416829, 98.66902828216554], 13); // Default location

                // Menambahkan Tile Layer dari OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                // Koordinat Titik Awal, Titik Tengah, dan Titik Akhir dengan deskripsi
                var waypoints = [
                    @foreach ($attendances as $data)
                        {
                            coords: L.latLng({{ $data->latitude ? $data->latitude : '3.591516090416829' }},
                                {{ $data->longitude ? $data->longitude : '98.66902828216554' }}),
                            name: '{{ $data->type ?? 'Unknown Location' }}: {{ $data->created_at }}' // Ganti 'location_name' dengan nama lokasi atau deskripsi lain
                        },
                    @endforeach
                ];

                // Custom icon untuk marker
                var customIcon = L.icon({
                    iconUrl: "{{ asset('assets/img/marker.png') }}", // Ganti dengan path ke ikon Anda
                    iconSize: [25, 41], // Ukuran ikon
                    iconAnchor: [12, 41], // Titik untuk mengaitkan ikon ke koordinat
                    shadowUrl: "{{ asset('assets/img/marker-shadow.png') }}", // Ganti dengan path ke bayangan Anda
                    shadowSize: [41, 41] // Ukuran bayangan
                });

                // Menambahkan marker untuk setiap titik di waypoints
                waypoints.forEach(function(point) {
                    L.marker(point.coords, {
                            icon: customIcon
                        })
                        .addTo(map)
                        .bindPopup(`<b>${point.name}</b>`);
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
                            }).bindPopup(`<b>${waypoints[i].name}</b>`);
                        },
                        router: L.Routing.osrmv1({
                            serviceUrl: 'https://router.project-osrm.org/route/v1/'
                        }),
                        show: false // Menyembunyikan panel rute di map
                    }).addTo(map);
                }
            }

            // Inisialisasi peta dengan koordinat default
            initializeMap();
        });

        document.getElementById('dateForm').addEventListener('submit', function(e) {
            const dateInput = document.getElementById('datepicker-actions').value;

            if (dateInput) {
                // Update action URL to include 'date' parameter
                this.action += `?date=${dateInput}`;
            } else {
                // Prevent submission if date is not selected
                e.preventDefault();
                alert('Pilih tanggal terlebih dahulu!');
            }
        });
    </script>
@endpush
