<div class="w-full space-y-6">
    <!-- Top Header Navigation -->
    <div
        class="rounded-3xl border border-white/30 bg-white/70 p-6 shadow-2xl backdrop-blur-xl transition-all duration-500 ease-in-out dark:border-white/10 dark:bg-zinc-900/60">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div class="flex items-center gap-4">
                <x-button.link id="back-btn" class="group justify-center bg-white/50 hover:bg-red-700 hover:text-white"
                    wire:navigate href="{{ route('users.index') }}">
                    <x-icons.angle-left class="h-6 w-6" />
                </x-button.link>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white">Tambah Data User</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Daftarkan akun pengguna baru dengan hak akses
                        yang
                        sesuai.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <x-button.primary wire:click="save" wire:loading.attr="disabled">
                    <x-slot name="icon">
                        <x-icons.plus wire:loading.remove wire:target="save" class="h-5 w-5" />
                    </x-slot>
                    <span wire:loading.remove wire:target="save">Daftarkan User</span>
                    <span wire:loading wire:target="save">Memproses...</span>
                </x-button.primary>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-2 lg:grid-cols-3 lg:gap-4">
        <!-- Left Column: Form Details -->
        <div class="space-y-2 lg:col-span-2 lg:space-y-4">
            <!-- Informasi Akun Section -->
            <div
                class="group relative overflow-hidden rounded-3xl border border-white/30 bg-white/70 p-8 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60">
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-blue-500/5 blur-3xl transition-colors group-hover:bg-blue-500/10">
                </div>

                <div class="mb-8 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-blue-600"></div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Informasi Dasar</h3>
                </div>

                <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:gap-4">
                    <div class="space-y-2">
                        <x-input.basic wire:model="name" id="name" name="name" type="text"
                            placeholder="Nama Lengkap User">
                            Nama Lengkap
                        </x-input.basic>
                        @error('name')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <x-input.basic wire:model="email" id="email" name="email" type="email"
                            placeholder="user@indodacin.com">
                            Alamat Email
                        </x-input.basic>
                        @error('email')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Keamanan Section -->
            <div
                class="group relative overflow-hidden rounded-3xl border border-white/30 bg-white/70 p-8 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60">
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-purple-500/5 blur-3xl transition-colors group-hover:bg-purple-500/10">
                </div>

                <div class="mb-8 flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-purple-600"></div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Keamanan Akun</h3>
                </div>

                <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:gap-4">
                    <div class="space-y-2">
                        <x-input.basic wire:model="password" id="password" name="password" type="password"
                            placeholder="••••••••">
                            Password
                        </x-input.basic>
                        @error('password')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <x-input.basic wire:model="password_confirmation" id="password_confirmation"
                            name="password_confirmation" type="password" placeholder="••••••••">
                            Konfirmasi Password
                        </x-input.basic>
                        @error('password_confirmation')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Role Selection -->
        <div class="space-y-2 lg:space-y-4">
            <div
                class="group relative overflow-hidden rounded-3xl border border-white/30 bg-white/70 p-8 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60">
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-green-500/5 blur-3xl transition-colors group-hover:bg-green-500/10">
                </div>

                <div class="mb-6 flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-1 rounded-full bg-green-600"></div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Role & Hak Akses</h3>
                    </div>

                    {{-- Alpine Search --}}
                    <div class="relative w-full" x-data="{ search: '' }">

                        <x-input.basic id="search" name="search" x-model="search"
                            @input="$dispatch('role-search', search)" placeholder="Cari role..." :labels="false" />

                        <div class="mt-4 max-h-[400px] overflow-y-auto pr-1">
                            <div class="flex flex-col gap-2">
                                @foreach ($list_roles as $role)
                                    <label
                                        x-show="search === '' || '{{ strtolower($role->name) }}'.includes(search.toLowerCase())"
                                        class="role-item group/role flex cursor-pointer items-center gap-3 rounded-2xl border border-gray-200 p-4 transition-all hover:border-blue-300 hover:bg-blue-50 dark:border-gray-700 dark:hover:border-blue-700 dark:hover:bg-blue-900/20">
                                        <input wire:model="selected_roles" type="checkbox" value="{{ $role->name }}"
                                            class="h-5 w-5 rounded-lg border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span
                                            class="text-sm font-medium text-gray-700 transition-colors group-hover/role:text-blue-600 dark:text-gray-200">{{ $role->name }}</span>
                                    </label>
                                @endforeach

                                {{-- Empty State --}}
                                <div x-cloak
                                    x-show="search !== '' && ![...$el.parentElement.querySelectorAll('.role-item')].some(el => el.style.display !== 'none')"
                                    class="flex flex-col items-center justify-center py-8 text-gray-400">
                                    <x-icons.info class="mb-2 h-8 w-8 opacity-50" />
                                    <span class="text-xs">Role "<span x-text="search"></span>" tidak ditemukan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('selected_roles')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
