<div
    class="relative mt-4 overflow-hidden rounded-2xl bg-white/60 p-6 shadow-sm ring-1 ring-zinc-200/60 backdrop-blur-sm dark:bg-dark-primary/60 dark:ring-white/10 lg:p-8">
    <!-- Dekorasi Blur Blob -->
    <div
        class="bg-primary/5 dark:bg-primary/10 pointer-events-none absolute -right-20 -top-20 z-0 h-64 w-64 rounded-full opacity-50 blur-3xl">
    </div>

    <div class="relative z-10">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white lg:text-3xl">Pembentukan Tim Baru</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Silakan masukkan detail tim dan tunjuk ketua tim
                untuk memimpin divisi teknisi.</p>
        </div>

        <form class="flex w-full flex-col gap-5 lg:gap-8" wire:submit.prevent="store">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <!-- Kode Tim -->
                <div class="group">
                    <x-input.basic :labels="true" wire:model.live="team_code" id="team_code" name="team_code"
                        placeholder="Misal: ENG-01" required>
                        Kode Tim Baru
                    </x-input.basic>
                    @error('team_code')
                        <span
                            class="error text-danger mt-1 flex items-center text-xs font-medium text-red-500"><x-icons.close
                                class="mr-1 h-3 w-3" /> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Nama Tim -->
                <div class="group">
                    <x-input.basic :labels="true" wire:model.live="team_name" id="team_name" name="team_name"
                        placeholder="Misal: Tim Elang" required>
                        Nama Tim Baru
                    </x-input.basic>
                    @error('team_name')
                        <span
                            class="error text-danger mt-1 flex items-center text-xs font-medium text-red-500"><x-icons.close
                                class="mr-1 h-3 w-3" /> {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Ketua Tim -->
            <div
                class="flex flex-col rounded-xl bg-gray-50/50 p-5 ring-1 ring-zinc-200 dark:bg-gray-800/30 dark:ring-zinc-800/50">
                <div class="mb-2 flex items-center gap-3">
                    <div class="bg-primary/10 flex h-10 w-10 items-center justify-center rounded-lg">
                        <x-icons.user class="text-primary h-6 w-6" />
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200">Pemilihan Ketua Tim</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Cari berdasarkan nama atau kode sidik jari
                        </p>
                    </div>
                </div>

                <div class="relative mt-3">
                    <x-input.basic :labels="false" wire:model.live.debounce.300ms="search_user"
                        id="team_leader_search" name="search_user" placeholder="Ketik area pencarian di sini..."
                        class="w-full bg-white dark:bg-dark-secondary">
                        <x-slot name="icon">
                            <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </x-slot>
                    </x-input.basic>

                    @if ($search_user != '')
                        <div
                            class="mt-3 max-h-[220px] overflow-y-auto rounded-xl bg-white p-2 shadow-sm ring-1 ring-zinc-200 dark:bg-gray-800 dark:ring-zinc-800">
                            @forelse ($users as $user)
                                <label for="helper-radio-{{ $user->kode_pegawai }}"
                                    class="group flex cursor-pointer items-center rounded-lg p-3 transition-colors hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <div class="flex h-5 items-center">
                                        <input id="helper-radio-{{ $user->kode_pegawai }}" wire:model="team_leader"
                                            type="radio" value="{{ $user->kode_pegawai }}" required
                                            class="text-primary focus:ring-primary/50 h-4 w-4 border-zinc-200 bg-gray-100 focus:ring-2 dark:border-zinc-800 dark:bg-gray-700 dark:ring-offset-gray-800">
                                    </div>
                                    <div class="ms-3 flex flex-col">
                                        <span
                                            class="group-hover:text-primary font-semibold text-gray-900 dark:text-gray-200 dark:group-hover:text-white">{{ $user->name }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Kode Pegawai: <span
                                                class="border-zinc-200 font-bold dark:border-zinc-800">{{ $user->kode_pegawai }}</span></span>
                                    </div>
                                </label>
                            @empty
                                <div
                                    class="text-danger flex flex-col items-center gap-2 px-3 py-6 text-center text-sm font-medium">
                                    <x-icons.close class="h-8 w-8 opacity-50" />
                                    Teknisi tidak ditemukan
                                </div>
                            @endforelse

                            @if ($users->count() >= 5)
                                <div
                                    class="mt-2 text-center text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500">
                                    Scroll untuk melihat lebih banyak</div>
                            @endif
                        </div>
                    @endif
                </div>
                @error('team_leader')
                    <span class="error text-danger mt-3 flex items-center text-sm font-medium text-red-500"><x-icons.close
                            class="mr-1 h-4 w-4" /> {{ $message }}</span>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="mt-2 flex w-full justify-end gap-3 border-t border-zinc-200 pt-6 dark:border-zinc-800/50">
                <x-button.danger href="{{ route('teams.index') }}" wire:navigate as="a">Batal</x-button.danger>

                <x-button.primary type="submit" class="shadow-primary/20 px-8 transition-all hover:shadow-lg">
                    <x-slot name="icon">
                        <x-icons.loading class="h-5 w-5 animate-spin" wire:loading wire:target="store" />
                        <x-icons.plus class="h-5 w-5" wire:loading.remove wire:target="store" />
                    </x-slot>
                    <span wire:loading.remove wire:target="store">Simpan Tim Baru</span>
                    <span wire:loading wire:target="store" class="ml-2">Memproses Data...</span>
                </x-button.primary>
            </div>
        </form>
    </div>
</div>
