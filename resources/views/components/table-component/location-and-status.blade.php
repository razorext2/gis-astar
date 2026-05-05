<div class="flex w-full flex-col gap-1 text-wrap lg:gap-2">
    <a class="underline transition-colors duration-500 hover:text-blue-600 dark:hover:text-blue-400"
        href="https://www.google.com/maps/search/?api=1&query={{ $data->latitude }},{{ $data->longitude }}"
        target="_blank">{{ $data->latitude }}, {{ $data->longitude }}</a>

    @if ($data->keterangan)
        @if ($data->position_status == 1)
            <span
                class="flex w-fit flex-row items-center gap-x-1 rounded-lg bg-yellow-600 px-1 py-0.5 text-yellow-200 dark:bg-yellow-600">
                <x-icons.exclamation-circle class="h-4 w-4 text-yellow-300" />
                <p class="text-xs"> Dalam Perjalanan </p>
            </span>
        @elseif($data->position_status == 2)
            <span
                class="flex w-fit flex-row items-center gap-x-1 rounded-lg bg-green-600 px-1 py-0.5 text-green-200 dark:bg-green-600">
                <x-icons.check-circle class="h-4 w-4 text-green-300" />
                <p class="text-xs"> Stand By </p>
            </span>
        @elseif($data->position_status == 3)
            <span
                class="flex w-fit flex-row items-center gap-x-1 rounded-lg bg-red-600 px-1 py-0.5 text-red-200 dark:bg-red-600">
                <x-icons.minus-circle class="h-4 w-4 text-red-300" />
                <p class="text-xs"> Onsite </p>
            </span>
        @else
            <span
                class="flex w-fit flex-row items-center gap-x-1 rounded-lg bg-zinc-600 px-1 py-0.5 text-zinc-200 dark:bg-zinc-600">
                <x-icons.question-circle class="h-4 w-4 text-zinc-300" />
                <p class="text-xs"> Unknown </p>
            </span>
        @endif
    @endif

    <p class="w-full max-w-36 text-wrap text-xs text-zinc-400 lg:max-w-52">
        {{ $data->keterangan }}
    </p>

</div>
