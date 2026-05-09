<div class="mt-4 grid gap-4 lg:gap-6">
    @forelse ($teams as $row)
        <div wire:key="{{ $row->team_code }}"
            class="hover:shadow-primary/5 hover:ring-primary/20 group relative overflow-hidden rounded-2xl bg-white/60 p-4 ring-1 ring-zinc-200/60 backdrop-blur-sm transition-all duration-300 hover:shadow-xl dark:bg-dark-primary/60 dark:ring-white/10 dark:hover:bg-dark-primary/80 lg:p-6">
            <!-- Dekorasi Blur Blob -->
            <div
                class="bg-primary/10 dark:bg-primary/20 pointer-events-none absolute -right-10 -top-10 z-0 h-40 w-40 rounded-full opacity-0 blur-3xl transition-opacity duration-500 group-hover:opacity-100">
            </div>

            <div class="relative z-10 flex w-full flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <!-- Klik area untuk detail -->
                <div class="flex grow cursor-pointer flex-col" wire:click="showDetail('{{ $row->team_code }}')">
                    <div
                        class="mb-1 flex flex-col gap-1 text-gray-800 dark:text-gray-100 sm:flex-row sm:items-center sm:gap-3">
                        <span class="text-xl font-bold tracking-tight lg:text-2xl">{{ $row->team_code }}</span>
                        <span class="hidden text-gray-400 sm:block">•</span>
                        <span class="text-lg font-medium text-gray-700 dark:text-gray-200">{{ $row->team_name }}</span>

                        @can('team-edit')
                            <x-button.link wire:navigate href="{{ route('teams.edit', $row->team_code) }}"
                                class="ml-0 w-fit !px-2 !py-1">
                                <x-icons.pen class="h-4 w-4" />
                            </x-button.link>
                        @endcan
                    </div>
                    <div class="mt-1 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                        <x-icons.user class="h-4 w-4" />
                        <p>
                            Dikepalai oleh <span
                                class="font-semibold text-gray-700 dark:text-gray-200">{{ optional($row->leader)->name ?? 'Belum ada leader' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Tombol Aksi Kanan -->
                @can('team-member-add')
                    <div class="flex shrink-0">
                        <x-button.primary wire:click="addMemberDialog('{{ $row->team_code }}')"
                            class="transition-all hover:shadow-md">
                            <x-slot name="icon">
                                <x-icons.plus class="h-5 w-5" />
                            </x-slot>
                            <span class="hidden sm:inline">Tambah Anggota</span>
                            <span class="sm:hidden">Anggota</span>
                        </x-button.primary>
                    </div>
                @endcan
            </div>

            {{-- detail member --}}
            @if ($showMember === $row->team_code)
                <div wire:transition.opacity.duration.400ms
                    class="mt-4 min-h-[200px] border-t border-zinc-200 pt-4 dark:border-zinc-800/50">
                    <livewire:team-member-table lazy :teamCode="$row->team_code" :key="$row->team_code" />
                </div>
            @endif
            {{-- end detail member --}}
        </div>
    @empty
        <div
            class="flex flex-col items-center justify-center rounded-2xl border border-zinc-200/50 bg-white/50 py-12 backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/50">
            <x-icons.user-group class="mb-4 h-16 w-16 text-gray-300 dark:text-gray-600" />
            <p class="text-lg font-medium text-gray-600 dark:text-gray-300">Belum ada tim yang terbentuk</p>
            <p class="mt-1 text-sm text-gray-400 dark:text-gray-500">Buat tim baru terlebih dahulu untuk mulai
                menetapkan anggota.</p>
        </div>
    @endforelse

    @can('team-member-add')
        {{-- modal add member --}}
        <x-modal.base-modal show="showModal" title="Tambah Anggota"
            subtitle="Masukkan pegawai ke dalam tim {{ $team_code }}" iconContainerClass="bg-blue-600 shadow-blue-500/20"
            maxWidth="lg">
            <x-slot name="icon">
                <x-icons.user-add class="h-5 w-5" />
            </x-slot>

            <form id="form-add-member" class="mt-2 flex flex-col gap-4" wire:submit.prevent="addMemberProcess">
                <div class="flex w-full flex-col">
                    <x-input.basic required readonly class="cursor-not-allowed bg-zinc-50/50 text-zinc-500" id="teamCode"
                        name="teamCode" wire:model="team_code" :labels="true">
                        Kode Tim Saat Ini
                    </x-input.basic>
                </div>

                <div class="relative flex w-full flex-col">
                    <x-input.basic id="kodePegawai" required placeholder="Ketik nama atau kode teknisi..."
                        name="kodePegawai" wire:model.live.debounce.300ms="kode_pegawai" :labels="true">
                        Cari Teknisi Baru
                    </x-input.basic>

                    @if ($kode_pegawai)
                        <div
                            class="mt-2 max-h-[180px] overflow-y-auto rounded-xl border border-zinc-200 bg-zinc-50 p-2 dark:border-zinc-800 dark:bg-zinc-800/50">
                            @forelse ($technicians as $technician)
                                <label for="member-{{ $technician->kode_pegawai }}"
                                    class="group flex cursor-pointer items-center rounded-lg p-2 transition-colors hover:bg-white dark:hover:bg-zinc-700">
                                    <input id="member-{{ $technician->kode_pegawai }}" wire:model="newMember"
                                        type="checkbox" value="{{ $technician->kode_pegawai }}"
                                        class="h-4 w-4 rounded-md border-zinc-200 text-blue-600 focus:ring-blue-500/50 dark:border-zinc-800 dark:bg-zinc-700">
                                    <span
                                        class="ms-3 text-sm font-medium text-zinc-700 group-hover:text-zinc-900 dark:text-zinc-300 dark:group-hover:text-white">
                                        <span
                                            class="mr-1 border-r border-zinc-200 pr-2 font-bold dark:border-zinc-800">{{ $technician->kode_pegawai }}</span>
                                        {{ $technician->name }}
                                    </span>
                                </label>
                            @empty
                                <div class="p-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    Teknisi tidak ditemukan atau sudah terdaftar di tim lain.
                                </div>
                            @endforelse
                        </div>
                    @endif
                </div>

                <div class="flex w-full flex-col">
                    <x-input.select id="role" name="role" :defaultOption="'Pilih tingkat wewenang'" :options="[
                        'anggota' => 'Staff Biasa (Anggota)',
                    ]" :labels="true"
                        wire:model="role" :textLabel="'Posisi Role'" required />
                </div>
            </form>

            <x-slot name="footer">
                <x-button.secondary type="button" @click="open = false">Batal</x-button.secondary>
                <x-button.primary type="submit" form="form-add-member" class="px-6" wire:loading.attr="disabled"
                    wire:target="addMemberProcess">
                    <x-slot name="icon">
                        <x-icons.angle-right wire:loading.remove wire:target="addMemberProcess" class="icon h-5 w-5" />
                        <x-icons.loading wire:loading wire:target="addMemberProcess" class="h-4 w-4 animate-spin" />
                    </x-slot>

                    <span wire:loading.remove wire:target="addMemberProcess"> Masukkan ke Tim </span>
                    <span wire:loading wire:target="addMemberProcess"> Menyimpan... </span>
                </x-button.primary>
            </x-slot>
        </x-modal.base-modal>
        {{-- end modal add member --}}
    @endcan

    @can('team-member-remove')
        {{-- modal remove member --}}
        <x-modal.base-modal show="showRemoveMemberModal" title="Keluarkan Anggota?"
            subtitle="Tindakan ini akan mengeluarkan teknisi dari tim" iconContainerClass="bg-red-600 shadow-red-500/20"
            maxWidth="sm">
            <x-slot name="icon">
                <x-icons.trash-bin class="h-5 w-5" />
            </x-slot>

            <div class="text-center">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    Anda yakin ingin mengeluarkan anggota dengan kode <span
                        class="font-bold text-zinc-800 dark:text-zinc-200">{{ $kode_pegawai }}</span> dari tim <span
                        class="font-bold text-zinc-800 dark:text-zinc-200">{{ $team_code }}</span>? Tindakan ini
                    dapat dibatalkan di kemudian hari dengan menambahkannya kembali.
                </p>
            </div>

            <x-slot name="footer">
                <div class="flex w-full flex-col gap-2 sm:flex-row sm:justify-end">
                    <x-button.secondary class="w-full justify-center sm:w-auto"
                        @click="open = false">Batal</x-button.secondary>
                    <x-button.danger class="w-full justify-center sm:w-auto"
                        wire:click="removeMemberProcess('{{ $kode_pegawai }}', '{{ $team_code }}')">
                        <x-slot name="icon">
                            <x-icons.angle-right wire:loading.remove
                                wire:target="removeMemberProcess('{{ $kode_pegawai }}', '{{ $team_code }}')"
                                class="icon h-5 w-5" />
                            <x-icons.loading wire:loading
                                wire:target="removeMemberProcess('{{ $kode_pegawai }}', '{{ $team_code }}')"
                                class="h-4 w-4 animate-spin" />
                        </x-slot>

                        <span wire:loading.remove
                            wire:target="removeMemberProcess('{{ $kode_pegawai }}', '{{ $team_code }}')">Keluarkan</span>
                        <span wire:loading
                            wire:target="removeMemberProcess('{{ $kode_pegawai }}', '{{ $team_code }}')">Memproses...</span>
                    </x-button.danger>
                </div>
            </x-slot>
        </x-modal.base-modal>
        {{-- end modal remove member --}}
    @endcan
</div>
