@props([
    'actionName' => null,
    'id' => 'base-modal',
    'title' => 'Base Modal',
])

<div id="{{ $id }}" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50">
    <!-- Modal -->
    <div
        class="h-[85vh] w-[90vw] overflow-hidden rounded-lg bg-white text-gray-800 shadow-xl dark:bg-dark-secondary dark:text-white">
        <div class="flex items-center justify-between border-b px-4 py-2">
            <h2 class="font-semibold">{{ $title }}</h2>

            <button class="p-2" wire:click="$set('{{ $actionName }}', false)">
                <x-icons.close class="h-5 w-5 text-red-500" />
            </button>
        </div>

        <div class="h-[calc(85vh-48px)] w-full">
            {{-- content here --}}
            {{ $slot }}
        </div>
    </div>
</div>
