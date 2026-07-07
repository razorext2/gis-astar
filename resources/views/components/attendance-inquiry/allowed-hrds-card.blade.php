{{-- Goal: Display list of HRDs authorized to approve attendance inquiries, Livewire: -, Alpine: - --}}
@props(['hrds', 'inquiry' => null])

@php
    $status   = $inquiry?->status;
    $acteBy   = $inquiry?->actedByUser;
    $acteAt   = $inquiry?->acted_at;
    $isActed  = in_array($status, ['approved', 'rejected']);
@endphp

<div
    class="rounded-xl border bg-white/60 p-4 backdrop-blur-md lg:p-6
        {{ $isActed
            ? ($status === 'approved' ? 'border-green-200 dark:border-green-800 dark:bg-zinc-900/60' : 'border-red-200 dark:border-red-800 dark:bg-zinc-900/60')
            : 'border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900/60' }}">

    <div class="mb-4 flex items-center gap-2">
        @if ($status === 'approved')
            <x-icons.check-circle class="h-4 w-4 text-green-500" />
            <h3 class="text-base font-bold text-zinc-900 dark:text-white">Disetujui Oleh</h3>
        @elseif ($status === 'rejected')
            <x-icons.exclamation-circle class="h-4 w-4 text-red-500" />
            <h3 class="text-base font-bold text-zinc-900 dark:text-white">Ditolak Oleh</h3>
        @else
            <x-icons.badge-check class="h-4 w-4 text-blue-500" />
            <h3 class="text-base font-bold text-zinc-900 dark:text-white">Menunggu Konfirmasi HRD Berikut...</h3>
        @endif
    </div>

    @if ($isActed && $acteBy)
        <div class="flex items-center gap-3 rounded-lg border px-3 py-2
            {{ $status === 'approved'
                ? 'border-green-200 bg-green-50 dark:border-green-800 dark:bg-green-900/20'
                : 'border-red-200 bg-red-50 dark:border-red-800 dark:bg-red-900/20' }}">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-xs font-bold
                {{ $status === 'approved'
                    ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400'
                    : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400' }}">
                {{ strtoupper(substr($acteBy->name, 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-zinc-900 dark:text-white">{{ $acteBy->name }}</p>
                @if ($acteAt)
                    <p class="truncate text-xs text-zinc-500 dark:text-zinc-400">
                        {{ $acteAt->locale('id')->isoFormat('DD MMM YYYY HH:mm') }}
                    </p>
                @endif
            </div>
        </div>
    @elseif ($hrds->isNotEmpty())
        <ul class="space-y-2">
            @foreach ($hrds as $hrd)
                @php $isMe = auth()->id() === $hrd->id; @endphp
                <li
                    class="flex items-center gap-3 rounded-lg border px-3 py-2 {{ $isMe ? 'border-teal-200 bg-teal-50 dark:border-teal-800 dark:bg-teal-900/20' : 'border-zinc-100 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-800/50' }}">
                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-xs font-bold {{ $isMe ? 'bg-teal-100 text-teal-600 dark:bg-teal-900/40 dark:text-teal-400' : 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' }}">
                        {{ strtoupper(substr($hrd->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-zinc-900 dark:text-white">{{ $hrd->name }}</p>
                    </div>
                    @if ($isMe)
                        <span class="shrink-0 rounded-full bg-teal-100 px-2 py-0.5 text-[10px] font-bold text-teal-700 dark:bg-teal-900/40 dark:text-teal-400">
                            Anda
                        </span>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <div class="py-4 text-center">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Belum ada HRD yang ditugaskan.</p>
        </div>
    @endif
</div>
