{{-- Goal: Reusable approval deadline countdown timer, Livewire: -, Alpine: - --}}

@props([
    'updatedAt',
    'compact' => false,
])

@php
    $deadlineDays = config('app.leave_approval_deadline_days', 3);
    $deadlineAt = $updatedAt->copy()->addDays($deadlineDays);
    $hoursRemaining = (int) now()->diffInHours($deadlineAt, false);
    $minutesRemaining = (int) now()->diffInMinutes($deadlineAt, false);
    $isExpired = $hoursRemaining <= 0 && $minutesRemaining <= 0;
    $isUrgent = !$isExpired && $hoursRemaining < 24;
@endphp

<div {{ $attributes->class([
    'flex items-center gap-3 rounded-xl border',
    $compact ? 'px-3 py-2.5' : 'px-4 py-3',
    'border-red-200 bg-red-50 dark:border-red-900/30 dark:bg-red-900/10' => $isExpired,
    'border-amber-200 bg-amber-50 dark:border-amber-900/30 dark:bg-amber-900/10' => $isUrgent,
    'border-blue-200 bg-blue-50 dark:border-blue-900/30 dark:bg-blue-900/10' => !$isExpired && !$isUrgent,
]) }}>
    <div @class([
        'flex shrink-0 items-center justify-center rounded-lg',
        $compact ? 'h-8 w-8' : 'h-9 w-9',
        'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400' => $isExpired,
        'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400' => $isUrgent,
        'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' => !$isExpired && !$isUrgent,
    ])>
        <x-icons.clock @class([$compact ? 'h-4 w-4' : 'h-5 w-5']) />
    </div>

    <div class="min-w-0 flex-1">
        <p @class([
            'font-bold',
            $compact ? 'text-xs' : 'text-sm',
            'text-red-800 dark:text-red-300' => $isExpired,
            'text-amber-800 dark:text-amber-300' => $isUrgent,
            'text-blue-800 dark:text-blue-300' => !$isExpired && !$isUrgent,
        ])>
            @if ($isExpired)
                Batas waktu approval telah habis
            @else
                Sisa Waktu Approval
            @endif
        </p>
        <p @class([
            $compact ? 'text-[10px]' : 'text-xs',
            'text-red-600 dark:text-red-400' => $isExpired,
            'text-amber-600 dark:text-amber-400' => $isUrgent,
            'text-blue-600 dark:text-blue-400' => !$isExpired && !$isUrgent,
        ])>
            @if ($isExpired)
                Pengajuan ini akan ditolak otomatis oleh sistem.
            @elseif ($hoursRemaining < 1)
                {{ $minutesRemaining }} menit lagi — Deadline: {{ $deadlineAt->translatedFormat('d M Y, H:i') }}
            @elseif ($hoursRemaining < 24)
                {{ $hoursRemaining }} jam lagi — Deadline: {{ $deadlineAt->translatedFormat('d M Y, H:i') }}
            @else
                {{ floor($hoursRemaining / 24) }} hari {{ $hoursRemaining % 24 }} jam lagi — Deadline:
                {{ $deadlineAt->translatedFormat('d M Y, H:i') }}
            @endif
        </p>
    </div>

    <span @class([
        'shrink-0 rounded-full font-bold uppercase tracking-wider',
        $compact ? 'px-2 py-0.5 text-[9px]' : 'px-2.5 py-1 text-[10px]',
        'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' => $isExpired,
        'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' => $isUrgent,
        'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' => !$isExpired && !$isUrgent,
    ])>
        {{ $deadlineDays }} hari
    </span>
</div>
