{{-- Pattern Background: Subtle Dots --}}
<div class="pointer-events-none fixed inset-0 z-0"
    style="background-image: radial-gradient(rgba(161, 161, 170, 0.15) 1.5px, transparent 1.5px); background-size: 24px 24px;">
</div>

{{-- Pattern Background: Interactive Glowing Dots Reveal --}}
<div class="pointer-events-none fixed inset-0 z-0"
    style="background-image: radial-gradient(rgba(239, 68, 68, 0.6) 1.5px, transparent 1.5px); background-size: 24px 24px; -webkit-mask-image: radial-gradient(180px circle at var(--mouse-x, 50vw) var(--mouse-y, 50vh), black 0%, transparent 100%); mask-image: radial-gradient(180px circle at var(--mouse-x, 50vw) var(--mouse-y, 50vh), black 0%, transparent 100%);">
</div>

{{-- Interactive Cursor Glow --}}
<div class="pointer-events-none fixed inset-0 z-0 transition duration-300"
    style="background: radial-gradient(400px circle at var(--mouse-x, 50vw) var(--mouse-y, 50vh), rgba(220, 38, 38, 0.12), transparent 40%);">
</div>

{{-- Background: Subtle Chart SVG (Light Mode) --}}
<div class="pointer-events-none fixed inset-0 z-0 dark:hidden" aria-hidden="true">
    <svg class="h-full w-full opacity-100" viewBox="0 0 100 100" preserveAspectRatio="none"
        xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="chartGradLight" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#ef4444" stop-opacity="0.3" />
                <stop offset="100%" stop-color="#fca5a5" stop-opacity="0.1" />
            </linearGradient>
        </defs>
        {{-- Ascending curved path: flat left, surges up toward top-right --}}
        <path d="M 100 0 L 100 100 L 0 100 C 20 100, 45 99, 58 92 C 68 86, 75 72, 82 55 C 88 40, 92 20, 100 0 Z"
            fill="url(#chartGradLight)" />
    </svg>
</div>

{{-- Background: Subtle Chart SVG (Dark Mode) --}}
<div class="pointer-events-none fixed inset-0 z-0 hidden dark:block" aria-hidden="true">
    <svg class="h-full w-full opacity-80" viewBox="0 0 100 100" preserveAspectRatio="none"
        xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="chartGradDark" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#7f1d1d" stop-opacity="0.5" />
                <stop offset="100%" stop-color="#991b1b" stop-opacity="0.15" />
            </linearGradient>
        </defs>
        <path d="M 100 0 L 100 100 L 0 100 C 20 100, 45 99, 58 92 C 68 86, 75 72, 82 55 C 88 40, 92 20, 100 0 Z"
            fill="url(#chartGradDark)" />
    </svg>
</div>
