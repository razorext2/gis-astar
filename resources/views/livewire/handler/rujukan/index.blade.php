{{-- Goal: Rujukan index page --}}
<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white">Data Rujukan</h2>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Riwayat dan status perujukan pasien</p>
        </div>
        @can('rujukan-create')
            <x-button.primary href="{{ route('rujukan.create') }}" wire:navigate>
                <x-slot name="icon"><x-icons.plus class="h-4 w-4" /></x-slot>
                Buat Rujukan
            </x-button.primary>
        @endcan
    </div>
    <livewire:powergrid-tables.rujukan-table />
</div>
