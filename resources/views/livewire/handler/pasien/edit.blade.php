{{-- Goal: Form edit pasien dengan map picker --}}
<div class="w-full space-y-4" x-data>
    <div class="rounded-xl border border-zinc-200 p-6 shadow-sm dark:border-zinc-800"
        x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div class="flex items-center gap-4">
                <x-button.danger wire:navigate href="{{ route('pasien.index') }}">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white">Edit Pasien</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $pasien->nama }} — NIK: {{ $pasien->nik }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <x-button.danger type="button"
                    x-on:click="Swal.fire({
                        title: 'Hapus Pasien?',
                        text: 'Data pasien {{ $pasien->nama }} akan dihapus.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then((res) => {
                        if (res.isConfirmed) {
                            $wire.delete();
                        }
                    })"
                    wire:loading.attr="disabled"
                    wire:target="delete">
                    <x-slot name="icon">
                        <x-icons.trash wire:loading.remove wire:target="delete" class="h-4 w-4" />
                        <x-icons.loading wire:loading wire:target="delete" class="h-4 w-4 animate-spin" />
                    </x-slot>
                    <span wire:loading.remove wire:target="delete">Hapus Pasien</span>
                    <span wire:loading wire:target="delete">Menghapus...</span>
                </x-button.danger>
                <x-button.primary wire:click="save" wire:loading.attr="disabled" wire:target="save">
                    <x-slot name="icon">
                        <x-icons.loading wire:loading wire:target="save" class="h-4 w-4 animate-spin" />
                    </x-slot>
                    <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </x-button.primary>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <div class="space-y-4 lg:col-span-2">
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-6 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-blue-600"></div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Data Diri Pasien</h3>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="space-y-1">
                        <x-input.basic wire:model="nik" id="nik" name="nik" type="text">NIK</x-input.basic>
                        @error('nik') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input.basic wire:model="no_rm" id="no_rm" name="no_rm" type="text">No. Rekam Medis</x-input.basic>
                    </div>
                    <div class="space-y-1">
                        <x-input.basic wire:model="nama" id="nama" name="nama" type="text">Nama Lengkap</x-input.basic>
                        @error('nama') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Jenis Kelamin</label>
                        <select wire:model="jenis_kelamin"
                            class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white [&>option]:dark:bg-zinc-800 [&>option]:dark:text-white">
                            @foreach($jenisKelaminList as $jk)
                                <option value="{{ $jk->value }}">{{ $jk->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div><x-input.basic wire:model="tanggal_lahir" id="tanggal_lahir" name="tanggal_lahir" type="date">Tanggal Lahir</x-input.basic></div>
                    <div><x-input.basic wire:model="no_telepon" id="no_telepon" name="no_telepon" type="text">No. Telepon</x-input.basic></div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Alamat</label>
                        <textarea wire:model.blur="alamat" rows="3"
                            class="mt-1 w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm dark:border-zinc-600 dark:bg-zinc-800 dark:text-white"></textarea>
                        <div class="mt-2 flex justify-end">
                            <x-button.secondary type="button" wire:click="geocodeAddress" wire:loading.attr="disabled"
                                class="h-9 text-xs">
                                <x-slot name="icon">
                                    <x-icons.search wire:loading.remove wire:target="geocodeAddress" class="h-4 w-4" />
                                    <x-icons.loading wire:loading wire:target="geocodeAddress" class="h-4 w-4 animate-spin" />
                                </x-slot>
                                Cari Koordinat dari Alamat
                            </x-button.secondary>
                        </div>

                        @if(!empty($addressSuggestions))
                            <div class="mt-3 space-y-1">
                                <label class="block text-[11px] font-semibold text-blue-600 dark:text-blue-400">Beberapa Lokasi Terkait Ditemukan:</label>
                                <select wire:change="selectAddressSuggestion($event.target.value)"
                                    class="w-full rounded-lg border border-blue-300 bg-blue-50 px-3 py-2 text-xs text-blue-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-blue-700 dark:bg-zinc-800 dark:text-white">
                                    <option class="dark:bg-zinc-800 dark:text-white" value="">-- Silakan pilih alamat yang sesuai untuk menetapkan pin --</option>
                                    @foreach($addressSuggestions as $index => $item)
                                        <option class="dark:bg-zinc-800 dark:text-white" value="{{ $index }}">{{ $item['display_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Koordinat --}}
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-4 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-emerald-600"></div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Koordinat Lokasi</h3>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-input.basic wire:model.live="latitude" id="latitude" type="number" step="any">Latitude</x-input.basic>
                        @error('latitude') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input.basic wire:model.live="longitude" id="longitude" type="number" step="any">Longitude</x-input.basic>
                        @error('longitude') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div x-data="{ gpsLoading: false }" class="mb-4">
                    <x-button.secondary type="button"
                        x-bind:disabled="gpsLoading"
                        x-on:click="gpsLoading = true; detectGPS(() => gpsLoading = false)">
                        <x-slot name="icon">
                            <x-icons.map-pin x-show="!gpsLoading" class="h-4 w-4" />
                            <x-icons.loading x-show="gpsLoading" class="h-4 w-4 animate-spin" />
                        </x-slot>
                        <span x-show="!gpsLoading">Deteksi GPS</span>
                        <span x-show="gpsLoading">Mendeteksi...</span>
                    </x-button.secondary>
                </div>
                <div wire:ignore id="map-picker-edit" class="h-64 w-full rounded-lg border border-zinc-200 dark:border-zinc-700"></div>
            </div>
        </div>

        <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800 h-fit"
            x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
            <div class="mb-4 flex items-center gap-3">
                <div class="h-10 w-1 rounded-full bg-amber-500"></div>
                <h3 class="text-lg font-bold">Info Pasien</h3>
            </div>
            <dl class="space-y-2 text-sm">
                <dt class="text-zinc-500">Terdaftar</dt>
                <dd class="font-medium">{{ $pasien->created_at->locale('id')->isoFormat('DD MMM YYYY') }}</dd>
                <dt class="text-zinc-500 mt-2">Total Rujukan</dt>
                <dd class="font-medium">{{ $pasien->rujukan()->count() }}</dd>
            </dl>
        </div>
    </div>
</div>

@script
<script>
    (function() {
        const mapEl = document.getElementById('map-picker-edit');
        if (!mapEl || mapEl._leaflet_id) return;
        const lat = {{ $latitude ?? 3.595196 }};
        const lng = {{ $longitude ?? 98.672223 }};
        const map = L.map('map-picker-edit').setView([lat, lng], 14);
        L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps'
        }).addTo(map);
        const marker = L.marker([lat, lng], { draggable: true }).addTo(map);
        function update(lat, lng) {
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng]);
            @this.updateCoordinates(lat, lng);
        }
        marker.on('dragend', e => { const p = e.target.getLatLng(); update(p.lat, p.lng); });
        map.on('click', e => update(e.latlng.lat, e.latlng.lng));
        window._mapPickerEdit = { update };
    })();

    window.detectGPS = function(callback) {
        if (!navigator.geolocation) {
            Swal.fire('Error', 'Browser tidak mendukung geolocation', 'error');
            if (callback) callback();
            return;
        }
        navigator.geolocation.getCurrentPosition(
            pos => {
                window._mapPickerEdit?.update(pos.coords.latitude, pos.coords.longitude);
                if (callback) callback();
            },
            () => {
                Swal.fire('Gagal', 'GPS tidak tersedia', 'warning');
                if (callback) callback();
            },
            { enableHighAccuracy: true }
        );
    };

    window.addEventListener('coordinates-updated', event => {
        const { lat, lng } = event.detail;
        if (window._mapPickerEdit) {
            window._mapPickerEdit.update(lat, lng);
        }
    });
</script>
@endscript
