{{-- Goal: Reusable Alpine.js-driven sparkline chart, Livewire: None, Alpine: dynamic points binding --}}
@props(['points', 'strokeClass' => 'stroke-blue-500 dark:stroke-blue-400'])

<svg {{ $attributes }} viewBox="0 0 120 40" preserveAspectRatio="none">
    <polyline fill="none" class="{{ $strokeClass }}" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
        :points="{{ $points }}" />
</svg>
