{{-- Goal: Render attendance verification status badge and details, Livewire: -, Alpine: - --}}
@php
    // Map status classes statically so Tailwind compiled classes are guaranteed to exist
    $status_config = [
        0 => [
            'label' => 'Diajukan',
            'badge' => 'bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border-amber-200/60 dark:border-amber-900/40',
        ],
        1 => [
            'label' => 'Diterima',
            'badge' => 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border-emerald-200/60 dark:border-emerald-900/40',
        ],
        2 => [
            'label' => 'Ditolak',
            'badge' => 'bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border-rose-200/60 dark:border-rose-900/40',
        ],
    ];

    $config = $status_config[$status] ?? $status_config[0];
@endphp

<div class="flex flex-col gap-1.5 w-full min-w-[140px] text-left">
    <!-- Row 1: Status & Verification Badge -->
    <div class="flex flex-wrap items-center gap-1.5">
        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium border {{ $config['badge'] }}">
            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
            {{ $config['label'] }}
        </span>

        @if($verified === 'verified')
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-900/30">
                Verified
            </span>
        @else
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200/60 dark:border-zinc-700/60">
                Unverified
            </span>
        @endif
    </div>

    <!-- Row 2: Similarity Score (if verified) & Reviewer info -->
    <div class="flex flex-col gap-0.5 text-[11px] text-zinc-500 dark:text-zinc-400">
        @if($verified === 'verified')
            <div class="flex items-center gap-1">
                <svg class="h-3.5 w-3.5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Kecocokan: <strong class="text-zinc-700 dark:text-zinc-200 font-semibold">{{ $similarity }}</strong></span>
            </div>
        @endif

        @if($verified_by && $verified_by !== '-')
            <div class="flex items-center gap-1">
                <svg class="h-3.5 w-3.5 text-zinc-400 dark:text-zinc-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Oleh: <strong class="text-zinc-700 dark:text-zinc-200 font-semibold">{{ $verified_by }}</strong></span>
            </div>
        @endif
    </div>
</div>
