{{-- Goal: Shared form view penempatan (create & edit), Livewire: Handler\Placement\Create|Edit, Alpine: radius slider entangle + map bridge --}}
<div class="grid gap-6 lg:grid-cols-2" x-data="{
    radius: $wire.entangle('radius'),
}" x-init="$watch('radius', val => window.dispatchEvent(new CustomEvent('placement-radius-changed', { detail: { radius: val } })))"
    x-on:map-pin-updated.window="$wire.set('longitude', $event.detail.lng); $wire.set('latitude', $event.detail.lat)">
    {{-- ===================== KOLOM FORM ===================== --}}
    <div
        class="w-full rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none sm:p-6">
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
                            <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                <span x-text="user.name"></span>
                                <button type="button" @click="remove(user.id)" class="inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-red-600 hover:bg-red-200 hover:text-red-900 dark:hover:bg-red-800 dark:hover:text-red-200">
                                    <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8"><path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"/></svg>
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
                                    <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="user.name"></span>
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
                            <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                <span x-text="user.name"></span>
                                <button type="button" @click="remove(user.id)" class="inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-red-600 hover:bg-red-200 hover:text-red-900 dark:hover:bg-red-800 dark:hover:text-red-200">
                                    <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8"><path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"/></svg>
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
                                    <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="user.name"></span>
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

                {{-- Radius Slider (Alpine-controlled, entangled with Livewire) --}}
                <div class="w-full">
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
    <div
        class="w-full rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none sm:p-6">
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
