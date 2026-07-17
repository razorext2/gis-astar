{{-- Goal: Shared form view penempatan (create & edit), Livewire: Handler\Placement\Create|Edit, Alpine: radius slider entangle + map bridge --}}
<div class="mt-4 grid gap-4 lg:grid-cols-2" x-data="{
    radius: $wire.entangle('radius'),
    radiusType: '',
    lastLimitedRadius: 100,
    init() {
        if (this.radius >= 999999999) {
            this.radiusType = 'unlimited';
            this.lastLimitedRadius = 100;
        } else {
            this.radiusType = 'limited';
            this.lastLimitedRadius = this.radius || 100;
        }
        this.$watch('radiusType', val => {
            if (val === 'unlimited') {
                this.radius = 999999999;
            } else {
                this.radius = this.lastLimitedRadius;
            }
        });
        this.$watch('radius', val => {
            if (val < 999999999) {
                this.lastLimitedRadius = val;
            }
            window.dispatchEvent(new CustomEvent('placement-radius-changed', { detail: { radius: val } }));
        });
    }
}"
    x-on:map-pin-updated.window="$wire.set('longitude', $event.detail.lng); $wire.set('latitude', $event.detail.lat)">
    {{-- ===================== KOLOM FORM ===================== --}}
    <div class="w-full rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none sm:p-6"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <div class="max-w-xl">

            {{-- Header --}}
            <header class="flex flex-row items-center">
                <x-button.danger href="{{ route('placement.index') }}" class="my-auto me-4 max-h-10" wire:navigate>
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>

                <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ isset($placement) ? 'Edit Data Penempatan' : 'Tambah Penempatan' }}
                </h2>
            </header>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                Silahkan sesuaikan data dibawah ini dengan data yang benar.
            </p>

            <div class="mt-6 grid gap-5">

                {{-- Kode Penempatan --}}
                <div class="w-full">
                    <x-input.basic id="kode_penempatan" name="kode_penempatan" wire:model="kode_penempatan"
                        class="{{ $errors->has('kode_penempatan') ? 'border-red-500 bg-red-50' : 'border-zinc-200 bg-white' }}"
                        placeholder="Contoh: PLC-001">
                        Kode Penempatan
                    </x-input.basic>

                    @error('kode_penempatan')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Penempatan --}}
                <div class="w-full">
                    <x-input.basic id="penempatan" name="penempatan" wire:model="penempatan"
                        class="{{ $errors->has('penempatan') ? 'border-red-500 bg-red-50' : 'border-zinc-200 bg-white' }}"
                        placeholder="Nama kantor / lokasi">
                        Nama Penempatan
                    </x-input.basic>

                    @error('penempatan')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Pembatasan Akses --}}
                <div class="w-full">
                    <x-input.select id="restrict_app" name="restrict_app" wire:model="restrict_app"
                        class="{{ $errors->has('restrict_app') ? 'border-red-500 bg-red-50' : 'border-zinc-200 bg-white' }}"
                        :defaultOption="'-- Pilih --'" :options="['y' => 'Ya - Dibatasi', 't' => 'Tidak - Bebas']" :labels="true" :textLabel="'Pembatasan Akses Aplikasi'" />

                    @error('restrict_app')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- HRD (Multi-Select Searchable) --}}
                <div class="w-full" x-data="{
                    open: false,
                    search: '',
                    selectedIds: $wire.entangle('hrd_ids'),
                    users: {{ Js::from($users->map(fn($u) => ['id' => $u->id, 'name' => $u->name, 'kode' => $u->pegawai ? $u->pegawai->kode_pegawai : ''])) }},
                    get filteredUsers() {
                        if (this.search === '') return this.users.filter(u => !this.selectedIds.includes(u.id)).slice(0, 5);
                        return this.users.filter(u =>
                            (u.name.toLowerCase().includes(this.search.toLowerCase()) ||
                                u.kode.toLowerCase().includes(this.search.toLowerCase())) &&
                            !this.selectedIds.includes(u.id)
                        ).slice(0, 5);
                    },
                    get selectedUsers() {
                        return this.selectedIds.map(id => this.users.find(u => u.id === id)).filter(Boolean);
                    },
                    add(id) {
                        if (!this.selectedIds.includes(id)) {
                            this.selectedIds.push(id);
                        }
                        this.search = '';
                        this.open = false;
                    },
                    remove(id) {
                        this.selectedIds = this.selectedIds.filter(i => i !== id);
                    }
                }" @click.away="open = false">
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                        Tim HRD
                    </label>

                    {{-- Selected Chips --}}
                    <div class="mb-2 flex flex-wrap gap-2" x-show="selectedUsers.length > 0" style="display: none;">
                        <template x-for="user in selectedUsers" :key="user.id">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                <span x-text="user.name"></span>
                                <button type="button" @click="remove(user.id)"
                                    class="inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-red-600 hover:bg-red-200 hover:text-red-900 dark:hover:bg-red-800 dark:hover:text-red-200">
                                    <x-icons.close class="h-2 w-2" />
                                </button>
                            </span>
                        </template>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative">
                        <input type="text" x-model="search" @focus="open = true"
                            class="{{ $errors->has('hrd_ids') ? 'border-red-500 bg-red-50' : 'border-zinc-200 bg-white' }} block w-full rounded-lg border p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            placeholder="Cari nama atau NIP HRD...">

                        {{-- Dropdown --}}
                        <div x-show="open && filteredUsers.length > 0" x-transition style="display: none;"
                            class="absolute z-10 mt-1 max-h-48 w-full overflow-y-auto rounded-lg bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800 dark:ring-white dark:ring-opacity-10">
                            <template x-for="user in filteredUsers" :key="user.id">
                                <button type="button" @click="add(user.id)"
                                    class="flex w-full flex-col items-start px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white"
                                        x-text="user.name"></span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400" x-text="user.kode"></span>
                                </button>
                            </template>
                        </div>
                        <div x-show="open && search !== '' && filteredUsers.length === 0" style="display: none;"
                            class="absolute z-10 mt-1 w-full rounded-lg bg-white px-4 py-3 text-sm text-gray-500 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800 dark:text-gray-400 dark:ring-white dark:ring-opacity-10">
                            Tidak ada data ditemukan.
                        </div>
                    </div>

                    @error('hrd_ids')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Management (Multi-Select Searchable) --}}
                <div class="w-full" x-data="{
                    open: false,
                    search: '',
                    selectedIds: $wire.entangle('management_ids'),
                    users: {{ Js::from($users->map(fn($u) => ['id' => $u->id, 'name' => $u->name, 'kode' => $u->pegawai ? $u->pegawai->kode_pegawai : ''])) }},
                    get filteredUsers() {
                        if (this.search === '') return this.users.filter(u => !this.selectedIds.includes(u.id)).slice(0, 5);
                        return this.users.filter(u =>
                            (u.name.toLowerCase().includes(this.search.toLowerCase()) ||
                                u.kode.toLowerCase().includes(this.search.toLowerCase())) &&
                            !this.selectedIds.includes(u.id)
                        ).slice(0, 5);
                    },
                    get selectedUsers() {
                        return this.selectedIds.map(id => this.users.find(u => u.id === id)).filter(Boolean);
                    },
                    add(id) {
                        if (!this.selectedIds.includes(id)) {
                            this.selectedIds.push(id);
                        }
                        this.search = '';
                        this.open = false;
                    },
                    remove(id) {
                        this.selectedIds = this.selectedIds.filter(i => i !== id);
                    }
                }" @click.away="open = false">
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                        Tim Manajemen
                    </label>

                    {{-- Selected Chips --}}
                    <div class="mb-2 flex flex-wrap gap-2" x-show="selectedUsers.length > 0" style="display: none;">
                        <template x-for="user in selectedUsers" :key="user.id">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                <span x-text="user.name"></span>
                                <button type="button" @click="remove(user.id)"
                                    class="inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-red-600 hover:bg-red-200 hover:text-red-900 dark:hover:bg-red-800 dark:hover:text-red-200">
                                    <x-icons.close class="h-2 w-2" />
                                </button>
                            </span>
                        </template>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative">
                        <input type="text" x-model="search" @focus="open = true"
                            class="{{ $errors->has('management_ids') ? 'border-red-500 bg-red-50' : 'border-zinc-200 bg-white' }} block w-full rounded-lg border p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            placeholder="Cari nama atau NIP Manajemen...">

                        {{-- Dropdown --}}
                        <div x-show="open && filteredUsers.length > 0" x-transition style="display: none;"
                            class="absolute z-10 mt-1 max-h-48 w-full overflow-y-auto rounded-lg bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800 dark:ring-white dark:ring-opacity-10">
                            <template x-for="user in filteredUsers" :key="user.id">
                                <button type="button" @click="add(user.id)"
                                    class="flex w-full flex-col items-start px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white"
                                        x-text="user.name"></span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400" x-text="user.kode"></span>
                                </button>
                            </template>
                        </div>
                        <div x-show="open && search !== '' && filteredUsers.length === 0" style="display: none;"
                            class="absolute z-10 mt-1 w-full rounded-lg bg-white px-4 py-3 text-sm text-gray-500 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800 dark:text-gray-400 dark:ring-white dark:ring-opacity-10">
                            Tidak ada data ditemukan.
                        </div>
                    </div>

                    @error('management_ids')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="w-full">
                    <x-input.textarea id="alamat" name="alamat" wire:model="alamat"
                        class="{{ $errors->has('alamat') ? 'border-red-500 bg-red-50' : 'border-zinc-200 bg-white' }}"
                        placeholder="Masukkan alamat lengkap penempatan" :labels="true" :textLabel="'Alamat Lengkap'" />

                    @error('alamat')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Opsi Radius --}}
                <div class="w-full">
                    <label class="mb-2 block text-sm font-medium text-zinc-900 dark:text-white">
                        Tipe Radius Absen
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative flex cursor-pointer rounded-lg border p-3 shadow-sm focus:outline-none transition-all duration-200"
                            :class="radiusType === 'limited'
                                ? 'border-blue-500 ring-2 ring-blue-500 ' + (dynamicBg ? 'bg-blue-50/20 dark:bg-blue-900/20' : 'bg-blue-50 dark:bg-zinc-800')
                                : 'border-zinc-200 dark:border-zinc-800 ' + (dynamicBg ? 'bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md' : 'bg-white dark:bg-dark-primary')">
                            <input type="radio" name="radius_type" value="limited" x-model="radiusType" class="sr-only">
                            <div class="flex flex-col">
                                <span class="block text-sm font-semibold text-zinc-900 dark:text-white">Dibatasi</span>
                                <span class="block text-xs text-zinc-500 dark:text-zinc-400">Radius maks 150m</span>
                            </div>
                        </label>
                        <label class="relative flex cursor-pointer rounded-lg border p-3 shadow-sm focus:outline-none transition-all duration-200"
                            :class="radiusType === 'unlimited'
                                ? 'border-blue-500 ring-2 ring-blue-500 ' + (dynamicBg ? 'bg-blue-50/20 dark:bg-blue-900/20' : 'bg-blue-50 dark:bg-zinc-800')
                                : 'border-zinc-200 dark:border-zinc-800 ' + (dynamicBg ? 'bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md' : 'bg-white dark:bg-dark-primary')">
                            <input type="radio" name="radius_type" value="unlimited" x-model="radiusType" class="sr-only">
                            <div class="flex flex-col">
                                <span class="block text-sm font-semibold text-zinc-900 dark:text-white">Bebas</span>
                                <span class="block text-xs text-zinc-500 dark:text-zinc-400">Tanpa batasan jarak</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Radius Slider (Alpine-controlled, entangled with Livewire) --}}
                <div class="w-full" x-show="radiusType === 'limited'" x-transition>
                    <x-input.basic type="number" id="radius-number" name="radius-number" wire:model="radius"
                        class="{{ $errors->has('radius') ? 'border-red-500 bg-red-50' : 'border-zinc-200 bg-white' }}"
                        placeholder="Masukkan radius absen" :labels="true" :textLabel="'Radius Absen'" min="10"
                        max="150" x-model.number="radius">
                        Radius Absen
                        <span class="ml-1 font-semibold text-blue-600 dark:text-blue-400"
                            x-text="radius + ' M'"></span>
                    </x-input.basic>

                    {{-- Slider --}}
                    <div class="relative pb-6">
                        <input id="radius-range" type="range" min="10" max="150"
                            x-model.number="radius"
                            class="h-2 w-full cursor-pointer appearance-none rounded-lg bg-gray-200 accent-blue-600 dark:bg-gray-600" />
                        <div class="mt-2 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span>10M</span>
                            <span>55M</span>
                            <span>105M</span>
                            <span>150M</span>
                        </div>
                    </div>

                    @error('radius')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info Unlimited --}}
                <div class="w-full" x-show="radiusType === 'unlimited'" x-transition style="display: none;">
                    <div class="flex items-start gap-3 rounded-lg border border-blue-200 p-4 dark:border-blue-900"
                        :class="dynamicBg ? 'bg-blue-50/20 dark:bg-blue-950/20 backdrop-blur-md' : 'bg-blue-50 dark:bg-zinc-800/40'">
                        <x-icons.info-circle class="h-5 w-5 shrink-0 text-blue-600 dark:text-blue-400 mt-0.5" />
                        <div>
                            <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200">Radius Tidak Terbatas</h4>
                            <p class="mt-1 text-xs text-blue-700 dark:text-blue-300 leading-relaxed">
                                Pegawai dapat melakukan presensi kehadiran dari mana saja tanpa batasan jarak dari koordinat lokasi ini.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Koordinat (read dari peta, bisa di-edit manual) --}}
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <x-input.basic id="longitude" name="longitude" wire:model="longitude"
                            class="{{ $errors->has('longitude') ? 'border-red-500 bg-red-50' : 'border-zinc-200 bg-white' }}"
                            placeholder="Otomatis dari peta">
                            Longitude
                        </x-input.basic>

                        @error('longitude')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-input.basic id="latitude" name="latitude" wire:model="latitude"
                            class="{{ $errors->has('latitude') ? 'border-red-500 bg-red-50' : 'border-zinc-200 bg-white' }}"
                            placeholder="Otomatis dari peta">
                            Latitude
                        </x-input.basic>

                        @error('latitude')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Petunjuk koordinat --}}
                @if (!$longitude || !$latitude)
                    <p class="flex items-center gap-1 text-xs text-amber-600 dark:text-amber-400">
                        <x-icons.exclamation-circle class="h-4 w-4 shrink-0" />
                        Geser atau klik marker pada peta untuk menentukan koordinat.
                    </p>
                @endif

            </div>

            <div class="mt-6 flex items-center gap-3">
                <x-button.primary wire:click="save" wire:loading.attr="disabled" type="button" id="save-placement"
                    wire:loading.attr="disabled" wire:target="save">
                    <x-slot name="icon">
                        <x-icons.angle-right wire:loading.remove wire:target="save" class="icon h-5 w-5" />
                        <x-icons.loading wire:loading wire:target="save" class="h-4 w-4 animate-spin" />
                    </x-slot>

                    <span wire:loading.remove wire:target="save">Simpan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </x-button.primary>
            </div>

        </div>
    </div>

    {{-- ===================== KOLOM PETA ===================== --}}
    <div class="w-full rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none sm:p-6"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <div class="max-w-xl">
            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                    Tentukan Titik Lokasi
                </h2>
            </header>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                Geser marker atau klik pada peta untuk menentukan koordinat lokasi.
            </p>

            {{-- Map div — data attributes sebagai config untuk JS, tanpa global variables --}}
            <div wire:ignore>
                <div id="placement-map" class="relative z-0 my-4 rounded-lg border border-zinc-200"
                    style="height: 500px;" data-icon="{{ asset('assets/img/marker.png') }}"
                    data-shadow="{{ asset('assets/img/marker-shadow.png') }}" data-lat="{{ $latitude ?: '' }}"
                    data-lng="{{ $longitude ?: '' }}" data-radius="{{ $radius }}">
                </div>
            </div>

            @if ($longitude && $latitude)
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    📍 {{ $latitude }}, {{ $longitude }} — Radius: {{ $radius }}M
                </p>
            @endif
        </div>
    </div>
</div>
