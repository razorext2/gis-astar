{{-- Goal: Pasien index page wrapper with header + PowerGrid table --}}
<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white">Data Pasien</h2>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Kelola daftar pasien dan koordinat lokasi</p>
        </div>

        @can('pasien-create')
            <x-button.primary href="{{ route('pasien.create') }}" wire:navigate>
                <x-slot name="icon">
                    <x-icons.plus class="h-4 w-4" />
                </x-slot>
                Tambah Pasien
            </x-button.primary>
        @endcan
    </div>

    <livewire:powergrid-tables.pasien-table />
</div>
