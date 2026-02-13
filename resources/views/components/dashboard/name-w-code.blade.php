@props(['capitalize' => true, 'text_color' => 'gray'])

<div class="flex w-fit min-w-32 flex-col items-start text-wrap">
    <span class="{{ $capitalize ? 'capitalize' : '' }} text-{{ $text_color }}-400 text-xs">{{ $code ?? 'N/A' }}</span>
    <span class="font-medium capitalize dark:text-gray-200">{{ $name ?? 'N/A' }}</span>
    <span class="text-xs capitalize text-gray-400">{{ $item3 ?? '' }}</span>
</div>
