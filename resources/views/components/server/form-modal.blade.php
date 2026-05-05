{{--
    Goal: Modal form tambah/edit konfigurasi server Glances.
    Livewire: system.server-overview
    Alpine: Tidak ada (state dikelola Livewire: showModal, name, api_url, ip_label, is_active)
--}}
@props(['serverId'])

<x-modal.base-modal show="showModal" maxWidth="lg" :title="$serverId ? 'Edit Server' : 'Tambah Server Baru'"
    subtitle="Konfigurasi endpoint API Glances untuk monitoring."
    iconContainerClass="bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">

    <x-slot name="icon">
        <x-icons.computer class="h-6 w-6" />
    </x-slot>

    <form id="form-server" wire:submit="save">
        <div class="space-y-4">
            <div>
                <x-input.basic id="server-name" name="name" wire:model="name" placeholder="Misal: Production Database"
                    required>
                    Nama Server
                </x-input.basic>
                @error('name')
                    <x-input-error :messages="$message" class="mt-1" />
                @enderror
            </div>

            <div>
                <x-input.basic id="api-url" name="api_url" type="url" wire:model="api_url"
                    placeholder="http://192.168.1.1:61208" required>
                    Glances API URL
                </x-input.basic>
                <p class="mt-1 text-xs text-zinc-500">Masukkan URL Glances tanpa trailing slash dan tanpa
                    <code>/api/4/all</code>.
                </p>
                @error('api_url')
                    <x-input-error :messages="$message" class="mt-1" />
                @enderror
            </div>

            <div>
                <x-input.basic id="ip-label" name="ip_label" wire:model="ip_label" placeholder="Misal: 192.168.11.250">
                    IP Display (Manual Override)
                </x-input.basic>
                <p class="mt-1 text-[10px] italic text-zinc-400">Kosongkan jika ingin dideteksi otomatis oleh
                    Glances.</p>
                @error('ip_label')
                    <x-input-error :messages="$message" class="mt-1" />
                @enderror
            </div>

            <div class="pt-2">
                <label class="flex cursor-pointer items-center gap-3">
                    <input type="checkbox" wire:model="is_active"
                        class="h-5 w-5 rounded border-zinc-300 text-red-600 focus:ring-red-600 dark:border-zinc-700 dark:bg-zinc-900">
                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Aktifkan Pemantauan
                        (Polling)</span>
                </label>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <div class="flex w-full flex-col gap-2 sm:flex-row sm:justify-end">
            <x-button.secondary class="w-full justify-center sm:w-auto" wire:click="$set('showModal', false)">
                Batal
            </x-button.secondary>
            <x-button.danger class="w-full justify-center sm:w-auto" type="submit" form="form-server">
                Simpan Data
            </x-button.danger>
        </div>
    </x-slot>
</x-modal.base-modal>
