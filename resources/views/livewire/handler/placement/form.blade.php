{{-- Goal: Shared form view penempatan (create & edit), Livewire: Handler\Placement\Create|Edit, Alpine: radius slider entangle + map bridge --}}
<div class="grid gap-6 lg:grid-cols-2" x-data="{
    radius: $wire.entangle('radius'),
}" x-init="$watch('radius', val => window.dispatchEvent(new CustomEvent('placement-radius-changed', { detail: { radius: val } })))"
    x-on:map-pin-updated.window="$wire.set('longitude', $event.detail.lng); $wire.set('latitude', $event.detail.lat)">
    {{-- ===================== KOLOM FORM ===================== --}}
    <div class="w-full space-y-6">
        <div
            class="rounded-xl bg-white p-4 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 sm:p-6">
            <div class="max-w-xl">

                {{-- Header --}}
                <header class="flex flex-row items-center gap-x-3">
                    <div class="max-w-xs">
                        <x-button.link class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white"
                            href="{{ route('placement.index') }}" wire:navigate>
                            <x-slot name="icon">
                                <x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
                            </x-slot>
                            Kembali
                        </x-button.link>
                    </div>
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
                            class="{{ $errors->has('kode_penempatan') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-white' }}"
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
                            class="{{ $errors->has('penempatan') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-white' }}"
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
                            class="{{ $errors->has('restrict_app') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-white' }}"
                            :defaultOption="'-- Pilih --'" :options="['y' => 'Ya - Dibatasi', 't' => 'Tidak - Bebas']" :labels="true" :textLabel="'Pembatasan Akses Aplikasi'" />

                        @error('restrict_app')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="w-full">
                        <x-input.textarea id="alamat" name="alamat" wire:model="alamat"
                            class="{{ $errors->has('alamat') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-white' }}"
                            placeholder="Masukkan alamat lengkap penempatan" :labels="true" :textLabel="'Alamat Lengkap'" />

                        @error('alamat')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Radius Slider (Alpine-controlled, entangled with Livewire) --}}
                    <div class="w-full">
                        <x-input.basic type="number" id="radius-number" name="radius-number" wire:model="radius"
                            class="{{ $errors->has('radius') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-white' }}"
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
                                class="{{ $errors->has('longitude') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-white' }}"
                                placeholder="Otomatis dari peta">
                                Longitude
                            </x-input.basic>

                            @error('longitude')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <x-input.basic id="latitude" name="latitude" wire:model="latitude"
                                class="{{ $errors->has('latitude') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-white' }}"
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

                {{-- Tombol Submit --}}
                <div class="mt-6 flex items-center gap-3">
                    <button wire:click="save" wire:loading.attr="disabled"
                        wire:loading.class="opacity-60 cursor-not-allowed" type="button"
                        class="inline-flex items-center gap-2 rounded-lg px-5 py-2.5 text-sm font-medium text-gray-900 ring-1 ring-blue-700 transition hover:bg-blue-800 hover:text-white focus:ring-4 focus:ring-blue-300 dark:bg-blue-800 dark:text-white dark:ring-gray-700 dark:hover:bg-blue-900">
                        <span wire:loading.remove wire:target="save">Simpan</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- ===================== KOLOM PETA ===================== --}}
    <div class="w-full">
        <div
            class="rounded-xl bg-white p-4 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 sm:p-6">
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
                    <div id="placement-map" class="relative z-0 my-4 rounded-lg ring-1 ring-gray-200"
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
</div>
