<div class="relative h-[450px] w-full overflow-hidden" wire:poll.3600s>
    <livewire:livewire-column-chart key="{{ $visitorChart->reactiveKey() }}" :column-chart-model="$visitorChart" />
</div>
