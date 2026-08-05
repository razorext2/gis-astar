{{-- Goal: Form tambah Rumah Sakit dengan Leaflet map + checkbox layanan --}}
<div class="w-full space-y-4" x-data>
    <div class="rounded-xl border border-zinc-200 p-6 shadow-sm dark:border-zinc-800"
        x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div class="flex items-center gap-4">
                <x-button.danger wire:navigate href="{{ route('rs.index') }}">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Tambah Rumah Sakit</h2>
                    <p class="text-sm text-gray-500">Daftarkan RS baru dan layanan yang tersedia</p>
                </div>
            </div>
            <x-button.primary wire:click="save" wire:loading.attr="disabled" wire:target="save">
                <x-slot name="icon">
                    <x-icons.loading wire:loading wire:target="save" class="h-4 w-4 animate-spin" />
                </x-slot>
                <span wire:loading.remove wire:target="save">Simpan RS</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </x-button.primary>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        {{-- Kiri: Data RS --}}
        <div class="space-y-4 lg:col-span-2">
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-6 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-blue-600"></div>
                    <h3 class="text-xl font-bold">Informasi Rumah Sakit</h3>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <x-input.basic wire:model="nama_rumah_sakit" id="nama_rs" type="text" placeholder="Nama rumah sakit">Nama Rumah Sakit</x-input.basic>
                        @error('nama_rumah_sakit') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input.basic wire:model="no_telepon" id="no_telepon" type="text" placeholder="021xxxxxxx">No. Telepon</x-input.basic>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Alamat</label>
                        <textarea wire:model="alamat" rows="3"
                            class="mt-1 w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm dark:border-zinc-600 dark:bg-zinc-800 dark:text-white"
                            placeholder="Alamat lengkap rumah sakit"></textarea>
                        @error('alamat') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input.basic wire:model.live="latitude" id="latitude" type="number" step="any">Latitude</x-input.basic>
                        @error('latitude') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input.basic wire:model.live="longitude" id="longitude" type="number" step="any">Longitude</x-input.basic>
                        @error('longitude') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Peta --}}
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-4 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-emerald-600"></div>
                    <h3 class="text-xl font-bold">Koordinat RS di Peta</h3>
                </div>
                <div id="map-rs-create" class="h-80 w-full rounded-lg border border-zinc-200 dark:border-zinc-700"></div>
                <p class="mt-2 text-xs text-zinc-500">Klik peta untuk menentukan lokasi RS</p>
            </div>
        </div>

        {{-- Kanan: Layanan Operasi --}}
        <div>
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-4 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-purple-600"></div>
                    <h3 class="text-xl font-bold">Layanan Operasi</h3>
                </div>
                <p class="mb-3 text-xs text-zinc-500">Centang layanan yang tersedia di RS ini</p>
                @error('layanan_operasi') <span class="text-xs text-red-500 block mb-2">{{ $message }}</span> @enderror
                <div class="space-y-2">
                    @foreach($layananPool as $layanan)
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-zinc-200 p-3 hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800">
                            <input type="checkbox" wire:model="layanan_operasi" value="{{ $layanan }}"
                                class="h-4 w-4 rounded border-zinc-300 text-blue-600">
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $layanan }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    (function() {
        const mapEl = document.getElementById('map-rs-create');
        if (!mapEl || mapEl._leaflet_id) return;
        const map = L.map('map-rs-create').setView([-6.2, 106.8], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        let marker = null;
        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            if (marker) marker.setLatLng([lat, lng]);
            else marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', ev => {
                const p = ev.target.getLatLng();
                @this.updateCoordinates(p.lat, p.lng);
            });
            @this.updateCoordinates(lat, lng);
        });
    })();
</script>
@endscript
