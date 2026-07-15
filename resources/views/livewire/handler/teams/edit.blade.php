<div class="mt-4">
    <form class="flex w-full flex-col gap-4 lg:gap-6" wire:submit.prevent="store">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <!-- Nama Tim (Readonly) -->
            <div class="group">
                <x-input.basic :labels="true" readonly class="cursor-not-allowed bg-gray-50/50 text-gray-500"
                    wire:model="team_name" id="team_name" name="team_name" placeholder="Nama Tim" required>
                    Nama Tim Tersimpan
                </x-input.basic>
                <span class="mt-1 flex items-center text-xs font-medium text-gray-500"><svg class="mr-1 h-3 w-3"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14v3m-3-6V7a3 3 0 1 1 6 0v4m-8 0h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z" />
                    </svg> Anda tidak dapat mengubah nama tim statis</span>
            </div>

            <!-- Kode Tim Baru -->
            <div class="group">
                <x-input.basic :labels="true" wire:model.live="team_code" id="team_code" name="team_code"
                    placeholder="Misal: ENG-01" required>
                    Kode Tim
                </x-input.basic>
                @error('team_code')
                    <span class="error text-danger mt-1 flex items-center text-xs font-medium text-red-500"><x-icons.close
                            class="mr-1 h-3 w-3" /> {{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Ketua Tim -->
        <div
            class="flex flex-col rounded-xl border border-zinc-200 p-4 shadow dark:border-zinc-800"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="mb-2 flex items-center gap-3">
                <div class="bg-primary/10 flex h-10 w-10 items-center justify-center rounded-lg">
                    <x-icons.user class="text-primary h-6 w-6" />
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200">Perubahan Ketua Tim</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Pilih dari daftar anggota teknisi menggunakan
                        kode sidik jari</p>
                </div>
            </div>

            <div class="relative mt-3">
                <x-input.basic :labels="false" wire:model.live.debounce.300ms="search_user" id="team_leader_search"
                    name="search_user" placeholder="Ketik area pencarian teknisi..."
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
                        class="mt-3 max-h-[220px] overflow-y-auto rounded-xl border border-zinc-200 p-2 shadow-sm dark:border-zinc-800 dark:bg-gray-800"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                        @forelse ($users as $user)
                            <label for="helper-radio-{{ $user->kode_pegawai }}"
                                class="group flex cursor-pointer items-center rounded-lg p-3 transition-colors hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <div class="flex h-5 items-center">
                                    <input wire:model="team_leader" id="helper-radio-{{ $user->kode_pegawai }}"
                                        type="radio" value="{{ $user->kode_pegawai }}"
                                        class="text-primary focus:ring-primary/50 h-4 w-4 border-zinc-200 bg-gray-100 focus:ring-2 dark:border-zinc-800 dark:bg-gray-700 dark:ring-offset-gray-800">
                                </div>
                                <div class="ms-3 flex flex-col">
                                    <span
                                        class="group-hover:text-primary font-semibold text-gray-900 dark:text-gray-200 dark:group-hover:text-white">{{ $user->name }}</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Kode Sidik Jari: <span
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
                                Scroll ke bawah untuk kelanjutannya...</div>
                        @endif
                    </div>
                @endif
            </div>
            @error('team_leader')
                <span class="error text-danger mt-3 flex items-center text-sm font-medium text-red-500"><x-icons.close
                        class="mr-1 h-4 w-4" /> {{ $message }}</span>
            @enderror
        </div>

        <div
            class="mt-2 flex w-full flex-col justify-end gap-3 border-t border-zinc-200 pt-6 dark:border-zinc-800/50 sm:flex-row">
            <x-button.danger type="button" wire:click="$set('removeTeamModal', true)"
                class="w-full hover:bg-red-700 sm:w-auto">
                <span>Hapus Seluruh Tim</span>
            </x-button.danger>

            <x-button.primary type="submit"
                class="shadow-primary/20 w-full px-8 transition-all hover:shadow-lg sm:w-auto"
                wire:loading.attr="disabled" wire:target="store">
                <x-slot name="icon">
                    <x-icons.angle-right wire:loading.remove wire:target="store" class="icon h-5 w-5" />
                    <x-icons.loading wire:loading wire:target="store" class="h-4 w-4 animate-spin" />
                </x-slot>

                <span wire:loading.remove wire:target="store">Simpan Perubahan</span>
                <span wire:loading wire:target="store">Memproses Data...</span>
            </x-button.primary>
        </div>

    </form>

    {{-- Modal Remove Team --}}
    <x-modal.base-modal show="removeTeamModal" maxWidth="lg" title="Hapus Keseluruhan Tim"
        iconContainerClass="bg-red-600 shadow-red-500/20">

        <x-slot name="icon">
            <x-icons.trash-bin class="h-5 w-5" />
        </x-slot>

        <div class="space-y-3">
            <p class="text-sm leading-relaxed text-zinc-500 dark:text-zinc-400">
                Apakah Anda yakin ingin menghapus permanen tim dengan kode <span
                    class="font-bold text-zinc-800 dark:text-zinc-200">{{ $team_code }}</span>?
            </p>
            <div class="rounded-lg bg-red-50 p-3 text-xs font-medium text-red-600 dark:bg-red-900/20 dark:text-red-400">
                <p>Tindakan penghancuran formasi ini tidak dapat dipulihkan. Semua data terkait tim ini akan dihapus
                    secara permanen dari sistem.</p>
            </div>
        </div>

        <x-slot name="footer">
            <x-button.secondary type="button" wire:click="$set('removeTeamModal', false)">
                Batal
            </x-button.secondary>

            <x-button.danger wire:click="removeTeamProcess" class="justify-center" wire:loading.attr="disabled"
                wire:target="removeTeamProcess">
                <x-slot name="icon">
                    <x-icons.angle-right wire:loading.remove wire:target="removeTeamProcess" class="icon h-5 w-5" />
                    <x-icons.loading wire:loading wire:target="removeTeamProcess" class="h-4 w-4 animate-spin" />
                </x-slot>
                <span wire:loading.remove wire:target="removeTeamProcess">Hapus Tim Permanen</span>
                <span wire:loading wire:target="removeTeamProcess">Memproses...</span>
            </x-button.danger>
        </x-slot>
    </x-modal.base-modal>
</div>
