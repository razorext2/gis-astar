<div
    class="{{ $data->on_delay || $data->status_approval === 4 ? 'overflow-hidden' : 'overflow-x-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-zinc-300 dark:scrollbar-thumb-zinc-700' }} relative flex w-full flex-row items-center gap-2 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 sm:p-6">

    {{-- Timeline items container --}}
    <div
        class="{{ $data->on_delay || $data->status_approval === 4 ? 'blur-[2px] saturate-50' : '' }} flex w-full flex-row items-center gap-4">
        @foreach ($status as $item)
            <x-icons.spk-delivery-status :desc="$item['desc']" :itemstatus="$item['status']" :status="$data->status" :icon="$item['icon']"
                :last="$loop->last" :ping="$item['status'] == $data->status" />
        @endforeach
    </div>

    {{-- DELAY OVERLAY --}}
    @if ($data->on_delay && $data->status_approval !== 4)
        <div
            class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-red-50/90 p-4 backdrop-blur-md dark:bg-red-950/80">
            <div class="flex items-start gap-4">
                <div
                    class="mt-0.5 flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600 ring-1 ring-red-500/30 dark:bg-red-500/20 dark:text-red-400 dark:ring-red-500/50">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <h4 class="text-lg font-black uppercase tracking-widest text-red-600 dark:text-red-400">SPK
                        MENGALAMI DELAY</h4>
                    <p class="text-xs font-medium text-red-800/60 dark:text-red-300/60">
                        {{ $data->on_delay_at }}
                    </p>
                    <div class="mt-2 flex flex-col gap-0.5 border-l-2 border-red-500/30 pl-3">
                        <p class="max-w-lg text-left text-sm font-medium italic text-red-900 dark:text-red-200">
                            "{{ $data->on_delay_notes }}"
                        </p>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-red-700 dark:text-red-400">
                            BY: {{ $data->onDelayBy->name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- CANCELED OVERLAY --}}
    @if ($data->status_approval === 4)
        <div
            class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-red-50/90 p-4 backdrop-blur-md dark:bg-red-950/80">
            <div class="flex items-start gap-4">
                <div
                    class="mt-0.5 flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 shadow-xl shadow-red-500/10 ring-1 ring-red-500/30 dark:bg-red-500/20 dark:text-red-500 dark:ring-red-500/50">
                    <x-icons.close class="h-6 w-6" />
                </div>
                <div class="flex flex-col">
                    <h4 class="text-lg font-black uppercase tracking-widest text-red-600 dark:text-red-500">SPK
                        DIBATALKAN</h4>
                    <p class="text-xs font-medium text-red-800/60 dark:text-red-300/60">
                        {{ $data->cancel_request_at }} <span class="mx-1 opacity-30">|</span> Divalidasi:
                        {{ $data->cancel_request_validated_at }}
                    </p>
                    <div class="mt-2 flex flex-col gap-0.5 border-l-2 border-red-500/30 pl-3">
                        <p class="max-w-lg text-left text-sm font-medium italic text-red-900 dark:text-red-200">
                            "{{ $data->cancel_request_reason }}"
                        </p>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-red-700 dark:text-red-400">
                            Oleh: {{ $data->cancelRequestBy?->name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
