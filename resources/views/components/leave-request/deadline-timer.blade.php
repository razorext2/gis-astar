{{-- Goal: Reusable approval deadline countdown timer with real-time Alpine.js countdown, Livewire: -, Alpine: countdown --}}

@props(['updatedAt', 'compact' => false])

@php
    $deadlineDays = config('app.leave_approval_deadline_days', 3);
    $deadlineAt = $updatedAt->copy()->addDays($deadlineDays);
    $deadlineIso = $deadlineAt->toIso8601String();
@endphp

<div {{ $attributes }} x-data="{
    deadline: new Date('{{ $deadlineIso }}'),
    remaining: 0,
    isExpired: false,
    isUrgent: false,
    label: '',
    init() {
        this.tick();
        setInterval(() => this.tick(), 60000);
    },
    tick() {
        const now = new Date();
        const diff = this.deadline - now;
        this.remaining = Math.max(0, diff);
        this.isExpired = diff <= 0;
        this.isUrgent = !this.isExpired && diff < 86400000;
        this.label = this.formatLabel();
    },
    formatLabel() {
        if (this.isExpired) return 'Batas waktu approval telah habis';
        const totalMinutes = Math.floor(this.remaining / 60000);
        const days = Math.floor(totalMinutes / 1440);
        const hours = Math.floor((totalMinutes % 1440) / 60);
        const minutes = totalMinutes % 60;
        if (days > 0) return days + ' hari ' + hours + ' jam lagi';
        if (hours > 0) return hours + ' jam ' + minutes + ' menit lagi';
        return minutes + ' menit lagi';
    }
}" x-init="init()"
    :class="{
        'border-red-200 bg-red-50 dark:border-red-900/30 dark:bg-red-900/10': isExpired,
        'border-amber-200 bg-amber-50 dark:border-amber-900/30 dark:bg-amber-900/10': isUrgent,
        'border-blue-200 bg-blue-50 dark:border-blue-900/30 dark:bg-blue-900/10': !isExpired && !isUrgent,
    }"
    class="{{ $compact ? 'px-3 py-2.5' : 'px-4 py-3' }} flex items-center gap-3 rounded-xl border">
    <div :class="{
        'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400': isExpired,
        'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400': isUrgent,
        'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400': !isExpired && !isUrgent,
    }"
        class="{{ $compact ? 'h-8 w-8' : 'h-9 w-9' }} flex shrink-0 items-center justify-center rounded-lg">
        <x-icons.clock @class([$compact ? 'h-4 w-4' : 'h-5 w-5']) />
    </div>

    <div class="min-w-0 flex-1">
        <p :class="{
            'text-red-800 dark:text-red-300': isExpired,
            'text-amber-800 dark:text-amber-300': isUrgent,
            'text-blue-800 dark:text-blue-300': !isExpired && !isUrgent,
        }"
            class="{{ $compact ? 'text-xs' : 'text-sm' }} font-bold">
            <span x-show="isExpired">Batas waktu approval telah habis</span>
            <span x-show="!isExpired">Sisa Waktu Approval</span>
        </p>
        <p :class="{
            'text-red-600 dark:text-red-400': isExpired,
            'text-amber-600 dark:text-amber-400': isUrgent,
            'text-blue-600 dark:text-blue-400': !isExpired && !isUrgent,
        }"
            class="{{ $compact ? 'text-[10px]' : 'text-xs' }}">
            <span x-show="isExpired">Pengajuan ini akan ditolak otomatis oleh sistem.</span>
            <span x-show="!isExpired">
                <span x-text="label"></span> — Deadline: {{ $deadlineAt->translatedFormat('d M Y, H:i') }}
            </span>
        </p>
    </div>

    <span
        :class="{
            'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300': isExpired,
            'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300': isUrgent,
            'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300': !isExpired && !isUrgent,
        }"
        class="{{ $compact ? 'px-2 py-0.5 text-[9px]' : 'px-2.5 py-1 text-[10px]' }} shrink-0 rounded-full font-bold uppercase tracking-wider">
        {{ $deadlineDays }} hari
    </span>
</div>
