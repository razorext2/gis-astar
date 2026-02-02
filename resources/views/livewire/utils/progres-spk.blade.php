<div
    class="{{ $data->on_delay ? 'overflow-hidden' : 'overflow-x-scroll' }} relative flex w-full flex-row items-center gap-2 dark:text-white">

    @foreach ($status as $item)
        <x-icons.spk-delivery-status :desc="$item['desc']" :itemstatus="$item['status']" :status="$data->status" :icon="$item['icon']"
            :last="$loop->last" :ping="$item['status'] == $data->status" />
    @endforeach

    @if ($data->on_delay && $data->status_approval !== 4)
        <div
            class="absolute left-0 top-0 z-10 flex h-full w-full items-center justify-center rounded-b-lg bg-red-500/75 text-white">
            <div class="flex flex-col gap-1">
                <p class="text-center text-sm">
                    {{ $data->on_delay_at }}
                </p>
                <p class="rounded-full bg-red-500 px-4 py-1 text-center font-semibold italic shadow-md">
                    SPK mengalami delay.
                </p>
                <p class="text-center text-sm">
                    {{ $data->on_delay_notes }} (by: {{ $data->onDelayBy->name }})
                </p>
            </div>
        </div>
    @endif

    @if ($data->status_approval === 4)
        <div
            class="absolute left-0 top-0 z-10 flex h-full w-full items-center justify-center rounded-b-lg bg-red-500/75 text-white">
            <div class="flex flex-col gap-1">
                <p class="text-center text-sm">
                    {{ $data->cancel_request_at }} (Divalidasi: {{ $data->cancel_request_validated_at }})
                </p>
                <p class="rounded-full bg-red-500 px-4 py-1 text-center font-semibold italic shadow-md">
                    SPK Dibatalkan.
                </p>
                <p class="text-center text-sm">
                    {{ $data->cancel_request_reason }} (by: {{ $data->cancelRequestBy?->name }})
                </p>
            </div>
        </div>
    @endif
</div>
