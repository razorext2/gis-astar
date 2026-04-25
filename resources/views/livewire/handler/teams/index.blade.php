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
            class="flex flex-col items-center justify-center rounded-2xl bg-white/50 py-12 ring-1 ring-zinc-200/50 backdrop-blur-md dark:bg-dark-primary/50 dark:ring-white/10">
            <x-icons.user-group class="mb-4 h-16 w-16 text-gray-300 dark:text-gray-600" />
            <p class="text-lg font-medium text-gray-600 dark:text-gray-300">Belum ada tim yang terbentuk</p>
            <p class="mt-1 text-sm text-gray-400 dark:text-gray-500">Buat tim baru terlebih dahulu untuk mulai
                menetapkan anggota.</p>
        </div>
    @endforelse

    @can('team-member-add')
        {{-- modal add member --}}
        @teleport('body')
            <div x-data="{ show: @entangle('showModal') }" x-show="show" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/65 backdrop-blur-sm"
                @click.self="show = false">

                <div x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                    class="relative flex w-full max-w-lg flex-col gap-4 rounded-xl bg-white/95 p-6 shadow-2xl ring-1 ring-white/20 backdrop-blur-sm dark:bg-dark-primary/95 dark:ring-white/10">

                    <div class="absolute right-3 top-3">
                        <x-button.secondary type="button" @click="show = false" class="!rounded-full !p-2">
                            <x-slot name="icon">
                                <x-icons.close class="h-5 w-5" />
                            </x-slot>
                        </x-button.secondary>
                    </div>

                    <div class="text-center">
                        <div class="bg-primary/10 mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full">
                            <x-icons.user-add class="text-primary h-6 w-6" />
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white lg:text-2xl">Tambah Anggota</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Masukkan pegawai ke dalam tim <span
                                class="font-semibold">{{ $team_code }}</span></p>
                    </div>

                    <form class="mt-2 flex flex-col gap-4" wire:submit.prevent="addMemberProcess">

                        <div class="flex w-full flex-col">
                            <x-input.basic required readonly class="cursor-not-allowed bg-gray-50/50 text-gray-500"
                                id="teamCode" name="teamCode" wire:model="team_code" :labels="true">
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
                                    class="mt-2 max-h-[180px] overflow-y-auto rounded-xl bg-gray-50 p-2 ring-1 ring-zinc-200 dark:bg-gray-800/50 dark:ring-zinc-800">
                                    @forelse ($technicians as $technician)
                                        <label for="member-{{ $technician->kode_pegawai }}"
                                            class="group flex cursor-pointer items-center rounded-lg p-2 transition-colors hover:bg-white dark:hover:bg-gray-700">
                                            <input id="member-{{ $technician->kode_pegawai }}" wire:model="newMember"
                                                type="checkbox" value="{{ $technician->kode_pegawai }}"
                                                class="text-primary focus:ring-primary/50 h-4 w-4 rounded-md border-zinc-200 dark:border-zinc-800 dark:bg-gray-700">
                                            <span
                                                class="ms-3 text-sm font-medium text-gray-700 group-hover:text-gray-900 dark:text-gray-300 dark:group-hover:text-white">
                                                <span
                                                    class="mr-1 border-r border-zinc-200 pr-2 font-bold dark:border-zinc-800">{{ $technician->kode_pegawai }}</span>
                                                {{ $technician->name }}
                                            </span>
                                        </label>
                                    @empty
                                        <div class="p-3 text-center text-sm text-gray-500 dark:text-gray-400">
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

                        <div class="mt-4 flex w-full justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-800">
                            <x-button.danger type="button" @click="show = false">Batal</x-button.danger>

                            <x-button.primary type="submit" class="px-6">
                                <x-slot name="icon">
                                    <x-icons.loading class="h-5 w-5" wire:loading wire:target="addMemberProcess" />
                                </x-slot>

                                <span wire:loading.remove wire:target="addMemberProcess"> Masukkan ke Tim </span>
                            </x-button.primary>
                        </div>

                    </form>
                </div>
            </div>
        @endteleport
        {{-- end modal add member --}}
    @endcan

    @can('team-member-remove')
        {{-- modal remove member --}}
        @teleport('body')
            <div x-data="{ show: @entangle('showRemoveMemberModal') }" x-show="show" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/65 backdrop-blur-sm"
                @click.self="show = false">

                <div x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-90"
                    class="relative flex w-full max-w-sm flex-col items-center gap-4 rounded-xl bg-white p-6 text-center shadow-2xl ring-1 ring-white/20 dark:bg-dark-primary dark:ring-white/10">

                    <div
                        class="text-danger mb-2 flex h-16 w-16 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                        <x-icons.trash-bin class="h-8 w-8" />
                    </div>

                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Keluarkan Anggota?</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Anda yakin ingin mengeluarkan anggota dengan kode <span
                            class="font-bold text-gray-800 dark:text-gray-200">{{ $kode_pegawai }}</span> dari tim <span
                            class="font-bold text-gray-800 dark:text-gray-200">{{ $team_code }}</span>? Tindakan ini
                        dapat dibatalkan.
                    </p>

                    <div class="mt-4 flex w-full flex-col justify-center gap-2 sm:flex-row">
                        <x-button.danger class="w-full justify-center" @click="show = false">Batal</x-button.danger>

                        <x-button.danger class="w-full justify-center"
                            wire:click="removeMemberProcess('{{ $kode_pegawai }}', '{{ $team_code }}')">
                            Keluarkan
                        </x-button.danger>
                    </div>
                </div>
            </div>
        @endteleport
        {{-- end modal remove member --}}
    @endcan
</div>
