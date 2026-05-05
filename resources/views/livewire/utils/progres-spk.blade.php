<div
    class="{{ $data->on_delay || $data->status_approval === 4 ? 'overflow-hidden' : 'overflow-x-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-zinc-300 dark:scrollbar-thumb-zinc-700' }} relative flex w-full flex-row items-center gap-2 bg-white p-4 dark:bg-zinc-900/50 sm:p-6">

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
        <div class="absolute inset-0 z-20 flex items-center justify-center bg-red-950/40 p-4 backdrop-blur-[4px]">
            <div
                class="w-full max-w-sm transform rounded-2xl border border-red-500/30 bg-white p-6 shadow-2xl transition-all dark:bg-zinc-900">
                <div class="mb-4 flex flex-col items-center">
                    <div
                        class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-sm font-black uppercase tracking-widest text-red-600 dark:text-red-400">SPK
                        MENGALAMI DELAY</h4>
                    <p class="mt-1 text-center text-xs font-bold text-zinc-400 dark:text-zinc-500">
                        {{ $data->on_delay_at }}</p>
                </div>
                <div class="space-y-2 rounded-xl bg-red-50 p-4 dark:bg-red-950/20">
                    <p class="text-center text-sm font-medium leading-relaxed text-zinc-900 dark:text-red-100">
                        "{{ $data->on_delay_notes }}"
                    </p>
                    <div
                        class="mt-2 flex items-center justify-center gap-1 text-[10px] font-bold text-red-700/60 dark:text-red-400/50">
                        <span>BY:</span>
                        <span class="uppercase">{{ $data->onDelayBy->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- CANCELED OVERLAY --}}
    @if ($data->status_approval === 4)
        <div class="absolute inset-0 z-20 flex items-center justify-center bg-zinc-950/60 p-4 backdrop-blur-[6px]">
            <div
                class="w-full max-w-sm transform rounded-2xl border border-red-500/30 bg-white p-6 shadow-2xl transition-all dark:bg-zinc-900">
                <div class="mb-4 flex flex-col items-center">
                    <div
                        class="mb-3 flex h-14 w-14 items-center justify-center rounded-xl bg-red-600 text-white shadow-xl shadow-red-500/20">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <h4 class="text-base font-black uppercase tracking-widest text-red-600">SPK DIBATALKAN</h4>
                    <p class="mt-1 text-center text-xs font-bold text-zinc-400 dark:text-zinc-500">
                        {{ $data->cancel_request_at }}
                        <span class="mx-1 opacity-30">|</span>
                        Divalidasi: {{ $data->cancel_request_validated_at }}
                    </p>
                </div>
                <div
                    class="space-y-3 rounded-xl border border-red-100 bg-red-50/50 p-4 dark:border-red-900/20 dark:bg-red-950/10">
                    <p class="text-center text-sm font-semibold italic text-red-900 dark:text-red-200">
                        "{{ $data->cancel_request_reason }}"
                    </p>
                    <div
                        class="mt-2 flex items-center justify-center gap-1.5 border-t border-red-200/50 pt-2 text-[10px] font-black tracking-widest text-red-700/60 dark:border-red-900/30 dark:text-red-400/50">
                        <span>AUTHORIZED BY:</span>
                        <span class="uppercase">{{ $data->cancelRequestBy?->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
