{{-- Goal: Render SPK index tabs conditionally to avoid URL conflicts, Livewire: App\Livewire\Handler\Spk\IndexTabs, Alpine: false --}}
<div
    class="rounded-xl border border-zinc-200 bg-white/60 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none">
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
                @livewire('spk-table')
            </div>
        @elseif ($activeTab === 'timbangan')
            <div>
                @livewire('spk-table', ['tipe_timbangan' => 'timbangan jembatan'])
            </div>
        @elseif ($activeTab === 'non_timbangan')
            <div>
                @livewire('spk-table', ['tipe_timbangan' => 'non timbangan jembatan'])
            </div>
        @endif
    </div>
</div>
