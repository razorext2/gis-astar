{{-- Goal: Render Production index tabs conditionally to avoid URL conflicts, Livewire: App\Livewire\Handler\Spk\ProductionTabs, Alpine: false --}}
<div class="rounded-xl border border-zinc-200 shadow-md dark:border-zinc-800 dark:shadow-none"
    x-bind:class="dynamicBg ?
        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
    <div class="border-b border-zinc-200 px-4 pt-2 dark:border-zinc-800 lg:px-6">
        <ul class="-mb-px flex flex-wrap text-center text-sm font-medium" role="tablist">
            <li class="me-2" role="presentation">
                <x-nav.tab :active="$activeTab === 'all'" id="semua-jenis-timbangan-tab" wire:click="setTab('all')">
                    Semua Jenis Timbangan
                </x-nav.tab>
            </li>
            <li class="me-2" role="presentation">
                <x-nav.tab :active="$activeTab === 'timbangan'" id="timbangan-jembatan-tab" wire:click="setTab('timbangan')">
                    Timbangan Jembatan
                </x-nav.tab>
            </li>
            <li class="me-2" role="presentation">
                <x-nav.tab :active="$activeTab === 'non_timbangan'" id="non-timbangan-jembatan-tab" wire:click="setTab('non_timbangan')">
                    Non Timbangan Jembatan
                </x-nav.tab>
            </li>
        </ul>
    </div>

    <div class="px-2 py-4 lg:p-6">
        @if ($activeTab === 'all')
            <div>
                <livewire:production-table />
            </div>
        @elseif ($activeTab === 'timbangan')
            <div>
                <livewire:production-table tipe_timbangan="timbangan jembatan" />
            </div>
        @elseif ($activeTab === 'non_timbangan')
            <div>
                <livewire:production-table tipe_timbangan="non timbangan jembatan" />
            </div>
        @endif
    </div>

    @can('produksi-approve')
        <livewire:handler.production-histories.bulk-approve-histories />
    @endcan
</div>
