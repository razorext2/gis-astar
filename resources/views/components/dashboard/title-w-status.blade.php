<div class="flex items-center gap-3 py-1">
    @if ($status == 0)
        <x-dashboard.status :color="'yellow'">
            <span
                class="absolute inset-0 h-full w-full animate-ping rounded-md bg-yellow-400 opacity-75"></span>
            <x-icons.bell-ring class="relative mx-auto inline-flex h-4 w-4" />
        </x-dashboard.status>
    @elseif ($status == 1)
        <x-dashboard.status :color="'green'">
            <x-icons.check class="mx-auto h-4 w-4" />
        </x-dashboard.status>
    @elseif($status == 2 || $status == 4)
        <x-dashboard.status :color="'yellow'">
            <span
                class="absolute inset-0 h-full w-full animate-ping rounded-md bg-yellow-400 opacity-75"></span>
            <x-icons.question-circle class="relative mx-auto inline-flex h-4 w-4" />
        </x-dashboard.status>
    @else
        <x-dashboard.status :color="'red'">
            <x-icons.close class="mx-auto h-4 w-4" />
        </x-dashboard.status>
    @endif

    <div class="flex flex-col text-left">
        <span class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">{{ $title }}</span>
        @if (isset($item3) && $item3)
            <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $item3 }}</span>
        @endif
    </div>
</div>
