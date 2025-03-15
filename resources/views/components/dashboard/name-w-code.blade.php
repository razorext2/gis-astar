@props(['capitalize' => true])

<div class="flex min-w-32 flex-col items-start text-wrap">
	<span class="{{ $capitalize ? 'capitalize' : '' }} text-xs text-gray-400">{{ $code ?? 'N/A' }}</span>
	<span class="font-medium capitalize dark:text-gray-200">{{ $name ?? 'N/A' }}</span>
	<span class="text-xs capitalize text-gray-400">{{ $item3 ?? '' }}</span>
</div>
