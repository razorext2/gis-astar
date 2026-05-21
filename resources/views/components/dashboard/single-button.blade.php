@props(['navigate' => false])

<x-button.primary id="{{ $data['id'] }}" class="my-auto me-4 max-h-10 text-sm" href="{{ $data['action'] }}"
    @if ($navigate) wire:navigate @endif>
    {{ $data['label'] }}
</x-button.primary>
