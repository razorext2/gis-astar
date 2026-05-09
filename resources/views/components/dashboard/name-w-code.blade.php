@props(['capitalize' => true, 'text_color' => 'zinc'])

<div class="flex w-fit min-w-32 flex-col items-start text-wrap">
    <span class="{{ $capitalize ? 'capitalize' : '' }} text-{{ $text_color }}-400 text-xs">{{ $code ?? 'N/A' }}</span>
    <span class="font-medium capitalize dark:text-zinc-200">{{ $name ?? 'N/A' }}</span>
    <span class="text-xs capitalize text-zinc-400">{{ $item3 ?? '' }}</span>
</div>
