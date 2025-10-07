<div class="h-[450px] w-full rounded-xl border-[1px] border-gray-200 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-50"
	wire:poll.3600s>
	<livewire:livewire-column-chart key="{{ $visitorChart->reactiveKey() }}" :column-chart-model="$visitorChart" />
</div>
