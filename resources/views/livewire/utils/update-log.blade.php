<section>
    {{-- Trigger Button --}}
    <x-button.warning
        class="group w-full justify-start gap-4 rounded-xl p-4"
        type="button" wire:click="$set('showLogUpdateModal', true)">
        <x-slot name="icon">
            <div
                class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/20 text-white shadow-sm transition-transform group-hover:scale-110">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </x-slot>

        <div class="flex flex-col">
            <span class="text-sm font-medium text-white">View Update Log</span>
        </div>
    </x-button.warning>

    @teleport('body')
        {{-- Custom Modal --}}
        <div id="log-modal" x-data="{ show: @entangle('showLogUpdateModal') }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-950/65 p-4 backdrop-blur-sm"
            @click.self="show = false">

            <div x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="relative flex w-full max-w-2xl flex-col rounded-xl bg-white/60 shadow-2xl border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:border-zinc-800"
                style="max-height: 85vh;">

                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-zinc-200 p-6 dark:border-zinc-800">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-600 text-white shadow-lg shadow-red-500/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-black tracking-tight text-zinc-900 dark:text-white">Update Log</h2>
                            <div class="flex flex-col gap-0.5">
                                <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                    Menampilkan 10 perubahan sistem terakhir
                                </p>
                                @php
                                    $stats = $this->repositoryStats();
                                    $firstCommit = $stats['first_commit_date']
                                        ? \Carbon\Carbon::parse($stats['first_commit_date'])
                                            ->locale('id')
                                            ->isoFormat('D MMMM YYYY')
                                        : null;
                                @endphp
                                @if ($stats['total_commits'] > 0)
                                    <p
                                        class="text-[10px] font-bold uppercase tracking-widest text-red-600 dark:text-red-400">
                                        Total {{ number_format($stats['total_commits'], 0, ',', '.') }} Commit
                                        @if ($firstCommit)
                                            • Sejak {{ $firstCommit }}
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <x-button.secondary @click="show = false"
                        class="!rounded-full !bg-transparent !p-2 text-zinc-400 !shadow-none ring-0 transition-colors hover:!bg-zinc-100 hover:text-zinc-900 dark:hover:!bg-zinc-800 dark:hover:text-white">
                        <x-icons.close class="h-6 w-6" />
                    </x-button.secondary>
                </div>

                {{-- Timeline Content --}}
                <div
                    class="scrollbar-thin scrollbar-track-transparent scrollbar-thumb-zinc-300 dark:scrollbar-thumb-zinc-700 flex-1 overflow-y-auto p-6">
                    <div class="relative border-l-2 border-zinc-200 pl-8 dark:border-zinc-800">
                        @foreach ($this->logHistories() as $row)
                            @php
                                $commit = $row['commit'];
                                $message = $commit['message'] ?? '-';
                                $name = $commit['committer']['name'] ?? '-';
                                $email = $commit['committer']['email'] ?? '-';
                                $date = \Carbon\Carbon::parse($commit['committer']['date'])
                                    ->timezone('Asia/Jakarta')
                                    ->locale('id');
                            @endphp

                            <div class="relative mb-10 last:mb-0">
                                {{-- Milestone Dot --}}
                                <div
                                    class="absolute -left-[41px] flex h-6 w-6 items-center justify-center rounded-full border-4 border-white bg-red-600 shadow-sm ring-4 ring-zinc-50 dark:border-zinc-900 dark:ring-zinc-900">
                                    <div class="h-1.5 w-1.5 rounded-full bg-white"></div>
                                </div>

                                {{-- Date Label --}}
                                <time
                                    class="mb-2 block text-xs font-bold uppercase tracking-widest text-zinc-400 dark:text-zinc-500">
                                    {{ $date->translatedFormat('d F Y • H:i') }} WIB
                                </time>

                                {{-- Commit Card --}}
                                <div
                                    class="group rounded-2xl border border-zinc-200 bg-zinc-50/50 p-5 transition-all hover:border-red-200 hover:bg-white hover:shadow-xl hover:shadow-red-500/5 dark:border-zinc-800 dark:bg-zinc-800/30 dark:hover:border-red-900/50 dark:hover:bg-zinc-800/60">
                                    <h3 class="font-bold leading-snug text-zinc-900 dark:text-white sm:text-lg">
                                        {{ $message }}
                                    </h3>

                                    {{-- File Changes Section --}}
                                    @if (!empty($row['detailed_files']))
                                        <div
                                            class="scrollbar-thin scrollbar-thumb-zinc-200 dark:scrollbar-thumb-zinc-800 mt-4 max-h-36 overflow-y-auto pr-2">
                                            <div class="flex flex-col gap-1">
                                                @foreach ($row['detailed_files'] as $file)
                                                    @php
                                                        $statusData = match ($file['status']) {
                                                            'added' => [
                                                                'color' => 'text-emerald-600 dark:text-emerald-400',
                                                                'bg' => 'bg-emerald-50 dark:bg-emerald-950/20',
                                                                'icon' => '+',
                                                            ],
                                                            'removed' => [
                                                                'color' => 'text-rose-600 dark:text-rose-400',
                                                                'bg' => 'bg-rose-50 dark:bg-rose-950/20',
                                                                'icon' => '-',
                                                            ],
                                                            'modified' => [
                                                                'color' => 'text-amber-600 dark:text-amber-400',
                                                                'bg' => 'bg-amber-50 dark:bg-amber-950/20',
                                                                'icon' => 'M',
                                                            ],
                                                            'renamed' => [
                                                                'color' => 'text-sky-600 dark:text-sky-400',
                                                                'bg' => 'bg-sky-50 dark:bg-sky-950/20',
                                                                'icon' => 'R',
                                                            ],
                                                            default => [
                                                                'color' => 'text-zinc-600 dark:text-zinc-400',
                                                                'bg' => 'bg-zinc-50 dark:bg-zinc-950/20',
                                                                'icon' => '•',
                                                            ],
                                                        };
                                                    @endphp
                                                    <div title="{{ $file['name'] }}"
                                                        class="flex items-center gap-2 rounded-lg border border-zinc-200/50 bg-white p-2 transition-all hover:border-zinc-200 dark:border-zinc-800/50 dark:bg-zinc-900/50 dark:hover:border-zinc-700">
                                                        <div
                                                            class="{{ $statusData['bg'] }} {{ $statusData['color'] }} flex h-5 w-5 shrink-0 items-center justify-center rounded-md text-[10px] font-black">
                                                            {{ $statusData['icon'] }}
                                                        </div>
                                                        <span
                                                            class="truncate text-[11px] font-medium text-zinc-600 dark:text-zinc-400">
                                                            {{ $file['name'] }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div
                                        class="mt-4 flex flex-wrap items-center gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-800/50">
                                        {{-- Committer Avatar (Placeholder Initials) --}}
                                        <div
                                            class="flex h-7 w-7 items-center justify-center rounded-lg bg-zinc-200 text-[10px] font-bold text-zinc-600 dark:bg-zinc-700 dark:text-zinc-400">
                                            {{ strtoupper(substr($name, 0, 2)) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-xs font-bold text-zinc-700 dark:text-zinc-300">{{ $name }}</span>
                                            <span
                                                class="text-[10px] text-zinc-500 dark:text-zinc-500">{{ $email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Footer --}}
                <div class="border-t border-zinc-200 bg-zinc-50/50 p-5 dark:border-zinc-800 dark:bg-zinc-950/20">
                    <x-button.secondary @click="show = false"
                        class="!w-full !rounded-xl !bg-zinc-900 !px-4 !py-3 !text-sm !font-bold !text-white !transition-all hover:!bg-zinc-800 active:scale-[0.98] dark:!bg-white dark:!text-zinc-900 dark:hover:!bg-zinc-200">
                        Selesai Membaca
                    </x-button.secondary>
                </div>
            </div>
        </div>
    @endteleport
</section>
