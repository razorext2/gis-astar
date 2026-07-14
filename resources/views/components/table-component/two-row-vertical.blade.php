{{-- Goal: Render vertical two-row comparison for time data, Livewire: -, Alpine: - --}}
<div class="flex flex-col gap-2 min-w-[150px] text-left">
    <!-- Device / Original Time -->
    <div class="flex items-start gap-1.5 text-xs text-zinc-500 dark:text-zinc-400">
        <x-icons.computer class="h-4 w-4 text-zinc-400 dark:text-zinc-500 flex-shrink-0 mt-0.5" />
        <div class="flex flex-col">
            <span class="text-[9px] uppercase tracking-wider font-semibold text-zinc-400 dark:text-zinc-500 leading-none">Device Time</span>
            <span class="text-zinc-600 dark:text-zinc-300 font-medium mt-0.5">{{ $a }}</span>
        </div>
    </div>

    <!-- System / Processed Time -->
    <div class="flex items-start gap-1.5 text-xs">
        <x-icons.clock class="h-4 w-4 text-blue-500 flex-shrink-0 mt-0.5" />
        <div class="flex flex-col">
            <span class="text-[9px] uppercase tracking-wider font-semibold text-blue-500 leading-none">System Time</span>
            <span class="text-zinc-900 dark:text-white font-semibold mt-0.5">{{ $b }}</span>
        </div>
    </div>
</div>
