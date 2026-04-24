<div class="w-full space-y-6">
    <!-- Top Header Navigation -->
    <div
        class="rounded-3xl border border-white/30 bg-white/70 p-6 shadow-2xl backdrop-blur-xl transition-all duration-500 ease-in-out dark:border-white/10 dark:bg-zinc-900/60">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div class="flex items-center gap-4">
                <x-button.link id="back-btn" class="group justify-center bg-white/50 hover:bg-red-700 hover:text-white"
                    wire:navigate href="{{ route('pegawai.index') }}">
                    <x-icons.angle-left class="h-6 w-6" />
                </x-button.link>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white">Tambah Data Pegawai
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Silahkan lengkapi informasi data pegawai di
                        bawah ini.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <x-button.primary wire:click="save" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Simpan Pegawai</span>
                    <span wire:loading wire:target="save">Memproses...</span>
                </x-button.primary>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-2 lg:grid-cols-3 lg:gap-4">
        <!-- Left Column: Form Details -->
        <div class="space-y-2 lg:col-span-2 lg:space-y-4">
            <!-- Data Personal Section -->
            <div
                class="group relative overflow-hidden rounded-3xl border border-white/30 bg-white/70 p-8 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60">
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-blue-500/5 blur-3xl transition-colors group-hover:bg-blue-500/10">
                </div>

                <div class="mb-8 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-blue-600"></div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Informasi Personal</h3>
                </div>

                <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:gap-4">
                    <div class="space-y-2">
                        <x-input.basic wire:model="kode_pegawai" id="kode_pegawai" name="kode_pegawai" type="number"
                            placeholder="Kode pegawai ex: 12345">
                            Kode Pegawai
                        </x-input.basic>
                        @error('kode_pegawai')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <x-input.basic wire:model="nik_pegawai" id="nik_pegawai" name="nik_pegawai" type="text"
                            placeholder="Masukkan NIK 16 digit">
                            NIK (Nomor Induk Kependudukan)
                        </x-input.basic>
                        @error('nik_pegawai')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <x-input.basic wire:model="full_name" id="full_name" name="full_name" type="text"
                            placeholder="Nama lengkap sesuai KTP">
                            Nama Lengkap
                        </x-input.basic>
                        @error('full_name')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <x-input.basic wire:model="nick_name" id="nick_name" name="nick_name" type="text"
                            placeholder="Nama panggilan">
                            Nama Panggilan
                        </x-input.basic>
                        @error('nick_name')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <x-input.basic wire:model="no_telp" id="no_telp" name="no_telp" type="tel"
                            placeholder="08xxxxxxxxxx">
                            Nomor Telepon
                        </x-input.basic>
                        @error('no_telp')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="tgl_lahir">Tanggal Lahir</label>
                        <input wire:model="tgl_lahir" type="date"
                            class="block w-full rounded-xl border-zinc-200 bg-white/50 p-2.5 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-dark-secondary dark:text-white">
                        @error('tgl_lahir')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <x-input.textarea wire:model="alamat" id="alamat" name="alamat"
                            placeholder="Masukkan alamat lengkap domisili saat ini..." rows="3">
                            Alamat Lengkap
                        </x-input.textarea>
                        @error('alamat')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Penempatan & Jabatan Section -->
            <div
                class="group relative overflow-hidden rounded-3xl border border-white/30 bg-white/70 p-8 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60">
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-purple-500/5 blur-3xl transition-colors group-hover:bg-purple-500/10">
                </div>

                <div class="mb-8 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-purple-600"></div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Pekerjaan & Posisi</h3>
                </div>

                <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:gap-4">
                    <div class="space-y-2">
                        <x-input.select wire:model="jabatan" id="jabatan" name="jabatan">
                            <x-slot name="label">Jabatan / Posisi</x-slot>
                            <option value="">Pilih Jabatan</option>
                            @foreach ($list_jabatan as $jb)
                                <option value="{{ $jb->id }}">{{ $jb->nama_jabatan }}</option>
                            @endforeach
                        </x-input.select>
                        @error('jabatan')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <x-input.select wire:model="golongan" id="golongan" name="golongan">
                            <x-slot name="label">Golongan</x-slot>
                            <option value="">Pilih Golongan</option>
                            @foreach ($list_golongan as $gol)
                                <option value="{{ $gol->id }}">{{ $gol->nama_golongan }}</option>
                            @endforeach
                        </x-input.select>
                        @error('golongan')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Akun Login Section -->
            <div
                class="group relative overflow-hidden rounded-3xl border border-white/30 bg-white/70 p-8 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60">
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-green-500/5 blur-3xl transition-colors group-hover:bg-green-500/10">
                </div>

                {{-- Section Header & Toggle --}}
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-1 rounded-full bg-green-600"></div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Pengaturan Akun</h3>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Buat Akun?</span>
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input wire:model.live="make_user" type="checkbox" class="peer sr-only">
                            <div
                                class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-zinc-200 after:bg-white after:transition-all after:content-[''] peer-checked:bg-green-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:border-zinc-800 dark:bg-gray-700 dark:peer-focus:ring-green-800">
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Collapsible Content --}}
                <div x-show="$wire.make_user" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2" class="space-y-6">

                    {{-- Info Banner --}}
                    <div
                        class="rounded-2xl border border-blue-100 bg-blue-50 p-5 dark:border-blue-800/30 dark:bg-blue-900/20">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="rounded-xl bg-blue-600 p-2 text-white">
                                    <x-icons.info class="h-5 w-5" />
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-blue-900 dark:text-blue-200">Informasi Akun
                                    Otomatis</p>
                                <p class="mt-1 text-xs text-blue-700 dark:text-blue-300">Akun akan dibuat
                                    menggunakan Nama Panggilan + Kode Pegawai sebagai email, dan Kode Pegawai
                                    sebagai password default.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Role Selector --}}
                    <div class="space-y-4" x-data="{ search: '' }">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Pilih Role /
                                Hak Akses</label>
                            <div class="relative w-full md:max-w-xs">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-icons.search class="h-4 w-4 text-gray-400" />
                                </div>
                                <input x-model="search" type="text"
                                    class="block w-full rounded-xl border-zinc-200 bg-white/50 pl-10 text-xs focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-dark-secondary dark:text-white"
                                    placeholder="Cari role...">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 md:grid-cols-3">
                            @foreach ($list_roles as $role)
                                <label
                                    x-show="search === '' || '{{ strtolower($role->name) }}'.includes(search.toLowerCase())"
                                    class="role-item group/role flex cursor-pointer items-center gap-3 rounded-2xl border border-zinc-200 p-4 transition-all hover:border-blue-300 hover:bg-blue-50 dark:border-zinc-800 dark:hover:border-blue-700 dark:hover:bg-blue-900/20">
                                    <input wire:model="selected_roles" type="checkbox" value="{{ $role->name }}"
                                        class="h-5 w-5 rounded-lg border-zinc-200 text-blue-600 focus:ring-blue-500">
                                    <span
                                        class="text-sm font-medium text-gray-700 transition-colors group-hover/role:text-blue-600 dark:text-gray-200">{{ $role->name }}</span>
                                </label>
                            @endforeach

                            {{-- Empty State --}}
                            <div x-cloak
                                x-show="search !== '' && ![...$el.parentElement.querySelectorAll('.role-item')].some(el => el.style.display !== 'none')"
                                class="col-span-2 flex flex-col items-center justify-center py-8 text-gray-400 md:col-span-3">
                                <x-icons.info class="mb-2 h-8 w-8 opacity-50" />
                                <span class="text-xs">Role "<span x-text="search"></span>" tidak ditemukan</span>
                            </div>
                        </div>
                        @error('selected_roles')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Photo Labels -->
        <div class="space-y-2 lg:space-y-4">
            <div
                class="group relative overflow-hidden rounded-3xl border border-white/30 bg-white/70 p-8 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60">
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-orange-500/5 blur-3xl transition-colors group-hover:bg-orange-500/10">
                </div>

                <div class="mb-8 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-orange-600"></div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Foto Label Pegawai</h3>
                </div>

                <div class="space-y-2 lg:space-y-4">
                    <!-- Photo 1 -->
                    <div class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Foto Label
                            1</label>
                        <div
                            class="group relative flex h-56 w-full flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-zinc-200 transition-colors hover:border-blue-500 dark:border-zinc-800">
                            @if ($photo1)
                                <img src="{{ $photo1->temporaryUrl() }}"
                                    class="absolute inset-0 h-full w-full object-cover">
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100">
                                    <button wire:click="$set('photo1', null)"
                                        class="rounded-xl bg-red-600 px-4 py-2 text-xs font-bold text-white">Ganti
                                        Foto</button>
                                </div>
                            @else
                                <div class="flex flex-col items-center gap-3">
                                    <div class="rounded-2xl bg-gray-100 p-4 dark:bg-dark-secondary">
                                        <x-icons.camera class="h-8 w-8 text-gray-400" />
                                    </div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Pilih atau
                                        Seret Foto</span>
                                </div>
                                <input wire:model="photo1" type="file"
                                    class="absolute inset-0 cursor-pointer opacity-0">
                            @endif

                            <div wire:loading wire:target="photo1"
                                class="absolute inset-0 flex items-center justify-center bg-white/80 dark:bg-dark-primary/80">
                                <div class="h-8 w-8 animate-spin rounded-full border-b-2 border-blue-600"></div>
                            </div>
                        </div>
                        @error('photo1')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Photo 2 -->
                    <div class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Foto Label
                            2</label>
                        <div
                            class="group relative flex h-56 w-full flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-zinc-200 transition-colors hover:border-blue-500 dark:border-zinc-800">
                            @if ($photo2)
                                <img src="{{ $photo2->temporaryUrl() }}"
                                    class="absolute inset-0 h-full w-full object-cover">
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100">
                                    <button wire:click="$set('photo2', null)"
                                        class="rounded-xl bg-red-600 px-4 py-2 text-xs font-bold text-white">Ganti
                                        Foto</button>
                                </div>
                            @else
                                <div class="flex flex-col items-center gap-3">
                                    <div class="rounded-2xl bg-gray-100 p-4 dark:bg-dark-secondary">
                                        <x-icons.camera class="h-8 w-8 text-gray-400" />
                                    </div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Pilih atau
                                        Seret Foto</span>
                                </div>
                                <input wire:model="photo2" type="file"
                                    class="absolute inset-0 cursor-pointer opacity-0">
                            @endif

                            <div wire:loading wire:target="photo2"
                                class="absolute inset-0 flex items-center justify-center bg-white/80 dark:bg-dark-primary/80">
                                <div class="h-8 w-8 animate-spin rounded-full border-b-2 border-blue-600"></div>
                            </div>
                        </div>
                        @error('photo2')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div
                    class="mt-8 rounded-2xl border border-orange-100 bg-orange-50 p-4 dark:border-orange-800/30 dark:bg-orange-900/10">
                    <p class="text-center text-xs font-medium leading-relaxed text-orange-700 dark:text-orange-400">
                        Unggah foto wajah dengan pencahayaan yang terang untuk keperluan sistem absensi wajah.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
