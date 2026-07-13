{{-- Goal: Edit form for employee data, Livewire: Handler\Pegawai\Edit, Alpine: - --}}
<div class="w-full space-y-6">
    <!-- Top Header Navigation -->
    <div
        class="rounded-xl border border-zinc-200 bg-white/60 p-6 shadow-2xl backdrop-blur-sm transition-all duration-500 ease-in-out dark:border-zinc-800 dark:bg-dark-primary/60">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div class="flex items-center gap-4">
                <x-button.link id="back-btn" class="group justify-center bg-white/50 hover:bg-red-700 hover:text-white"
                    wire:navigate href="{{ route('pegawai.detail', $pegawai->id) }}">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.link>
                <div>
                    <h2 class="flex items-center gap-2 text-2xl font-bold tracking-tight text-gray-800 dark:text-white">
                        Edit Data Pegawai
                        <x-dashboard.badge-inactive :is_active="$pegawai->userRelasi?->is_active ?? true" />
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pembaruan informasi data pegawai
                        <span class="font-bold text-blue-600 dark:text-blue-400">{{ $full_name }}</span>
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <x-button.primary wire:click="save" wire:loading.attr="disabled" wire:target="save">
                    <x-slot name="icon">
                        <x-icons.angle-right wire:loading.remove wire:target="save" class="icon h-5 w-5" />
                        <x-icons.loading wire:loading wire:target="save" class="h-4 w-4 animate-spin" />
                    </x-slot>

                    <span wire:loading.remove wire:target="save">Update Pegawai</span>
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
                class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-white/60 p-8 shadow-xl backdrop-blur-sm dark:border-zinc-800 dark:bg-dark-primary/60">
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-blue-500/5 blur-3xl transition-colors group-hover:bg-blue-500/10">
                </div>

                <div class="mb-8 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-blue-600"></div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Informasi Personal</h3>
                </div>

                <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:gap-4">
                    <div class="space-y-2">
                        <div class="relative w-full">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Kode Pegawai Saat Ini
                            </label>
                            <input type="text" value="{{ $kode_pegawai }}" disabled
                                class="block w-full cursor-not-allowed rounded-xl border-zinc-200 bg-gray-100 p-2.5 text-sm dark:border-zinc-800 dark:bg-zinc-800 dark:text-gray-400">
                        </div>
                    </div>

                    <!-- Centang Ubah Kode Pegawai -->
                    <div class="md:col-span-2 space-y-4 rounded-2xl border border-zinc-200 p-5 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/20">
                        <label class="flex cursor-pointer items-center gap-3">
                            <input wire:model.live="ubah_kode_pegawai" type="checkbox" id="ubah_kode_pegawai"
                                class="h-5 w-5 rounded-lg border-zinc-200 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm font-semibold text-gray-800 dark:text-white">Ubah Kode Pegawai (Sistemik)</span>
                        </label>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            Mengubah kode pegawai akan memperbarui seluruh referensi kode jari pada tabel absensi, transaksi, dan data log terkait secara aman.
                        </p>

                        @if ($ubah_kode_pegawai)
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 pt-2" x-transition>
                                <div class="space-y-2">
                                    <x-input.basic wire:model="kode_pegawai_baru" id="kode_pegawai_baru" name="kode_pegawai_baru" type="text"
                                        placeholder="Masukkan kode pegawai baru">
                                        Kode Pegawai Baru
                                    </x-input.basic>
                                    @error('kode_pegawai_baru')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <x-input.basic wire:model="alasan_ubah_kode" id="alasan_ubah_kode" name="alasan_ubah_kode" type="text"
                                        placeholder="Alasan perubahan kode pegawai">
                                        Alasan Kode Pegawai Diubah
                                    </x-input.basic>
                                    @error('alasan_ubah_kode')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endif
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
                class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-white/60 p-8 shadow-xl backdrop-blur-sm dark:border-zinc-800 dark:bg-dark-primary/60">
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
            @if ($has_account)
                <div
                    class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-white/60 p-8 shadow-xl backdrop-blur-sm dark:border-zinc-800 dark:bg-dark-primary/60">
                    <div
                        class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-green-500/5 blur-3xl transition-colors group-hover:bg-green-500/10">
                    </div>

                    <div class="mb-6 flex items-center gap-3">
                        <div class="h-10 w-1 rounded-full bg-green-600"></div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Pengaturan Akun</h3>
                    </div>

                    <div class="space-y-6">
                        {{-- Info Banner --}}
                        <div
                            class="rounded-2xl border border-green-100 bg-green-50 p-5 dark:border-green-800/30 dark:bg-green-900/20">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="rounded-xl bg-green-600 p-2 text-white">
                                        <x-icons.info class="h-5 w-5" />
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-green-900 dark:text-green-200">Akun Terhubung
                                    </p>
                                    <p class="mt-1 text-xs text-green-700 dark:text-green-300">Pegawai ini memiliki
                                        akun login aktif. Anda dapat mengelola hak akses (Role) di bawah ini.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Role Selector --}}
                        <div class="space-y-4" x-data="{ search: '' }">
                            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Update Role
                                    /
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
                                        <input wire:model="selected_roles" type="checkbox"
                                            value="{{ $role->name }}"
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

                        {{-- Join Date --}}
                        <div class="mt-4 space-y-2">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                for="join_date">Tanggal Bergabung (Join Date)</label>
                            <input wire:model="join_date" type="date" id="join_date"
                                class="block w-full rounded-xl border-zinc-200 bg-white/50 p-2.5 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-dark-secondary dark:text-white">
                            @error('join_date')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status Akun --}}
                        <div class="grid gap-2 lg:gap-4 mt-6 border-t border-zinc-200/50 dark:border-zinc-800/50 pt-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Status Akun</label>
                                <select wire:model.live="is_active"
                                    class="block w-full rounded-xl border border-zinc-200 bg-white/50 p-2.5 text-sm transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-zinc-800 dark:bg-gray-800 dark:text-white dark:focus:border-blue-500">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>

                            <div x-show="$wire.is_active == 0" x-cloak class="space-y-2">
                                <x-input.textarea wire:model="deactivation_reason" id="deactivation_reason"
                                    name="deactivation_reason" placeholder="Contoh: Resign atau Penonaktifan Sementara"
                                    :labels="true" :textLabel="'Alasan Dinonaktifkan'" />
                                @error('deactivation_reason')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column: Photo Labels & Existing Photos -->
        <div class="space-y-2 lg:space-y-4">
            <!-- Upload New Photos -->
            <div
                class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-white/60 p-8 shadow-xl backdrop-blur-sm dark:border-zinc-800 dark:bg-dark-primary/60">
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-orange-500/5 blur-3xl transition-colors group-hover:bg-orange-500/10">
                </div>

                <div class="mb-8 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-orange-600"></div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Upload Foto Baru</h3>
                </div>

                <div class="space-y-2 lg:space-y-4">
                    <!-- Photo 1 -->
                    <div class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Ganti Foto
                            1</label>
                        <div
                            class="group relative flex h-48 w-full flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-zinc-200 transition-colors hover:border-blue-500 dark:border-zinc-800">
                            @if ($photo1)
                                <img src="{{ $photo1->temporaryUrl() }}"
                                    class="absolute inset-0 h-full w-full object-cover">
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100">
                                    <x-button.danger class="!px-4 !py-2 !text-xs" wire:click="$set('photo1', null)">
                                        Ganti Foto
                                    </x-button.danger>
                                </div>
                            @else
                                <div class="flex flex-col items-center gap-3">
                                    <div class="rounded-2xl bg-gray-100 p-4 dark:bg-dark-secondary">
                                        <x-icons.camera class="h-8 w-8 text-gray-400" />
                                    </div>
                                    <span
                                        class="px-4 text-center text-xs font-medium text-gray-500 dark:text-gray-400">Pilih
                                        Foto 1 baru</span>
                                </div>
                                <input wire:model="photo1" type="file"
                                    class="absolute inset-0 cursor-pointer opacity-0">
                            @endif

                            <div wire:loading wire:target="photo1"
                                class="absolute inset-0 flex items-center justify-center bg-white/60 dark:bg-dark-primary/80">
                                <div class="h-8 w-8 animate-spin rounded-full border-b-2 border-blue-600"></div>
                            </div>
                        </div>
                        @error('photo1')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Photo 2 -->
                    <div class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Ganti Foto
                            2</label>
                        <div
                            class="group relative flex h-48 w-full flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-zinc-200 transition-colors hover:border-blue-500 dark:border-zinc-800">
                            @if ($photo2)
                                <img src="{{ $photo2->temporaryUrl() }}"
                                    class="absolute inset-0 h-full w-full object-cover">
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100">
                                    <x-button.danger class="!px-4 !py-2 !text-xs" wire:click="$set('photo2', null)">
                                        Ganti Foto
                                    </x-button.danger>
                                </div>
                            @else
                                <div class="flex flex-col items-center gap-3">
                                    <div class="rounded-2xl bg-gray-100 p-4 dark:bg-dark-secondary">
                                        <x-icons.camera class="h-8 w-8 text-gray-400" />
                                    </div>
                                    <span
                                        class="px-4 text-center text-xs font-medium text-gray-500 dark:text-gray-400">Pilih
                                        Foto 2 baru</span>
                                </div>
                                <input wire:model="photo2" type="file"
                                    class="absolute inset-0 cursor-pointer opacity-0">
                            @endif

                            <div wire:loading wire:target="photo2"
                                class="absolute inset-0 flex items-center justify-center bg-white/60 dark:bg-dark-primary/80">
                                <div class="h-8 w-8 animate-spin rounded-full border-b-2 border-blue-600"></div>
                            </div>
                        </div>
                        @error('photo2')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Existing Photos Display -->
            <div
                class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-white/60 p-8 shadow-xl backdrop-blur-sm dark:border-zinc-800 dark:bg-dark-primary/60">
                <div class="mb-6 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-zinc-600"></div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Foto Saat Ini</h3>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    @forelse($existing_images as $img)
                        <div
                            class="group relative h-32 overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-800">
                            <img src="{{ asset('storage/' . $pegawai->storage . $img) }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2 text-center text-[10px] font-medium text-white">
                                {{ $img }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 flex flex-col items-center py-6 text-gray-400">
                            <x-icons.info class="mb-2 h-10 w-10" />
                            <span class="text-xs">Belum ada foto terdaftar</span>
                        </div>
                    @endforelse
                </div>

                <p class="mt-4 text-center text-[10px] italic text-gray-500">
                    * Upload foto baru untuk mengganti foto yang sudah ada.
                </p>
            </div>
        </div>
    </div>
</div>
