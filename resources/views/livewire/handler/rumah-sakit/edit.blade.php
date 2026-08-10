{{-- Goal: Form edit RS --}}
<div class="w-full space-y-4" x-data>
    <div class="rounded-xl border border-zinc-200 p-6 shadow-sm dark:border-zinc-800"
        x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div class="flex items-center gap-4">
                <x-button.danger wire:navigate href="{{ route('rs.index') }}">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Rumah Sakit</h2>
                    <p class="text-sm text-gray-500">{{ $rumahSakit->nama_rumah_sakit }}</p>
                </div>
            </div>
            <x-button.primary wire:click="save" wire:loading.attr="disabled" wire:target="save">
                <x-slot name="icon"><x-icons.loading wire:loading wire:target="save" class="h-4 w-4 animate-spin" /></x-slot>
                <span wire:loading.remove wire:target="save">Simpan</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </x-button.primary>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <div class="space-y-4 lg:col-span-2">
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-5 flex items-center justify-between border-b border-zinc-100 pb-4 dark:border-zinc-800">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                            <x-icons.office-building class="h-4.5 w-4.5" />
                        </div>
                        <h3 class="font-bold text-zinc-900 dark:text-white">Informasi Rumah Sakit</h3>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="md:col-span-2 space-y-1">
                        <x-input.basic wire:model="nama_rumah_sakit" type="text" placeholder="Nama lengkap rumah sakit">Nama RS</x-input.basic>
                        @error('nama_rumah_sakit') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2 space-y-1">
                        <x-input.basic wire:model="no_telepon" type="text" placeholder="021xxxxxxx">No. Telepon</x-input.basic>
                        @error('no_telepon') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2 space-y-1">
                        <x-input.textarea wire:model="alamat" id="alamat" rows="3" placeholder="Alamat lengkap rumah sakit">Alamat</x-input.textarea>
                        @error('alamat') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input.basic wire:model.live="latitude" type="number" step="any" placeholder="-90.000000">Latitude</x-input.basic>
                        @error('latitude') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input.basic wire:model.live="longitude" type="number" step="any" placeholder="180.000000">Longitude</x-input.basic>
                        @error('longitude') <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-4 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-emerald-600"></div>
                    <h3 class="text-xl font-bold">Koordinat di Peta</h3>
                </div>
                <div wire:ignore id="map-rs-edit" class="h-72 w-full rounded-lg border border-zinc-200 dark:border-zinc-700"></div>
            </div>
        </div>

        <div>
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-4 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-purple-600"></div>
                    <h3 class="text-xl font-bold">Layanan Operasi</h3>
                </div>
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
        const mapEl = document.getElementById('map-rs-edit');
        if (!mapEl || mapEl._leaflet_id) return;
        const lat = {{ $latitude ?? 3.595196 }};
        const lng = {{ $longitude ?? 98.672223 }};
        const map = L.map('map-rs-edit').setView([lat, lng], 14);
        L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps'
        }).addTo(map);
        const marker = L.marker([lat, lng], { draggable: true }).addTo(map);
        function upd(lat, lng) { marker.setLatLng([lat, lng]); @this.updateCoordinates(lat, lng); }
        marker.on('dragend', e => { const p = e.target.getLatLng(); upd(p.lat, p.lng); });
        map.on('click', e => upd(e.latlng.lat, e.latlng.lng));
    })();
</script>
@endscript
