{{-- Goal: Update status rujukan --}}
<div class="w-full space-y-4" x-data>
    {{-- Header --}}
    <div class="rounded-xl border border-zinc-200 p-6 shadow-sm dark:border-zinc-800"
        x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div class="flex items-center gap-4">
                <x-button.danger wire:navigate href="{{ route('rujukan.show', $rujukan->id_rujukan) }}">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Ubah Status Rujukan</h2>
                    <p class="text-sm text-gray-500">{{ $rujukan->no_rujukan }} — {{ $rujukan->pasien->nama }}</p>
                </div>
            </div>
            <x-button.primary wire:click="save" wire:loading.attr="disabled" wire:target="save">
                <x-slot name="icon">
                    <x-icons.loading wire:loading wire:target="save" class="h-4 w-4 animate-spin" />
                </x-slot>
                <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </x-button.primary>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        {{-- Ringkasan Rujukan (Left Column) --}}
        <div class="space-y-4">
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                <div class="mb-4 flex items-center gap-3">
                    <div class="h-8 w-1 rounded-full bg-blue-600"></div>
                    <h3 class="font-bold text-zinc-900 dark:text-white">Informasi Rujukan</h3>
                </div>
                
                <div class="space-y-4 text-sm">
                    <div>
                        <span class="text-xs text-zinc-400 block mb-0.5">Pasien</span>
                        <p class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $rujukan->pasien->nama }}</p>
                        <p class="text-xs text-zinc-400">NIK: {{ $rujukan->pasien->nik }}</p>
                    </div>

                    <div>
                        <span class="text-xs text-zinc-400 block mb-0.5">Rumah Sakit Tujuan</span>
                        <p class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $rujukan->rumahSakit->nama_rumah_sakit }}</p>
                        <p class="text-xs text-zinc-400">{{ $rujukan->rumahSakit->alamat }}</p>
                    </div>

                    <div>
                        <span class="text-xs text-zinc-400 block mb-1">Status Saat Ini</span>
                        @php 
                            $sc = [
                                'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/10 dark:bg-amber-500/10 dark:text-amber-400 dark:ring-amber-400/20',
                                'disetujui' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/10 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-400/20',
                                'ditolak' => 'bg-red-50 text-red-700 ring-red-600/10 dark:bg-red-500/10 dark:text-red-400 dark:ring-red-400/20',
                                'selesai' => 'bg-blue-50 text-blue-700 ring-blue-600/10 dark:bg-blue-500/10 dark:text-blue-400 dark:ring-blue-400/20',
                            ][$rujukan->status->value] ?? 'bg-zinc-50 text-zinc-600 ring-zinc-500/10';
                        @endphp
                        <span class="{{ $sc }} inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset capitalize">
                            {{ $rujukan->status->label() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Edit Status (Right Column) --}}
        <div class="lg:col-span-2">
            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-800 h-full"
                x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
                
                <div class="mb-5 flex items-center gap-3">
                    <div class="h-8 w-1 rounded-full bg-amber-500"></div>
                    <h3 class="font-bold text-zinc-900 dark:text-white">Form Pembaruan Status</h3>
                </div>

                <div class="space-y-5">
                    {{-- Status selector --}}
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">Pilih Status Baru</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($this->statusOptions as $opt)
                                @php
                                    $isSelected = $status === $opt['value'];
                                    $optColors = [
                                        'pending'   => [
                                            'active' => 'border-amber-500 bg-amber-50/50 text-amber-800 dark:border-amber-600 dark:bg-amber-950/20 dark:text-amber-300',
                                            'icon' => 'icons.clock', 'iconColor' => 'text-amber-500'
                                        ],
                                        'disetujui' => [
                                            'active' => 'border-emerald-500 bg-emerald-50/50 text-emerald-800 dark:border-emerald-600 dark:bg-emerald-950/20 dark:text-emerald-300',
                                            'icon' => 'icons.check-circle', 'iconColor' => 'text-emerald-500'
                                        ],
                                        'ditolak'   => [
                                            'active' => 'border-red-500 bg-red-50/50 text-red-800 dark:border-red-600 dark:bg-red-950/20 dark:text-red-300',
                                            'icon' => 'icons.close', 'iconColor' => 'text-red-500'
                                        ],
                                        'selesai'   => [
                                            'active' => 'border-blue-500 bg-blue-50/50 text-blue-800 dark:border-blue-600 dark:bg-blue-950/20 dark:text-blue-300',
                                            'icon' => 'icons.checklist-stepper', 'iconColor' => 'text-blue-500'
                                        ],
                                    ][$opt['value']] ?? ['active' => 'border-zinc-500 bg-zinc-50 text-zinc-800', 'icon' => 'icons.info-circle', 'iconColor' => 'text-zinc-500'];
                                @endphp
                                <label class="relative flex cursor-pointer items-center justify-between rounded-xl border p-4 transition-all duration-200 select-none
                                    {{ $isSelected ? $optColors['active'] . ' ring-2 ring-offset-2 dark:ring-offset-zinc-900 ring-blue-500/20' : 'border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 bg-transparent text-zinc-600 dark:text-zinc-400' }}">
                                    
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-100/80 dark:bg-zinc-800/80 {{ $isSelected ? $optColors['iconColor'] : 'text-zinc-400' }}">
                                            <x-dynamic-component :component="$optColors['icon']" class="h-4.5 w-4.5" />
                                        </div>
                                        <span class="font-bold text-sm">{{ $opt['label'] }}</span>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="radio" wire:model.live="status" value="{{ $opt['value'] }}" class="sr-only">
                                        <div class="flex h-5 w-5 items-center justify-center rounded-full border {{ $isSelected ? 'border-blue-500 bg-blue-500' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800' }}">
                                            @if($isSelected)
                                                <div class="h-2 w-2 rounded-full bg-white"></div>
                                            @endif
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('status') <span class="mt-1.5 block text-xs text-red-500 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">Keterangan Catatan (opsional)</label>
                        <textarea wire:model="keterangan" rows="5"
                            class="w-full rounded-lg border border-zinc-200 bg-white px-3.5 py-2.5 text-sm outline-none transition-all duration-200 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20"
                            placeholder="Tuliskan keterangan pendukung atau alasan perubahan status rujukan di sini..."></textarea>
                        @error('keterangan') <span class="mt-1 block text-xs text-red-500 font-semibold">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

