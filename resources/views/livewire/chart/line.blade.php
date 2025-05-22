<div class="h-full" wire:poll.60s>
	<livewire:livewire-line-chart key="{{ $multiLineChartModel->reactiveKey() }}" :line-chart-model="$multiLineChartModel" />
</div>
