{{-- Goal: Ultra-lightweight interactive grid via CSS Masking + cached accent shapes via Canvas 2D, Livewire: None, Alpine: dynamic-background --}}

{{-- Pattern Background: Interactive Grid Lines & Chart --}}
<div id="dynamic-bg-container" class="pointer-events-none fixed inset-0 z-0 overflow-hidden"
    style="will-change: transform; transform: translate3d(0, 0, 0); backface-visibility: hidden;" x-data="dynamicBackground">
    {{-- Static grid: light mode (always visible) --}}
    <div class="pointer-events-none absolute inset-0 dark:hidden"
        style="background-image: linear-gradient(rgba(161,161,170,0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(161,161,170,0.07) 1px, transparent 1px); background-size: 24px 24px;">
    </div>

    {{-- Static grid: dark mode (always visible) --}}
    <div class="pointer-events-none absolute inset-0 hidden dark:block"
        style="background-image: linear-gradient(rgba(161,161,170,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(161,161,170,0.03) 1px, transparent 1px); background-size: 24px 24px;">
    </div>

    {{-- Interactive grid: light mode (visible only near mouse via CSS masking) --}}
    <div class="pointer-events-none absolute inset-0 dark:hidden"
        :class="{ 'hidden': quality === 'low' }"
        style="background-image: linear-gradient(rgba(239,68,68,0.35) 1px, transparent 1px), linear-gradient(90deg, rgba(239,68,68,0.35) 1px, transparent 1px); background-size: 24px 24px;
               mask-image: radial-gradient(circle 170px at var(--mouse-x, -1000px) var(--mouse-y, -1000px), black 0%, transparent 100%);
               -webkit-mask-image: radial-gradient(circle 170px at var(--mouse-x, -1000px) var(--mouse-y, -1000px), black 0%, transparent 100%);">
    </div>

    {{-- Interactive grid: dark mode (visible only near mouse via CSS masking) --}}
    <div class="pointer-events-none absolute inset-0 hidden dark:block"
        :class="{ 'hidden': quality === 'low' }"
        style="background-image: linear-gradient(rgba(185,28,28,0.22) 1px, transparent 1px), linear-gradient(90deg, rgba(185,28,28,0.22) 1px, transparent 1px); background-size: 24px 24px;
               mask-image: radial-gradient(circle 170px at var(--mouse-x, -1000px) var(--mouse-y, -1000px), black 0%, transparent 100%);
               -webkit-mask-image: radial-gradient(circle 170px at var(--mouse-x, -1000px) var(--mouse-y, -1000px), black 0%, transparent 100%);">
    </div>

    {{-- Canvas layers (only Canvas 2D for static accent curves) --}}
    <div class="pointer-events-none absolute inset-0">
        <canvas x-ref="canvas2d" class="absolute inset-0 block h-full w-full"></canvas>
    </div>
</div>
