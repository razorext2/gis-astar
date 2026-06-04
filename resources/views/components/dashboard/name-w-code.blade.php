{{-- Goal: Render name with code and optional inactive badge, Livewire: -, Alpine: - --}}
@props(['capitalize' => true, 'text_color' => 'zinc', 'is_active' => null, 'is_active_code' => null, 'is_active_item3' => null])

<div class="flex w-fit min-w-32 flex-col items-start text-wrap">
    <span class="{{ $capitalize ? 'capitalize' : '' }} text-{{ $text_color }}-400 text-xs inline-flex items-center gap-1.5">
        {{ $code ?? 'N/A' }}
        <x-dashboard.badge-inactive :is_active="$is_active_code ?? true" />
    </span>
    <span class="font-medium capitalize dark:text-zinc-200 inline-flex items-center gap-1.5">
        {{ $name ?? 'N/A' }}
        <x-dashboard.badge-inactive :is_active="$is_active ?? true" />
    </span>
    <span class="text-xs capitalize text-zinc-400 inline-flex items-center gap-1.5">
        {{ $item3 ?? '' }}
        <x-dashboard.badge-inactive :is_active="$is_active_item3 ?? true" />
    </span>
</div>

