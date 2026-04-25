<div class="flex w-full flex-col gap-4">

    {{-- Action Bar --}}
    <div class="flex flex-row items-center gap-3">
        <x-button.primary id="create-participant" wire:click="$set('showCreateForm', true)">
            <x-slot name="icon">
                <x-icons.plus class="h-4 w-4" />
            </x-slot>
            Tambah Partisipan
        </x-button.primary>

        <x-button.secondary id="refresh-table" wire:click="refreshTable">
            <x-slot name="icon">
                <x-icons.clockwise class="h-4 w-4" />
            </x-slot>
            Refresh Tabel
        </x-button.secondary>
    </div>

    {{-- Form Section --}}
    <div wire:key="create-participant-form"
        class="{{ $showCreateForm ? 'block' : 'hidden' }} transform rounded-3xl border border-zinc-200 bg-white p-6 shadow-xl transition-all dark:border-zinc-800 dark:bg-zinc-900 sm:p-8">

        <div class="mb-6 flex items-center justify-between border-b border-zinc-200 pb-5 dark:border-zinc-800">
            <div>
                <h3 class="text-lg font-black tracking-tight text-zinc-900 dark:text-white">Form Partisipan Baru</h3>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Cari dan daftarkan user ke event ini</p>
            </div>
            <x-button.secondary wire:click="$set('showCreateForm', false)"
                class="!bg-transparent !p-1 !shadow-none !ring-0 !border-none">
                <x-slot name="icon">
                    <x-icons.close class="h-6 w-6" />
                </x-slot>
            </x-button.secondary>
        </div>

        <form wire:submit.prevent="store" class="space-y-6">
            {{-- User Search Section --}}
            <div class="space-y-4">
                <div class="w-full">
                    <x-input.basic id="search-user" name="search_user" wire:model.live.throttle.100ms="search"
                        placeholder="Ketik nama karyawan..." :labels="'Cari User'">
                        Nama Partisipan
                    </x-input.basic>

                    @error('user_id')
                        <p class="mt-2 text-xs font-bold italic text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Result List --}}
                <div
                    class="max-h-60 space-y-2 overflow-y-auto rounded-2xl border border-zinc-200 bg-zinc-50/50 p-2 dark:border-zinc-800 dark:bg-zinc-950/20">
                    @forelse ($users as $user)
                        <label for="user-option-{{ $user->id }}"
                            class="{{ $user_id == $user->id ? 'bg-white border-red-500/30 shadow-md dark:bg-zinc-800 dark:border-red-600/50' : '' }} flex cursor-pointer items-center justify-between rounded-xl border border-transparent p-3 transition-all hover:bg-white hover:shadow-sm dark:hover:bg-zinc-800">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-zinc-200 text-xs font-bold text-zinc-600 dark:bg-zinc-700 dark:text-zinc-400">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-bold text-zinc-900 dark:text-white">{{ $user->name }}</span>
                                    <span
                                        class="text-[10px] font-black uppercase tracking-widest text-zinc-400">{{ $user->kode_pegawai ?? '-' }}</span>
                                </div>
                            </div>

                            <input id="user-option-{{ $user->id }}" wire:model="user_id" type="radio"
                                name="user_id" value="{{ $user->id }}"
                                class="h-5 w-5 border-zinc-300 text-red-600 focus:ring-red-500 dark:border-zinc-700 dark:bg-zinc-800">
                        </label>
                    @empty
                        <div class="flex flex-col items-center justify-center py-10 opacity-40">
                            <svg class="h-10 w-10 text-zinc-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <p class="mt-2 text-sm italic">Cari nama untuk melihat hasil</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Redirect Field --}}
            <div class="w-full">
                <x-input.basic id="redirect-to" placeholder="https://example.com" name="redirect_to"
                    wire:model.live.throttle.200ms="redirect_to">
                    Redirect Ke (Opsional)
                </x-input.basic>

                @error('redirect_to')
                    <p class="mt-2 text-xs font-bold italic text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Form Footer --}}
            <div class="flex items-center justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-800">
                <x-button.secondary type="button" wire:click="$set('showCreateForm', false)">
                    Batal
                </x-button.secondary>
                <x-button.success type="submit">
                    <x-slot name="icon">
                        <x-icons.check class="h-4 w-4" />
                    </x-slot>
                    Simpan Partisipan
                </x-button.success>
            </div>
        </form>
    </div>
</div>
