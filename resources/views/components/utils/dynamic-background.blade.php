{{-- Goal: GPU-accelerated interactive grid + cached accent shapes via WebGL + 2D Canvas hybrid, Livewire: None, Alpine: dynamic-background --}}

{{-- Pattern Background: Interactive Lens-Distorted Grid Lines & Chart --}}
<div id="dynamic-bg-container" class="pointer-events-none fixed inset-0 z-0 overflow-hidden"
    style="will-change: transform; transform: translate3d(0, 0, 0); backface-visibility: hidden;" x-data="dynamicBackground">
    {{-- Static grid: light mode (masked near cursor for WebGL handoff) --}}
    <div class="pointer-events-none absolute inset-0 dark:hidden"
        style="background-image: linear-gradient(rgba(161,161,170,0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(161,161,170,0.07) 1px, transparent 1px); background-size: 24px 24px; -webkit-mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 130px, black 180px); mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 130px, black 180px);">
    </div>

    {{-- Static grid: dark mode (masked near cursor for WebGL handoff) --}}
    <div class="pointer-events-none absolute inset-0 hidden dark:block"
        style="background-image: linear-gradient(rgba(161,161,170,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(161,161,170,0.03) 1px, transparent 1px); background-size: 24px 24px; -webkit-mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 130px, black 180px); mask-image: radial-gradient(circle at var(--mouse-x, -100vw) var(--mouse-y, -100vh), transparent 0px, transparent 130px, black 180px);">
    </div>

    {{-- Canvas layers --}}
    <div class="pointer-events-none absolute inset-0">
        <canvas x-ref="canvasGl" class="absolute inset-0 block h-full w-full"
            :class="{ 'hidden': quality === 'low' }"></canvas>
        <canvas x-ref="canvas2d" class="absolute inset-0 block h-full w-full"></canvas>
    </div>
</div>
