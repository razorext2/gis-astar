{{-- Goal: Render SPK Delivery index tabs conditionally to avoid URL conflicts, Livewire: App\Livewire\Handler\Spk\DeliveryTabs, Alpine: false --}}
<div class="rounded-xl border border-zinc-200 shadow-md dark:border-zinc-800 dark:shadow-none"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
    <div class="border-b border-zinc-200 px-4 pt-2 dark:border-zinc-800 lg:px-6">
        <ul class="-mb-px flex flex-wrap text-center text-sm font-medium" role="tablist">
            <li class="me-2" role="presentation">
                <x-nav.tab :active="$activeTab === 'all'" id="semua-pengiriman-tab" wire:click="setTab('all')">
                    Semua Pengiriman
                </x-nav.tab>
            </li>
            <li class="me-2" role="presentation">
                <x-nav.tab :active="$activeTab === 'process'" id="pengiriman-proses-tab" wire:click="setTab('process')">
                    Dalam Proses Pengiriman
                </x-nav.tab>
            </li>
            <li class="me-2" role="presentation">
                <x-nav.tab :active="$activeTab === 'completed'" id="pengiriman-selesai-tab" wire:click="setTab('completed')">
                    Pengiriman Selesai
                </x-nav.tab>
            </li>
        </ul>
    </div>

    <div class="px-2 py-4 lg:p-6">
        @if ($activeTab === 'all')
            <div>
                @livewire('spk-delivery-table')
            </div>
        @elseif ($activeTab === 'process')
            <div>
                @livewire('spk-delivery-table', ['status_kirim' => 0])
            </div>
        @elseif ($activeTab === 'completed')
            <div>
                @livewire('spk-delivery-table', ['status_kirim' => 1])
            </div>
        @endif
    </div>
</div>
