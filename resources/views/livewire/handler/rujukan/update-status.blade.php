{{-- Goal: Update status rujukan --}}
<div class="w-full space-y-4" x-data>
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
                <x-slot name="icon"><x-icons.loading wire:loading wire:target="save" class="h-4 w-4 animate-spin" /></x-slot>
                <span wire:loading.remove wire:target="save">Simpan Status</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </x-button.primary>
        </div>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="rounded-xl border border-zinc-200 p-8 dark:border-zinc-800"
            x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
            <div class="mb-6 flex items-center gap-3">
                <div class="h-10 w-1 rounded-full bg-amber-500"></div>
                <h3 class="text-xl font-bold">Status Rujukan</h3>
            </div>

            <div class="space-y-4">
                {{-- Status options --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">Pilih Status Baru</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($this->statusOptions as $opt)
                            @php
                                $colors = [
                                    'pending'   => 'border-amber-300 bg-amber-50 text-amber-700 dark:border-amber-700 dark:bg-amber-900/20 dark:text-amber-300',
                                    'disetujui' => 'border-emerald-300 bg-emerald-50 text-emerald-700 dark:border-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300',
                                    'ditolak'   => 'border-red-300 bg-red-50 text-red-700 dark:border-red-700 dark:bg-red-900/20 dark:text-red-300',
                                    'selesai'   => 'border-blue-300 bg-blue-50 text-blue-700 dark:border-blue-700 dark:bg-blue-900/20 dark:text-blue-300',
                                ][$opt['value']] ?? 'border-zinc-200 text-zinc-600'
                            @endphp
                            <label class="flex cursor-pointer items-center gap-3 rounded-xl border-2 p-4 transition-all
                                {{ $status === $opt['value'] ? $colors : 'border-zinc-200 dark:border-zinc-700 hover:border-zinc-300' }}">
                                <input type="radio" wire:model.live="status" value="{{ $opt['value'] }}"
                                    class="h-4 w-4 border-zinc-300 text-blue-600">
                                <span class="font-semibold text-sm">{{ $opt['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('status') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Keterangan (opsional)</label>
                    <textarea wire:model="keterangan" rows="4"
                        class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm dark:border-zinc-600 dark:bg-zinc-800 dark:text-white focus:ring-1 focus:ring-blue-500"
                        placeholder="Catatan atau alasan perubahan status..."></textarea>
                    @error('keterangan') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>
</div>
