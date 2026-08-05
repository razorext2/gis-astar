{{-- Goal: Form tambah pasien baru dengan map picker koordinat --}}
<div class="w-full space-y-4" x-data>
    {{-- Header --}}
    <div class="rounded-xl border border-zinc-200 p-6 shadow-sm dark:border-zinc-800"
        x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div class="flex items-center gap-4">
                <x-button.danger wire:navigate href="{{ route('pasien.index') }}">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white">Tambah Pasien</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Daftarkan data pasien baru ke sistem</p>
                </div>
            </div>
            <x-button.primary wire:click="save" wire:loading.attr="disabled" wire:target="save">
                <x-slot name="icon">
                    <x-icons.plus wire:loading.remove wire:target="save" class="h-5 w-5" />
                    <x-icons.loading wire:loading wire:target="save" class="h-4 w-4 animate-spin" />
                </x-slot>
                <span wire:loading.remove wire:target="save">Simpan Pasien</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </x-button.primary>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        {{-- Kiri: Data Diri --}}
        <div class="space-y-4 lg:col-span-2">
            <div class="group relative overflow-hidden rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-blue-500/5 blur-3xl"></div>
                <div class="mb-6 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-blue-600"></div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Data Diri Pasien</h3>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="space-y-1">
                        <x-input.basic wire:model="nik" id="nik" name="nik" type="text" placeholder="16 digit NIK">NIK</x-input.basic>
                        @error('nik') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input.basic wire:model="no_rm" id="no_rm" name="no_rm" type="text" placeholder="Nomor rekam medis">No. Rekam Medis</x-input.basic>
                        @error('no_rm') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input.basic wire:model="nama" id="nama" name="nama" type="text" placeholder="Nama lengkap pasien">Nama Lengkap</x-input.basic>
                        @error('nama') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Jenis Kelamin</label>
                        <select wire:model="jenis_kelamin" id="jenis_kelamin"
                            class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                            <option value="">-- Pilih --</option>
                            @foreach($jenisKelaminList as $jk)
                                <option value="{{ $jk->value }}">{{ $jk->label() }}</option>
                            @endforeach
                        </select>
                        @error('jenis_kelamin') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input.basic wire:model="tanggal_lahir" id="tanggal_lahir" name="tanggal_lahir" type="date">Tanggal Lahir</x-input.basic>
                    </div>
                    <div class="space-y-1">
                        <x-input.basic wire:model="no_telepon" id="no_telepon" name="no_telepon" type="text" placeholder="08xxxxxxxxxx">No. Telepon</x-input.basic>
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Alamat</label>
                        <textarea wire:model="alamat" id="alamat" rows="3"
                            class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white"
                            placeholder="Alamat lengkap pasien"></textarea>
                    </div>
                </div>
            </div>

            {{-- Koordinat Pasien --}}
            <div class="group relative overflow-hidden rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-emerald-500/5 blur-3xl"></div>
                <div class="mb-4 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-emerald-600"></div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Koordinat Lokasi</h3>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="space-y-1">
                        <x-input.basic wire:model.live="latitude" id="latitude" name="latitude" type="number" step="any" placeholder="-6.200000">Latitude</x-input.basic>
                        @error('latitude') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input.basic wire:model.live="longitude" id="longitude" name="longitude" type="number" step="any" placeholder="106.816666">Longitude</x-input.basic>
                        @error('longitude') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- GPS Button --}}
                <button type="button" id="gps-detect-btn"
                    class="mb-4 flex items-center gap-2 rounded-lg border border-emerald-300 bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300"
                    onclick="detectGPS('{{ $this->getId() }}')">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Deteksi Lokasi Saya (GPS)
                </button>

                {{-- Peta Leaflet --}}
                <div id="map-picker-create" class="h-64 w-full rounded-lg border border-zinc-200 dark:border-zinc-700"></div>
                <p class="mt-2 text-xs text-zinc-500">Klik peta untuk memilih lokasi atau drag marker</p>
            </div>
        </div>

        {{-- Kanan: Info --}}
        <div>
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-4 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-purple-600"></div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Panduan</h3>
                </div>
                <ul class="space-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                    <li class="flex items-start gap-2">
                        <span class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-blue-500"></span>
                        NIK wajib unik, 16 digit angka
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-emerald-500"></span>
                        Koordinat diperlukan untuk sistem rujukan otomatis A*
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-amber-500"></span>
                        Gunakan tombol GPS atau klik peta untuk mengisi koordinat
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@script
<script>
    // Init Leaflet map untuk picker
    (function initMapPicker() {
        const mapEl = document.getElementById('map-picker-create');
        if (!mapEl || mapEl._leaflet_id) return;

        const defaultLat = {{ $latitude ?? -6.2 }};
        const defaultLng = {{ $longitude ?? 106.8 }};

        const map = L.map('map-picker-create').setView([defaultLat, defaultLng], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        function onLocationChange(lat, lng) {
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], 14);
            @this.updateCoordinates(lat, lng);
        }

        marker.on('dragend', function(e) {
            const { lat, lng } = e.target.getLatLng();
            onLocationChange(lat, lng);
        });

        map.on('click', function(e) {
            onLocationChange(e.latlng.lat, e.latlng.lng);
        });

        window._mapPickerCreate = { map, marker, onLocationChange };
    })();

    window.detectGPS = function(componentId) {
        if (!navigator.geolocation) {
            Swal.fire('Error', 'Browser tidak mendukung geolocation', 'error');
            return;
        }
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                @this.updateCoordinates(lat, lng);
                if (window._mapPickerCreate) {
                    window._mapPickerCreate.onLocationChange(lat, lng);
                }
            },
            () => Swal.fire('Gagal', 'Tidak dapat mengakses GPS', 'warning'),
            { enableHighAccuracy: true, timeout: 10000 }
        );
    };
</script>
@endscript
