{{-- Goal: Popup notifikasi approval laporan di dashboard, Livewire: Dashboard.ReportApprovalPopup, Alpine: minimize/open state per popup --}}

@php
    $config = $this->config;
    $color = $config['color'];

    $colorClasses = match($color) {
        'blue'    => ['icon_bg' => 'bg-blue-600 shadow-blue-500/20', 'badge_bg' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400', 'fab_bg' => 'bg-blue-600 shadow-blue-500/20', 'fab_badge' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-400', 'counter' => 'text-blue-600 dark:text-blue-400', 'pulse' => 'bg-blue-500'],
        'emerald' => ['icon_bg' => 'bg-emerald-600 shadow-emerald-500/20', 'badge_bg' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400', 'fab_bg' => 'bg-emerald-600 shadow-emerald-500/20', 'fab_badge' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-400', 'counter' => 'text-emerald-600 dark:text-emerald-400', 'pulse' => 'bg-emerald-500'],
        'purple'  => ['icon_bg' => 'bg-purple-600 shadow-purple-500/20', 'badge_bg' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-400', 'fab_bg' => 'bg-purple-600 shadow-purple-500/20', 'fab_badge' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-400', 'counter' => 'text-purple-600 dark:text-purple-400', 'pulse' => 'bg-purple-500'],
        'amber'   => ['icon_bg' => 'bg-amber-500 shadow-amber-500/20', 'badge_bg' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400', 'fab_bg' => 'bg-amber-500 shadow-amber-500/20', 'fab_badge' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-400', 'counter' => 'text-amber-600 dark:text-amber-400', 'pulse' => 'bg-amber-500'],
        'red'     => ['icon_bg' => 'bg-red-600 shadow-red-500/20', 'badge_bg' => 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400', 'fab_bg' => 'bg-red-600 shadow-red-500/20', 'fab_badge' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-400', 'counter' => 'text-red-600 dark:text-red-400', 'pulse' => 'bg-red-500'],
        'cyan'    => ['icon_bg' => 'bg-cyan-600 shadow-cyan-500/20', 'badge_bg' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400', 'fab_bg' => 'bg-cyan-600 shadow-cyan-500/20', 'fab_badge' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-400', 'counter' => 'text-cyan-600 dark:text-cyan-400', 'pulse' => 'bg-cyan-500'],
        default   => ['icon_bg' => 'bg-zinc-600 shadow-zinc-500/20', 'badge_bg' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-500/20 dark:text-zinc-400', 'fab_bg' => 'bg-zinc-600 shadow-zinc-500/20', 'fab_badge' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-900 dark:text-zinc-400', 'counter' => 'text-zinc-600 dark:text-zinc-400', 'pulse' => 'bg-zinc-500'],
    };
@endphp

<div style="display: contents;" x-data="{
    minimized: true,
    init() {
        if (!$wire.hasPending) return;
        setTimeout(() => { $wire.set('showPopup', true); this.minimized = false; }, {{ 800 + ($stackIndex * 400) }});

        this.$watch('$wire.showPopup', value => {
            if (!value) this.minimized = true;
            else this.minimized = false;
        });
    }
}">
    @if ($hasPending)
        {{-- Modal Popup --}}
        <x-modal.base-modal :show="'showPopup'" :title="$config['title'] . ($regionLabel ? ' — ' . $regionLabel : '')"
            subtitle="Laporan menunggu approval Anda" :iconContainerClass="$colorClasses['icon_bg']"
            maxWidth="sm" :showCloseButton="true" :minimizeable="true">
            <x-slot name="icon">
                <x-dynamic-component :component="'icons.' . $config['icon']" class="h-5 w-5 text-white" />
            </x-slot>

            {{-- Region Badge --}}
            @if ($regionLabel)
                <div class="mb-4 flex items-center gap-2">
                    <div class="h-2 w-2 animate-pulse rounded-full {{ $colorClasses['pulse'] }}"></div>
                    <span class="text-xs font-black uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
                        Region:
                    </span>
                    <span
                        class="inline-flex items-center rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-tighter {{ $colorClasses['badge_bg'] }}">
                        {{ $regionLabel }}
                    </span>
                </div>
            @endif

            {{-- Pending Counter --}}
            <div
                class="mb-4 flex flex-col items-center gap-3 rounded-xl border border-zinc-200 bg-zinc-50/50 p-6 dark:border-zinc-800 dark:bg-white/5">
                <div class="text-4xl font-black tracking-tight {{ $colorClasses['counter'] }}">
                    {{ $pendingCount }}
                </div>
                <p class="text-center text-sm font-medium text-zinc-600 dark:text-zinc-400">
                    laporan menunggu <span class="font-bold text-zinc-900 dark:text-white">approval</span> Anda
                </p>
            </div>

            {{-- Info --}}
            <div class="flex items-start gap-2 rounded-lg border border-zinc-200 bg-zinc-50 p-3 dark:border-zinc-800 dark:bg-white/5">
                <x-icons.info-circle class="mt-0.5 h-4 w-4 shrink-0 text-zinc-400" />
                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                    Klik tombol di bawah untuk melihat semua laporan yang membutuhkan tindakan Anda.
                </p>
            </div>

            <x-slot name="footer">
                <x-button.primary wire:navigate href="{{ $config['route'] }}"
                    class="w-full justify-center">
                    <x-slot name="icon">
                        <x-icons.eye class="h-4 w-4" />
                    </x-slot>
                    Lihat Semua
                </x-button.primary>
            </x-slot>
        </x-modal.base-modal>

        {{-- Minimized FAB Button --}}
        <div x-show="minimized" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-y-10 opacity-0 scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-y-0 opacity-100 scale-100"
            x-transition:leave-end="translate-y-10 opacity-0 scale-95"
            data-index="{{ $stackIndex }}"
            class="report-fab-item flex h-11 w-11 cursor-pointer items-center justify-center rounded-xl shadow-lg transition-all duration-200 hover:scale-105 {{ $colorClasses['fab_bg'] }}"
            @click="$wire.set('showPopup', true)"
            style="display: none;">

            <x-dynamic-component :component="'icons.' . $config['icon']" class="h-5 w-5 text-white" />
            <span
                class="absolute -right-1.5 -top-1.5 flex h-5 w-5 items-center justify-center rounded-full border border-white text-[10px] font-black shadow dark:border-zinc-900 {{ $colorClasses['fab_badge'] }}">
                {{ $pendingCount > 99 ? '99+' : $pendingCount }}
            </span>
        </div>
    @endif
</div>

