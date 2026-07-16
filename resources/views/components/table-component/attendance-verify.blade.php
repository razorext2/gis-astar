{{-- Goal: Render attendance verification status badge and details, Livewire: -, Alpine: - --}}
@php
    // Map status classes statically so Tailwind compiled classes are guaranteed to exist
    $status_config = [
        0 => [
            'label' => 'Diajukan',
            'badge' =>
                'bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border-amber-200/60 dark:border-amber-900/40',
        ],
        1 => [
            'label' => 'Diterima',
            'badge' =>
                'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border-emerald-200/60 dark:border-emerald-900/40',
        ],
        2 => [
            'label' => 'Ditolak',
            'badge' =>
                'bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border-rose-200/60 dark:border-rose-900/40',
        ],
    ];

    $config = $status_config[$status] ?? $status_config[0];
@endphp

<div class="flex w-full min-w-[140px] flex-col gap-1.5 text-left">
    <!-- Row 1: Status & Verification Badge -->
    <div class="flex flex-wrap items-center gap-1.5">
        <span
            class="{{ $config['badge'] }} inline-flex items-center gap-1 rounded-full border px-2.5 py-0.5 text-[11px] font-medium">
            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
            {{ $config['label'] }}
        </span>

        @if ($verified === 'verified')
            <span
                class="inline-flex items-center gap-1 rounded-full border border-emerald-200/50 bg-emerald-50 px-2.5 py-0.5 text-[11px] font-medium text-emerald-700 dark:border-emerald-900/30 dark:bg-emerald-950/30 dark:text-emerald-400">
                Verified
            </span>
        @else
            <span
                class="inline-flex items-center gap-1 rounded-full border border-zinc-200/60 bg-zinc-100 px-2.5 py-0.5 text-[11px] font-medium text-zinc-600 dark:border-zinc-700/60 dark:bg-zinc-800 dark:text-zinc-400">
                Unverified
            </span>
        @endif
    </div>

    <!-- Row 2: Similarity Score (if verified) & Reviewer info -->
    <div class="flex flex-col gap-0.5 text-[11px] text-zinc-500 dark:text-zinc-400">
        @if ($verified === 'verified')
            <div class="flex items-center gap-1">
                <x-icons.check-circle-outline class="h-3.5 w-3.5 flex-shrink-0 text-emerald-500" stroke-width="2" />
                <span>Kecocokan: <strong
                        class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $similarity }}</strong></span>
            </div>
        @endif

        @if ($verified_by && $verified_by !== '-')
            <div class="flex items-center gap-1">
                <x-icons.user class="h-3.5 w-3.5 flex-shrink-0 text-zinc-400 dark:text-zinc-500" stroke-width="2" />
                <span>Oleh: <strong
                        class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $verified_by }}</strong></span>
            </div>
        @endif
    </div>
</div>
