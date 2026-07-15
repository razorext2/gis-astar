@props([
    'row',
    'type' => 'in', // 'in' or 'out'
])

@php
    $isIn = $type === 'in';
    $keyPrefix = $isIn ? 'in-' : 'out-';
    $clickMethod = $isIn ? "openModal({$row->id})" : "openModalOut({$row->id})";
    $themeColor = $isIn ? 'emerald' : 'red';
    $colorClass = $isIn ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400';
    $borderClass = $isIn
        ? '!border-emerald-500 !shadow-lg dark:!border-emerald-500'
        : '!border-red-500 !shadow-lg dark:!border-red-500';
    $hoverBorder = $isIn
        ? 'hover:border-emerald-200 dark:hover:border-emerald-900/50'
        : 'hover:border-red-200 dark:hover:border-red-900/50';
    $hoverShadow = $isIn ? 'hover:shadow-emerald-500/5' : 'hover:shadow-red-500/5';
@endphp

<div wire:key="{{ $keyPrefix }}{{ $row->id }}" x-data="{ loading: false }" wire:click="{{ $clickMethod }}"
    @click="loading = true" x-on:attendance-modal-ready.window="loading = false"
    :class="loading ? '{{ $borderClass }}' : ''"
    class="{{ $hoverBorder }} {{ $hoverShadow }} group relative flex cursor-pointer flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm transition-all duration-300 hover:bg-white hover:shadow-xl dark:border-zinc-800 dark:bg-zinc-900 lg:flex-row">

    {{-- Foto --}}
    <div class="relative h-44 w-full overflow-hidden lg:h-auto lg:w-44 lg:shrink-0">
        <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
            src="{{ $row->photo_src }}" alt="{{ $row->pegawaiRelasi->full_name }}">
    </div>

    {{-- Info --}}
    <div class="flex flex-1 flex-col justify-between gap-3 p-4">
        <div>
            <div class="mb-1 flex items-start justify-between gap-2">
                <h5 class="flex items-center gap-1.5 text-base font-black tracking-tight text-zinc-900 dark:text-white">
                    {{ $row->pegawaiRelasi->full_name }}
                    <x-dashboard.badge-inactive :is_active="$row->user?->is_active ?? true" />
                </h5>
                <span
                    class="rounded-full bg-zinc-100 px-2 py-0.5 text-[10px] font-bold text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                    {{ $row->timezone ?? 'WIB' }}
                </span>
            </div>
            <div class="{{ $colorClass }} flex items-center gap-1.5 text-xs font-medium">
                @if ($isIn)
                    <x-icons.check-circle class="h-3.5 w-3.5" />
                    <span>Check-in pukul {{ $row->parsed_time->format('H:i:s') }}</span>
                @else
                    <x-icons.minus-circle class="h-3.5 w-3.5" />
                    <span>Check-out pukul {{ $row->parsed_time->format('H:i:s') }}</span>
                @endif
            </div>
            @if ($isIn && $row->late_duration)
                <div class="mt-1 flex items-center gap-1 text-xs font-medium text-amber-500 dark:text-amber-400">
                    <x-icons.exclamation-circle class="h-3.5 w-3.5" />
                    <span>Terlambat {{ $row->late_duration }}</span>
                </div>
            @endif
        </div>

        @if ($row->keterangan)
            <div class="flex items-start gap-2 border-t border-zinc-200 pt-3 dark:border-zinc-800/50">
                <div class="mt-0.5 shrink-0">
                    @if ($row->position_status == 1)
                        <x-icons.exclamation-circle class="h-4 w-4 text-amber-500" />
                    @elseif ($row->position_status == 2)
                        @if ($isIn)
                            <x-icons.check-circle class="h-4 w-4 text-emerald-500" />
                        @else
                            <x-icons.check-circle class="h-4 w-4 text-red-500" />
                        @endif
                    @elseif ($row->position_status == 3)
                        <x-icons.minus-circle class="h-4 w-4 text-rose-500" />
                    @else
                        <x-icons.question-circle class="h-4 w-4 text-zinc-400" />
                    @endif
                </div>
                <p class="line-clamp-2 text-xs font-medium text-zinc-500 dark:text-zinc-400">
                    {{ $row->keterangan }}
                </p>
            </div>
        @endif
    </div>

    <div class="absolute right-3 top-1/2 -translate-y-1/2">
        <div x-show="!loading"
            class="opacity-0 transition-all duration-300 group-hover:translate-x-1 group-hover:opacity-100">
            <x-icons.arrow-right class="{{ $colorClass }} h-5 w-5" />
        </div>
        <div x-show="loading">
            <x-icons.loading class="!{{ $colorClass }} h-5 w-5" />
        </div>
    </div>
</div>
