{{-- Goal: Display SPK progress timeline with status overlays, Livewire: App\Livewire\Utils\ProgresSpk, Alpine: dynamicBg --}}
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
        <div class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-red-50/90 p-4 dark:bg-red-950/80"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="flex items-start gap-4">
                <div
                    class="mt-0.5 flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600 ring-1 ring-red-500/30 dark:bg-red-500/20 dark:text-red-400 dark:ring-red-500/50">
                    <x-icons.clock class="h-6 w-6" />
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

    {{-- CANCELLED OVERLAY --}}
    @if ($data->status_approval === 4)
        <div class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-red-50/90 p-4 dark:bg-red-950/80"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="flex items-start gap-4">
                <div
                    class="mt-0.5 flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 shadow-xl ring-1 ring-red-500/30 dark:bg-red-500/20 dark:text-red-500 dark:ring-red-500/50">
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
