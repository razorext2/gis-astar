{{-- Goal: Render Jabatan edit form, Livewire: App\Livewire\Handler\Jabatan\Edit, Alpine: Dropdown search logic for supervisor --}}
<div class="w-full space-y-6">
    <div
        class="rounded-xl bg-white/60 p-4 shadow-md ring-1 ring-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:ring-zinc-800 sm:p-6">
        <div class="max-w-xl">
            <header class="mb-6 flex flex-row items-center gap-4 border-b border-zinc-100 pb-4 dark:border-white/5">
                <x-button.danger href="{{ route('jabatan.index') }}" class="mb-0">
                    <x-slot name="icon">
                        <x-icons.angle-left class="h-6 w-6" />
                    </x-slot>
                    {{ __('Kembali') }}
                </x-button.danger>
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ __('Edit Data Jabatan') }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ __('Ubah detail jabatan untuk memperbarui struktur organisasi.') }}
                    </p>
                </div>
            </header>

            <form wire:submit="save" class="space-y-6">
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <x-input.basic wire:model="nama_jabatan" id="nama_jabatan" name="nama_jabatan"
                            placeholder="Contoh: Senior Supervisor">
                            Nama Jabatan
                        </x-input.basic>
                        @error('nama_jabatan')
                            <span class="mt-1 text-xs italic text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="w-full">
                        <x-input.select wire:model="divisi" id="divisi" name="divisi" defaultOption="Pilih Divisi">
                            <x-slot name="label">Divisi</x-slot>
                            @foreach ($divisions as $data)
                                <option value="{{ $data->id }}">
                                    {{ $data->nama_divisi }}
                                </option>
                            @endforeach
                        </x-input.select>
                        @error('divisi')
                            <span class="mt-1 text-xs italic text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="w-full">
                        <x-input.select wire:model="penempatan" id="penempatan" name="penempatan"
                            defaultOption="Pilih Lokasi">
                            <x-slot name="label">Penempatan</x-slot>
                            @foreach ($placements as $data)
                                <option value="{{ $data->id }}">
                                    {{ $data->penempatan }}
                                </option>
                            @endforeach
                        </x-input.select>
                        @error('penempatan')
                            <span class="mt-1 text-xs italic text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="mb-2 block text-sm font-bold text-gray-900 dark:text-white">
                            {{ __('Penanggung Jawab (Supervisor)') }}
                        </label>
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            {{-- Search Input --}}
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.300ms="search_supervisor"
                                    @focus="open = true" @input="$wire.set('supervisor_id', null)"
                                    placeholder="Cari Nama atau Kode Pegawai..."
                                    class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-zinc-800 dark:bg-gray-700/50 dark:text-white dark:placeholder-gray-400">
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <x-icons.search class="h-4 w-4 text-gray-400" />
                                </div>
                            </div>

                            {{-- Dropdown Results --}}
                            <div x-show="open && $wire.search_supervisor.length > 0"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="absolute z-50 mt-1 max-h-60 w-full overflow-y-auto rounded-xl border border-zinc-200 bg-white shadow-xl backdrop-blur-xl dark:border-zinc-800 dark:bg-zinc-900">
                                @forelse ($users as $user)
                                    <button type="button"
                                        @click="$wire.set('supervisor_id', {{ $user->id }}); $wire.set('search_supervisor', '{{ addslashes($user->name) }}'); open = false"
                                        class="{{ $supervisor_id == $user->id ? 'bg-red-50 dark:bg-red-900/20' : '' }} flex w-full flex-col px-4 py-2.5 text-left transition-colors hover:bg-zinc-50 dark:hover:bg-white/5">
                                        <span
                                            class="text-sm font-bold text-zinc-900 dark:text-white">{{ $user->name }}</span>
                                        <span
                                            class="text-[10px] uppercase tracking-wider text-zinc-500">{{ $user->kode_pegawai }}</span>
                                    </button>
                                @empty
                                    <div class="px-4 py-4 text-center text-sm text-zinc-500">
                                        {{ __('Tidak ada data ditemukan.') }}
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <p class="mt-1 text-[10px] italic text-zinc-500">
                            {{ __('Atasan yang akan muncul sebagai pemberi persetujuan pertama untuk jabatan ini.') }}
                        </p>
                        @error('supervisor_id')
                            <span class="mt-1 text-xs italic text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center border-t border-zinc-100 pt-4 dark:border-white/5">
                    <x-button.success type="submit" wire:loading.attr="disabled">
                        <span wire:target="save" wire:loading.remove>{{ __('Simpan Perubahan') }}</span>
                        <span wire:target="save" wire:loading>{{ __('Menyimpan...') }}</span>
                        <x-slot name="icon">
                            <x-icons.checklist-stepper class="h-5 w-5" />
                        </x-slot>
                    </x-button.success>
                </div>
            </form>
        </div>
    </div>
</div>
