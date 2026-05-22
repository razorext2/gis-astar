{{-- Goal: Render a single button for table/dashboard actions, Livewire: wire:navigate (optional), Alpine: - --}}
@props(['navigate' => false])

@if ($navigate)
    <x-button.primary id="{{ $data['id'] }}" class="my-auto me-4 max-h-10 text-sm" href="{{ $data['action'] }}" wire:navigate>
        {{ $data['label'] }}
    </x-button.primary>
@else
    <x-button.primary id="{{ $data['id'] }}" class="my-auto me-4 max-h-10 text-sm" href="{{ $data['action'] }}">
        {{ $data['label'] }}
    </x-button.primary>
@endif
