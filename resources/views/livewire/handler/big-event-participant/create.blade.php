<div class="flex w-full flex-col gap-4">

    {{-- Action Bar --}}
    <div class="flex flex-row items-center gap-3">
        <button id="create-participant"
            class="flex items-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition-all hover:bg-red-700 hover:shadow-md hover:shadow-red-500/20 active:scale-[0.98]"
            wire:click="$set('showCreateForm', true)">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Partisipan
        </button>

        <button id="refresh-table"
            class="flex items-center gap-2 rounded-xl border border-zinc-200 bg-white px-5 py-2.5 text-sm font-bold text-zinc-700 transition-all hover:bg-zinc-50 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700"
            wire:click="refreshTable">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Refresh Tabel
        </button>
    </div>

    {{-- Form Section --}}
    <div wire:key="create-participant-form"
        class="{{ $showCreateForm ? 'block' : 'hidden' }} transform rounded-3xl border border-zinc-200 bg-white p-6 shadow-xl transition-all dark:border-zinc-800 dark:bg-zinc-900 sm:p-8">

        <div class="mb-6 flex items-center justify-between border-b border-zinc-200 pb-5 dark:border-zinc-800">
            <div>
                <h3 class="text-lg font-black tracking-tight text-zinc-900 dark:text-white">Form Partisipan Baru</h3>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Cari dan daftarkan user ke event ini</p>
            </div>
            <button wire:click="$set('showCreateForm', false)"
                class="text-zinc-400 hover:text-zinc-900 dark:hover:text-white">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
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
                <button type="button" wire:click="$set('showCreateForm', false)"
                    class="rounded-xl border border-zinc-200 bg-white px-6 py-2.5 text-sm font-bold text-zinc-700 transition-all hover:bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-300">
                    Batal
                </button>
                <button type="submit"
                    class="rounded-xl bg-red-600 px-8 py-2.5 text-sm font-bold text-white shadow-sm transition-all hover:bg-red-700 hover:shadow-md hover:shadow-red-500/20 active:scale-[0.98]">
                    Simpan Partisipan
                </button>
            </div>
        </form>
    </div>
</div>
