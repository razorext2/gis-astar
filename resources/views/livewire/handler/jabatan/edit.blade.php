{{-- Goal: Render Jabatan edit form, Livewire: App\Livewire\Handler\Jabatan\Edit, Alpine: Dropdown search logic for supervisor --}}
<div class="grid w-full grid-cols-1 gap-6 lg:grid-cols-3">

    {{-- Left Column: Form Edit --}}
    <div class="lg:col-span-2">
        <div class="rounded-xl p-4 shadow-md ring-1 ring-zinc-200 dark:shadow-none dark:ring-zinc-800 sm:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
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

                    <div class="sm:col-span-2" x-data="{
                        open: false,
                        search: '',
                        selectedIds: $wire.entangle('supervisor_ids'),
                        users: {{ Js::from($allUsers->map(fn($u) => ['id' => $u->id, 'name' => $u->name, 'kode' => $u->pegawai ? $u->pegawai->kode_pegawai : ''])) }},
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
                        <label class="mb-2 block text-sm font-bold text-gray-900 dark:text-white">
                            {{ __('Penanggung Jawab (Supervisor)') }}
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
                                class="{{ $errors->has('supervisor_ids') ? 'border-red-500 bg-red-50' : 'border-zinc-200 bg-white' }} block w-full rounded-lg border p-2.5 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-zinc-800 dark:bg-gray-700/50 dark:text-white"
                                placeholder="Cari nama atau NIP Supervisor...">

                            {{-- Dropdown --}}
                            <div x-show="open && filteredUsers.length > 0" x-transition style="display: none;"
                                class="absolute z-50 mt-1 max-h-48 w-full overflow-y-auto rounded-lg bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-zinc-800">
                                <template x-for="user in filteredUsers" :key="user.id">
                                    <button type="button" @click="add(user.id)"
                                        class="flex w-full flex-col items-start px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white"
                                            x-text="user.name"></span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400"
                                            x-text="user.kode"></span>
                                    </button>
                                </template>
                            </div>
                            <div x-show="open && search !== '' && filteredUsers.length === 0" style="display: none;"
                                class="absolute z-50 mt-1 w-full rounded-lg bg-white px-4 py-3 text-sm text-gray-500 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-zinc-800 dark:text-gray-400">
                                Tidak ada data ditemukan.
                            </div>
                        </div>

                        @error('supervisor_ids')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
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

    {{-- Right Column: Employees list --}}
    <div class="lg:col-span-1">
        <div class="rounded-xl p-4 shadow-md ring-1 ring-zinc-200 dark:shadow-none dark:ring-zinc-800 sm:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <header class="mb-6 border-b border-zinc-100 pb-4 dark:border-white/5">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                    Daftar Pegawai
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Pegawai yang saat ini menempati jabatan ini.
                </p>
            </header>

            <div class="flow-root">
                <ul class="-my-5 divide-y divide-zinc-100 dark:divide-white/5">
                    @forelse ($employees as $emp)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">
                                        <x-icons.user class="h-5 w-5" />
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $emp->full_name }}
                                    </p>
                                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                                        NIP: {{ $emp->kode_pegawai }}
                                    </p>
                                </div>
                                <div>
                                    <span
                                        class="inline-flex items-center rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-800 dark:bg-zinc-800 dark:text-zinc-200">
                                        Aktif
                                    </span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 text-center">
                            <p class="text-sm italic text-gray-500 dark:text-gray-400">
                                Belum ada pegawai yang memiliki jabatan ini.
                            </p>
                        </li>
                    @endforelse
                </ul>
            </div>

            @if ($employees->hasPages())
                <div class="mt-4 border-t border-zinc-100 pt-4 dark:border-white/5">
                    {{ $employees->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
