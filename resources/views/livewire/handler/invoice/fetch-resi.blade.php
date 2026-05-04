<div class="my-4 flex flex-col gap-4">
    {{-- Action Button --}}
    <div class="flex items-center gap-3">
        <x-button.primary wire:click="fetchResi" wire:loading.attr="disabled"
            class="group relative w-fit overflow-hidden text-sm">
            <div wire:loading.remove wire:target="fetchResi" class="flex items-center gap-2">
                <x-icons.search class="h-4 w-4 transition-transform group-hover:scale-110" />
                <span>Cek Status Resi</span>
            </div>
            <div wire:loading wire:target="fetchResi" class="flex items-center gap-2">
                <svg class="h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span>Memproses...</span>
            </div>
        </x-button.primary>

        @if ($data)
            <span class="text-[10px] font-medium uppercase italic tracking-wide text-zinc-400">
                *Data diperbarui per 1 jam
            </span>
        @endif
    </div>

    {{-- Error Message --}}
    @if ($error)
        <div class="flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-600 dark:border-red-900/30 dark:bg-red-900/10 dark:text-red-400"
            x-data="{ show: true }" x-show="show" x-transition>
            <x-icons.close-sidebar-alt class="h-5 w-5 flex-shrink-0" />
            <p class="font-medium">{{ $error }}</p>
            <x-button.secondary class="!bg-transparent !p-1 !ring-0 hover:!bg-red-100 dark:hover:!bg-red-900/20" @click="show = false">
                <x-slot name="icon">
                    <x-icons.close class="h-4 w-4" />
                </x-slot>
            </x-button.secondary>
        </div>
    @endif

    {{-- Loading Skeleton --}}
    <div wire:loading wire:target="fetchResi" class="w-full">
        <div class="animate-pulse space-y-4">
            <div class="h-24 w-full rounded-2xl bg-zinc-100 dark:bg-zinc-800"></div>
            <div class="space-y-3">
                <div class="h-10 w-full rounded-xl bg-zinc-100 dark:bg-zinc-800"></div>
                <div class="h-10 w-3/4 rounded-xl bg-zinc-100 dark:bg-zinc-800"></div>
            </div>
        </div>
    </div>

    {{-- Data Container --}}
    @if ($data)
        <div class="flex flex-col gap-6 rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm transition-all duration-300 dark:border-zinc-800 dark:bg-zinc-900/50 dark:shadow-none lg:p-6"
            wire:loading.remove wire:target="fetchResi" wire:transition.origin.top>

            {{-- Summary Header --}}
            <div
                class="flex flex-col justify-between gap-4 border-b border-zinc-200 pb-5 dark:border-zinc-800 lg:flex-row lg:items-center">
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-zinc-400">Resi Number</span>
                        <span
                            class="rounded-lg bg-zinc-100 px-2 py-0.5 text-xs font-bold text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                            {{ $data['data']['summary']['awb'] }}
                        </span>
                    </div>
                    <h2 class="text-lg font-black tracking-tight text-zinc-900 dark:text-white">
                        {{ $data['data']['summary']['courier'] }} - {{ $data['data']['summary']['service'] }}
                    </h2>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Weight</span>
                        <span
                            class="text-sm font-bold text-zinc-700 dark:text-zinc-300">{{ $data['data']['summary']['weight'] }}
                            Kg</span>
                    </div>
                    <div class="h-8 w-px bg-zinc-200 dark:bg-zinc-800"></div>
                    <div class="rounded-full bg-red-50 px-4 py-1.5 dark:bg-red-900/20">
                        <span class="text-sm font-black uppercase tracking-wide text-red-600 dark:text-red-400">
                            {{ $data['data']['summary']['status'] }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Shipper & Receiver Grid --}}
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <div
                    class="group h-full rounded-2xl bg-zinc-50/50 p-4 border border-zinc-200 transition-all hover:bg-white hover:border-red-500/30 dark:bg-white/5 dark:border-white/5 dark:hover:bg-white/10 dark:hover:border-red-500/20">
                    <div class="mb-3 flex items-center gap-2 text-zinc-400 group-hover:text-red-500">
                        <x-icons.profile-card class="h-4 w-4" />
                        <span class="text-xs font-bold uppercase tracking-widest">Pengirim</span>
                    </div>
                    <p class="text-base font-bold text-zinc-900 dark:text-white">
                        {{ $data['data']['detail']['shipper'] }}</p>
                    <p class="mt-1 text-sm font-medium text-zinc-500 dark:text-zinc-400">
                        {{ $data['data']['detail']['origin'] }}</p>
                </div>

                <div
                    class="group h-full rounded-2xl bg-zinc-50/50 p-4 border border-zinc-200 transition-all hover:bg-white hover:border-red-500/30 dark:bg-white/5 dark:border-white/5 dark:hover:bg-white/10 dark:hover:border-red-500/20">
                    <div class="mb-3 flex items-center gap-2 text-zinc-400 group-hover:text-red-500">
                        <x-icons.map-pin class="h-4 w-4" />
                        <span class="text-xs font-bold uppercase tracking-widest">Penerima</span>
                    </div>
                    <p class="text-base font-bold text-zinc-900 dark:text-white">
                        {{ $data['data']['detail']['receiver'] }}</p>
                    <p class="mt-1 text-sm font-medium text-zinc-500 dark:text-zinc-400">
                        {{ $data['data']['detail']['destination'] }}</p>
                </div>
            </div>

            {{-- Timeline History --}}
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-2 border-b border-zinc-200 pb-3 dark:border-zinc-800">
                    <x-icons.clipboard-check class="h-4 w-4 text-zinc-400" />
                    <span class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Riwayat
                        Perjalanan</span>
                </div>

                <div class="relative space-y-6 pl-6">
                    {{-- Timeline Line --}}
                    <div class="absolute bottom-4 left-[11px] top-4 w-0.5 bg-zinc-200 dark:bg-zinc-800"></div>

                    @foreach ($data['data']['history'] as $history)
                        <div class="relative">
                            {{-- Timeline Dot --}}
                            <div
                                class="absolute -left-[19px] top-1.5 h-3 w-3 rounded-full border-2 border-white bg-red-600 ring-4 ring-red-50 dark:border-zinc-900 dark:ring-red-900/10">
                            </div>

                            <div
                                class="flex flex-col gap-2 rounded-xl border border-zinc-200 bg-white/50 p-4 transition-all hover:border-red-200 hover:bg-white dark:border-zinc-800 dark:bg-white/5 dark:hover:border-red-900/30 dark:hover:bg-white/10">
                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-xs font-bold uppercase tracking-wide text-zinc-400">
                                        {{ \Carbon\Carbon::parse($history['date'])->isoFormat('DD MMMM YYYY') }}
                                        <span class="mx-1 text-zinc-300">•</span>
                                        {{ \Carbon\Carbon::parse($history['date'])->format('H:i') }}
                                    </p>
                                    @if ($loop->first)
                                        <span
                                            class="rounded-md bg-green-50 px-2 py-0.5 text-[10px] font-bold text-green-600 dark:bg-green-900/20 dark:text-green-500">Terbaru</span>
                                    @endif
                                </div>

                                <div class="flex flex-col gap-1">
                                    <p class="text-sm font-bold text-zinc-800 dark:text-zinc-200">
                                        {{ $history['desc'] ?? '-' }}
                                    </p>
                                    @if ($history['location'])
                                        <div class="flex items-center gap-1 text-zinc-500 dark:text-zinc-400">
                                            <x-icons.map-pin-alt class="h-3 w-3" />
                                            <p class="text-xs font-medium">{{ $history['location'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
