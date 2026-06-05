{{-- Goal: Render technician leaderboard with deactivation status support, Livewire: Dashboard\TechnicianLeaderboard, Alpine: - --}}
<div>
    @if (auth()->user()->can('technician-list') || auth()->user()->can('point-approve'))
        <div
            class="flex flex-col rounded-xl border border-zinc-200 bg-white/60 p-5 shadow-sm backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 md:p-6">
            <div class="mb-4 flex items-center justify-between border-b border-zinc-200 pb-3 dark:border-zinc-800">
                <div class="flex items-center gap-2">
                    <div
                        class="flex h-6 w-6 items-center justify-center rounded-md bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-500">
                        <x-icons.star class="h-3.5 w-3.5" />
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Leaderboard Teknisi</h3>
                        <span class="text-xs text-zinc-500 dark:text-zinc-400"> {{ now()->format('d M Y') }} </span>
                    </div>
                </div>
                <button wire:click="$toggle('onlyActive')"
                    title="{{ $onlyActive ? 'Tampilkan semua teknisi' : 'Hanya teknisi aktif' }}"
                    class="{{ $onlyActive
                        ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                        : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-700 dark:text-zinc-400' }} flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium transition-colors">
                    <span
                        class="{{ $onlyActive ? 'bg-green-500' : 'bg-zinc-400' }} inline-block h-1.5 w-1.5 rounded-full"></span>
                    {{ $onlyActive ? 'Aktif' : 'Semua teknisi' }}
                </button>
            </div>

            <div class="flex-1">
                @if ($leaderboard->isNotEmpty())
                    <ul class="flex flex-col gap-3">
                        @foreach ($leaderboard as $index => $tech)
                            <li
                                class="flex items-center justify-between rounded-lg bg-zinc-50 p-3 dark:bg-dark-secondary">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="{{ $index === 0 ? 'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-500' : 'bg-zinc-200 text-zinc-500 dark:bg-zinc-700 dark:text-zinc-400' }} flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-xs font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="line-clamp-1 inline-flex items-center gap-1.5 text-sm font-bold text-zinc-800 dark:text-white">
                                            {{ $tech->pegawai->full_name ?? 'Teknisi N/A' }}
                                            @if ($tech->pegawai)
                                                <x-dashboard.badge-inactive :is_active="$tech->pegawai->userRelasi?->is_active ?? true" />
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div
                                    class="shrink-0 rounded bg-amber-100 px-2 py-1 text-xs font-bold text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                    {{ number_format($tech->total_points, 0, ',', '.') }} pts
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex h-full flex-col items-center justify-center py-6 text-center">
                        <x-icons.award class="mb-2 h-8 w-8 text-zinc-300 dark:text-zinc-600" />
                        <span class="text-xs font-medium italic text-zinc-400 dark:text-zinc-500">Belum ada poin yang
                            terkumpul</span>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
