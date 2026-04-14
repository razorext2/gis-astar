@props([
    'last' => false,
    'desc' => null,
    'icon' => null,
    'ping' => false,
    'status' => 0,
    'itemstatus' => 0,
])

<div class="flex flex-row items-center justify-center gap-x-2 p-2 sm:p-4 lg:p-6">

    <div class="flex flex-col items-center justify-center gap-4">
        {{-- Icon Container --}}
        <div class="relative flex h-20 w-20 flex-row items-center justify-center sm:h-24 sm:w-24">
            
            {{-- Status Background Rings --}}
            <div class="absolute inset-0 flex items-center justify-center">
                {{-- Completed/Active Pulse --}}
                @if($status >= $itemstatus)
                    <span class="{{ $ping ? 'animate-ping' : '' }} absolute inline-flex h-14 w-14 rounded-full bg-red-500 opacity-20"></span>
                    <span class="relative inline-flex h-12 w-12 items-center justify-center rounded-xl bg-red-600 shadow-lg shadow-red-500/20">
                         <div class="h-1.5 w-1.5 rounded-full bg-white"></div>
                    </span>
                @else
                    {{-- Pending Ring --}}
                    <span class="relative inline-flex h-12 w-12 items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800/50">
                    </span>
                @endif
            </div>

            {{-- Main Icon Image --}}
            <div class="relative z-10 transition-transform duration-500 hover:scale-110">
                <img class="{{ $itemstatus > $status ? 'grayscale opacity-30 saturate-0 scale-75' : 'saturate-[1.2] drop-shadow-md' }} h-14 w-14 object-contain transition-all duration-300 sm:h-16 sm:w-16"
                    src="{{ asset('images/icons/status/' . $icon) }}" 
                    alt="{{ $desc }}"
                />
            </div>
        </div>

        {{-- Label/Description --}}
        <div class="flex h-8 flex-col items-center justify-center">
            @if ($itemstatus < $status)
                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            @else
                <p class="{{ $ping ? 'text-zinc-900 dark:text-white font-black' : 'text-zinc-400 dark:text-zinc-600' }} text-center text-[10px] font-bold uppercase tracking-widest sm:text-xs">
                    {{ $desc }}
                </p>
            @endif
        </div>

    </div>

    {{-- Connection Line/Angle --}}
    @if (!$last)
        <div class="flex items-center self-center px-1 opacity-20 dark:opacity-40">
            <svg class="h-5 w-5 text-zinc-400 rtl:rotate-180 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </div>
    @endif

</div>
