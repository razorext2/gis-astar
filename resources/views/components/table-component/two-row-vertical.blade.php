{{-- Goal: Render vertical two-row comparison for time data, Livewire: -, Alpine: - --}}
<div class="flex flex-col gap-2 min-w-[150px] text-left">
    <!-- Device / Original Time -->
    <div class="flex items-start gap-1.5 text-xs text-zinc-500 dark:text-zinc-400">
        <svg class="h-4 w-4 text-zinc-400 dark:text-zinc-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 5h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2z" />
        </svg>
        <div class="flex flex-col">
            <span class="text-[9px] uppercase tracking-wider font-semibold text-zinc-400 dark:text-zinc-500 leading-none">Device Time</span>
            <span class="text-zinc-600 dark:text-zinc-300 font-medium mt-0.5">{{ $a }}</span>
        </div>
    </div>

    <!-- System / Processed Time -->
    <div class="flex items-start gap-1.5 text-xs">
        <svg class="h-4 w-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="flex flex-col">
            <span class="text-[9px] uppercase tracking-wider font-semibold text-blue-500 leading-none">System Time</span>
            <span class="text-zinc-900 dark:text-white font-semibold mt-0.5">{{ $b }}</span>
        </div>
    </div>
</div>
