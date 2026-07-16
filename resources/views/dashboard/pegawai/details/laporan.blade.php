{{-- Goal: Display employee collector report history and map location, Livewire: none, Alpine: none --}}
@extends('dashboard.pegawai.detail')
@section('menus')
    <div class="grid grid-cols-1 gap-2 lg:grid-cols-2 lg:gap-4" id="collectors" role="tabpanel">
        <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-800 lg:col-span-2 lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <form id="dateForm" action="{{ route('pegawai.collectors', ['pegawai' => $pegawai->kode_pegawai]) }}"
                method="GET" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-8 w-1 rounded-full bg-blue-600"></div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-gray-800 dark:text-white">Filter
                        Laporan</h3>
                </div>
                <div class="w-full sm:max-w-xs">
                    <x-dashboard.date-picker id="datepicker-actions" name="date" form="dateForm" :text="'Filter tanggal'" />
                </div>
            </form>
        </div>

        {{-- Report History --}}
        <div class="relative overflow-hidden rounded-xl border border-zinc-200 p-6 dark:border-zinc-800 lg:p-8"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="mb-8 border-b border-zinc-200 pb-4 dark:border-zinc-800">
                <h2 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white">
                    Laporan Kolektor
                </h2>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">
                    @if (Request::query('date'))
                        Histori,
                        {{ \Carbon\Carbon::parse(Request::query('date'))->locale('id')->isoFormat('D MMMM YYYY') }}
                    @else
                        Histori,
                        {{ \Carbon\Carbon::today()->locale('id')->isoFormat('D MMMM YYYY') }}
                    @endif
                </p>
            </div>

            <div class="relative overflow-hidden pl-2">
                <ol class="relative ml-4 border-l-2 border-dashed border-zinc-200 dark:border-zinc-800"
                    id="collectorsContent">
                    @if ($report->isNotEmpty())
                        @foreach ($report as $data)
                            <li class="relative mb-10 ml-8 transition-all last:mb-0 hover:translate-x-1">
                                {{-- Status Dot --}}
                                <div
                                    class="absolute -left-[50px] top-1 flex h-8 w-8 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg ring-4 ring-white dark:ring-zinc-900">
                                    <x-icons.checklist-stepper class="h-4 w-4" />
                                </div>

                                <div class="flex flex-col gap-1">
                                    <h3
                                        class="flex flex-wrap items-center gap-2 text-sm font-bold text-gray-900 dark:text-white">
                                        <a class="group flex items-center gap-1"
                                            href="{{ route('collect.show', \App\Support\IdObfuscator::encode($data->id)) }}"
                                            target="_blank">
                                            <span>{{ $data->title }}</span>
                                            <x-icons.eye
                                                class="h-3.5 w-3.5 text-blue-500 opacity-50 transition-opacity group-hover:opacity-100" />
                                        </a>

                                        @php
                                            $statusConfigs = [
                                                0 => [
                                                    'label' => 'Belum Lengkap',
                                                    'class' =>
                                                        'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                                ],
                                                1 => [
                                                    'label' => 'Approved',
                                                    'class' =>
                                                        'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                                ],
                                                2 => [
                                                    'label' => 'Diajukan',
                                                    'class' =>
                                                        'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                                ],
                                            ];
                                            $currentStatus = $statusConfigs[$data->status] ?? [
                                                'label' => 'Rejected',
                                                'class' =>
                                                    'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400',
                                            ];
                                        @endphp

                                        <span
                                            class="{{ $currentStatus['class'] }} inline-flex items-center rounded-lg px-2 py-0.5 text-[10px] font-bold uppercase tracking-tight">
                                            {{ $currentStatus['label'] }}
                                        </span>
                                    </h3>

                                    <div
                                        class="flex items-center gap-2 text-[11px] font-semibold text-gray-500 dark:text-gray-400">
                                        <x-icons.lock-time class="h-3 w-3" />
                                        <span>{{ $data->created_at->locale('id')->isoFormat('HH:mm:ss') }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div
                                class="mb-4 flex h-16 w-16 items-center justify-center rounded-xl bg-gray-50 dark:bg-zinc-800/50">
                                <x-icons.info class="h-8 w-8 text-gray-300" />
                            </div>
                            <h1 class="text-sm font-bold text-gray-500">Tidak ada data laporan</h1>
                        </div>
                    @endif
                </ol>
            </div>
        </div>

        {{-- Map Section --}}
        <div class="relative h-max overflow-hidden rounded-xl border border-zinc-200 p-6 dark:border-zinc-800 lg:p-8"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="mb-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-8 w-1 rounded-full bg-red-600"></div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Lokasi Laporan</h3>
                </div>
            </div>

            <div class="relative z-10 h-[500px] w-full overflow-hidden rounded-2xl border border-white/20 shadow-inner lg:h-[600px]"
                id="map"></div>
        </div>
    </div>

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
                    @foreach ($report as $data)
                        {
                            coords: L.latLng({{ $data->latitude ? $data->latitude : '3.591516090416829' }},
                                {{ $data->longitude ? $data->longitude : '98.66902828216554' }}),
                            name: '{{ $data->location ?? 'N/A' }}' // Ganti 'location_name' dengan nama lokasi atau deskripsi lain
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
@endsection
