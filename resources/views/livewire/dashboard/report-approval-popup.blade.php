{{-- Goal: Popup notifikasi approval laporan di dashboard, Livewire: Dashboard.ReportApprovalPopup, Alpine: state management grid & minimized FAB --}}

@php
    $config = $this->config;
    $color = $config['color'];

    $colorClasses = match ($color) {
        'blue' => [
            'icon_bg' => 'bg-blue-600 shadow-blue-500/20',
            'badge_bg' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400',
            'fab_bg' => 'bg-blue-600 shadow-blue-500/20',
            'fab_badge' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-400',
            'counter' => 'text-blue-600 dark:text-blue-400',
            'pulse' => 'bg-blue-500',
        ],
        'emerald' => [
            'icon_bg' => 'bg-emerald-600 shadow-emerald-500/20',
            'badge_bg' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
            'fab_bg' => 'bg-emerald-600 shadow-emerald-500/20',
            'fab_badge' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-400',
            'counter' => 'text-emerald-600 dark:text-emerald-400',
            'pulse' => 'bg-emerald-500',
        ],
        'purple' => [
            'icon_bg' => 'bg-purple-600 shadow-purple-500/20',
            'badge_bg' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-400',
            'fab_bg' => 'bg-purple-600 shadow-purple-500/20',
            'fab_badge' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-400',
            'counter' => 'text-purple-600 dark:text-purple-400',
            'pulse' => 'bg-purple-500',
        ],
        'amber' => [
            'icon_bg' => 'bg-amber-500 shadow-amber-500/20',
            'badge_bg' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400',
            'fab_bg' => 'bg-amber-500 shadow-amber-500/20',
            'fab_badge' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-400',
            'counter' => 'text-amber-600 dark:text-amber-400',
            'pulse' => 'bg-amber-500',
        ],
        'red' => [
            'icon_bg' => 'bg-red-600 shadow-red-500/20',
            'badge_bg' => 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400',
            'fab_bg' => 'bg-red-600 shadow-red-500/20',
            'fab_badge' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-400',
            'counter' => 'text-red-600 dark:text-red-400',
            'pulse' => 'bg-red-500',
        ],
        'cyan' => [
            'icon_bg' => 'bg-cyan-600 shadow-cyan-500/20',
            'badge_bg' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400',
            'fab_bg' => 'bg-cyan-600 shadow-cyan-500/20',
            'fab_badge' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-400',
            'counter' => 'text-cyan-600 dark:text-cyan-400',
            'pulse' => 'bg-cyan-500',
        ],
        'indigo' => [
            'icon_bg' => 'bg-indigo-600 shadow-indigo-500/20',
            'badge_bg' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-400',
            'fab_bg' => 'bg-indigo-600 shadow-indigo-500/20',
            'fab_badge' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-400',
            'counter' => 'text-indigo-600 dark:text-indigo-400',
            'pulse' => 'bg-indigo-500',
        ],
        'teal' => [
            'icon_bg' => 'bg-teal-600 shadow-teal-500/20',
            'badge_bg' => 'bg-teal-100 text-teal-700 dark:bg-teal-500/20 dark:text-teal-400',
            'fab_bg' => 'bg-teal-600 shadow-teal-500/20',
            'fab_badge' => 'bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-400',
            'counter' => 'text-teal-600 dark:text-teal-400',
            'pulse' => 'bg-teal-500',
        ],
        default => [
            'icon_bg' => 'bg-zinc-600 shadow-zinc-500/20',
            'badge_bg' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-500/20 dark:text-zinc-400',
            'fab_bg' => 'bg-zinc-600 shadow-zinc-500/20',
            'fab_badge' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-900 dark:text-zinc-400',
            'counter' => 'text-zinc-600 dark:text-zinc-400',
            'pulse' => 'bg-zinc-500',
        ],
    };
@endphp

<div style="display: contents;" x-init="openPopups['{{ $type }}'] = { show: $wire.showPopup && $wire.hasPending };

const triggerAutoOpen = () => {
    if ($wire.hasPending && !$wire.showPopup) {
        const openThisPopup = () => setTimeout(() => $wire.set('showPopup', true), 400);
        if (window.__leavePopupPending) {
            if (window.__leavePopupState?.minimized) {
                openThisPopup();
            } else {
                window.addEventListener('leave-popup-minimized', openThisPopup, { once: true });
            }
        } else {
            setTimeout(() => $wire.set('showPopup', true), 800);
        }
    }
};

if ($wire.hasPending && !$wire.showPopup && $wire.autoPop) {
    triggerAutoOpen();
}

window.addEventListener('enable-autopop', () => {
    $wire.set('autoPop', true);
    triggerAutoOpen();
}, { once: true });

$watch('$wire.showPopup', val => {
    if (openPopups['{{ $type }}']) {
        openPopups['{{ $type }}'].show = val;
    }
});">
    {{-- Teleport Card to the shared Grid Container --}}
    <template x-teleport="#report-popup-grid-container">
        <div x-show="openPopups['{{ $type }}']?.show && $wire.hasPending" @close-all-popups.window="openPopups['{{ $type }}'].show = false; setTimeout(() => $wire.set('showPopup', false), 500)"
            wire:key="popup-card-{{ $type }}"
            x-transition:enter="transition cubic-bezier(0.34, 1.56, 0.64, 1) duration-500 transform origin-bottom-right"
            x-transition:enter-start="opacity-0 scale-0 translate-y-20 translate-x-20"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0 translate-x-0"
            x-transition:leave="transition ease-in duration-300 transform origin-bottom-right"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0 translate-x-0"
            x-transition:leave-end="opacity-0 scale-0 translate-y-20 translate-x-20"
            class="relative col-start-1 row-start-1 mx-auto flex w-full max-w-sm flex-col rounded-xl border border-zinc-200 bg-white shadow-xl dark:border-zinc-800 dark:bg-zinc-900 lg:col-auto lg:row-auto lg:w-[23rem]">

            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-zinc-200 p-4 dark:border-zinc-800">
                <div class="flex items-center gap-3">
                    <div
                        class="{{ $colorClasses['icon_bg'] }} flex h-10 w-10 items-center justify-center rounded-xl text-white shadow-lg">
                        <x-dynamic-component :component="'icons.' . $config['icon']" class="h-5 w-5 text-white" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold tracking-tight text-zinc-900 dark:text-white">
                            {{ $config['title'] }}
                        </h2>
                        @if ($regionLabel)
                            <p
                                class="text-[10px] font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
                                {{ $regionLabel }}
                            </p>
                        @endif
                    </div>
                </div>
                <x-button.secondary @click="openPopups['{{ $type }}'].show = false; setTimeout(() => $wire.set('showPopup', false), 500)"
                    class="!rounded-full !border-none !bg-transparent !p-2 !shadow-none !ring-0">
                    <x-slot name="icon">
                        <x-icons.close class="h-5 w-5" />
                    </x-slot>
                </x-button.secondary>
            </div>

            {{-- Body --}}
            <div class="flex flex-1 flex-col justify-between p-5">
                <div
                    class="mb-4 flex flex-col items-center gap-3 rounded-xl border border-zinc-200 bg-zinc-50/50 p-6 dark:border-zinc-800 dark:bg-white/5">
                    <div class="{{ $colorClasses['counter'] }} text-4xl font-black tracking-tight">
                        {{ $pendingCount }}
                    </div>
                    <p class="text-center text-sm font-medium text-zinc-600 dark:text-zinc-400">
                        @if ($message)
                            {!! $message !!}
                        @else
                            laporan menunggu <span class="font-bold text-zinc-900 dark:text-white">approval</span>
                            Anda
                        @endif
                    </p>
                </div>

                <div
                    class="mb-4 flex items-start gap-2 rounded-lg border border-zinc-200 bg-zinc-50 p-3 dark:border-zinc-800 dark:bg-white/5">
                    <x-icons.info-circle class="mt-0.5 h-4 w-4 shrink-0 text-zinc-400" />
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                        @if ($type === 'production-assigned')
                            Klik tombol di bawah untuk mengisi atau melanjutkan laporan progres produksi Anda.
                        @else
                            Klik tombol di bawah untuk melihat semua laporan yang membutuhkan tindakan Anda.
                        @endif
                    </p>
                </div>

                {{-- Action Button --}}
                <x-button.primary wire:navigate href="{{ $config['route'] }}" class="w-full justify-center">
                    <x-slot name="icon">
                        <x-icons.eye class="h-4 w-4" />
                    </x-slot>
                    Lihat Semua
                </x-button.primary>
            </div>
        </div>
    </template>

    {{-- Minimized FAB Button --}}
    <div x-show="!openPopups['{{ $type }}']?.show && $wire.hasPending"
        x-transition:enter="transition cubic-bezier(0.34, 1.56, 0.64, 1) duration-500 transform"
        x-transition:enter-start="scale-0 opacity-0"
        x-transition:enter-end="scale-100 opacity-100"
        x-transition:leave="transition ease-in duration-300 transform"
        x-transition:leave-start="scale-100 opacity-100"
        x-transition:leave-end="scale-0 opacity-0" data-index="{{ $stackIndex }}"
        class="report-fab-item {{ $colorClasses['fab_bg'] }} flex h-11 w-11 cursor-pointer items-center justify-center rounded-xl shadow-lg transition-transform duration-200 hover:scale-105"
        @click="openPopups['{{ $type }}'].show = true; setTimeout(() => $wire.set('showPopup', true), 500)" style="display: none;">

        <x-dynamic-component :component="'icons.' . $config['icon']" class="h-5 w-5 text-white" />
    </div>
</div>
