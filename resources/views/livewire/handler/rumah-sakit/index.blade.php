{{-- Goal: RS index page wrapper --}}
<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white">Data Rumah Sakit</h2>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Kelola daftar rumah sakit dan layanan tersedia</p>
        </div>
        @can('rs-create')
            <x-button.primary href="{{ route('rs.create') }}" wire:navigate>
                <x-slot name="icon"><x-icons.plus class="h-4 w-4" /></x-slot>
                Tambah RS
            </x-button.primary>
        @endcan
    </div>
    <livewire:powergrid-tables.rumah-sakit-table />
</div>
