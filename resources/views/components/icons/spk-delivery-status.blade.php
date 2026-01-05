@props([
    'last' => false,
    'desc' => null,
    'icon' => null,
    'ping' => false,
    'status' => 0,
    'itemstatus' => 0,
])

<div class="flex flex-row items-center justify-center gap-x-4 p-2 lg:p-6">

    <div class="flex flex-col items-center justify-center gap-4">
        <div class="center relative flex h-24 w-24 flex-row items-center justify-center">
            <img class="{{ $itemstatus > $status ? 'saturate-0' : 'saturate-200' }} z-10 w-20"
                src="{{ asset('images/icons/status/' . $icon) }}" />
            <div class="absolute left-1/2 -translate-x-1/2">

                <span class="relative flex h-24 w-24 items-center justify-center">
                    <span
                        class="{{ $ping ? 'animate-ping' : '' }} {{ $status > $itemstatus ?? 'bg-green-500' }} absolute inline-flex h-14 w-14 self-center rounded-full opacity-60"></span>
                    <span
                        class="{{ $status > $itemstatus ?? 'bg-green-200' }} relative inline-flex h-12 w-12 rounded-full"></span>
                </span>

            </div>
        </div>

        <p
            class="{{ $ping ? 'text-gray-800 dark:text-white font-semibold' : 'dark:text-gray-600 text-gray-400' }} text-center text-xs italic">
            @if ($itemstatus < $status)
                <x-icons.check-circle class="h-8 w-8 text-green-500" />
            @else
                {{ $desc }}
            @endif
        </p>

    </div>

    @if (!$last)
        <div class="flex flex-row">
            <x-icons.angle-right class="h-8 w-8" />
        </div>
    @endif

</div>
