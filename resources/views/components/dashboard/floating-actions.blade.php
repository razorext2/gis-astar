{{-- Goal: Unified floating actions container for bottom-right FABs and scroll-to-top, Livewire: None, Alpine: scrollToggle() --}}
{{-- Kontainer ini fixed di bottom-right. Slot dirender di atas scroll-to-top via flex-col-reverse. --}}
{{-- overflow: visible agar item absolute (radial FAB) bisa keluar batas container. --}}
<div class="fixed bottom-24 right-4 z-50 flex flex-col-reverse items-end gap-3 md:bottom-8 md:right-8" style="overflow: visible;">

    {{-- Scroll to Top Button (selalu paling bawah) --}}
    <div x-data="scrollToggle()" x-init="init()">
        <a href="javascript:void(0)" @click="handleScroll" :class="atTop ? 'rotate-0' : 'rotate-180'"
            class="flex h-11 w-11 items-center justify-center rounded-full border border-zinc-200/30 bg-white/70 backdrop-blur-md transition-all duration-300 ease-in-out hover:scale-105 hover:bg-zinc-50/50 dark:border-zinc-800/50 dark:bg-zinc-900/60 dark:hover:bg-zinc-800/50">
            <x-icons.carred-down class="h-6 w-6 text-red-600 dark:text-red-500" id="scroll-to-top-icon" />
        </a>
    </div>

    {{-- Slot: item tambahan (report approval FABs, leave popup, dll) --}}
    {{ $slot }}

</div>
