@props([
    'actionName' => null,
    'id' => 'base-modal',
    'title' => 'Base Modal',
])

<div id="{{ $id }}" class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-950/65 p-4 backdrop-blur-sm">
    <!-- Modal -->
    <div
        class="h-[85vh] w-full max-w-4xl overflow-hidden rounded-xl bg-white/60 backdrop-blur-md text-zinc-800 shadow-2xl ring-1 ring-zinc-200 dark:bg-dark-primary/60 dark:backdrop-blur-md dark:text-white dark:ring-zinc-800">
        <div class="flex items-center justify-between border-b px-4 py-2 dark:border-zinc-800">
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
