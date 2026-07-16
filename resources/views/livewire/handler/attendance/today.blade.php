{{-- Goal: Display today's check-in and check-out grids with unified date and role filters, Livewire: Handler\Attendance\Today, Alpine: - --}}
<div class="grid w-full grid-cols-1 gap-y-4">

    {{-- Unified Filter Bar --}}
    <div class="flex flex-col gap-4 rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary sm:flex-row sm:items-center sm:justify-between md:p-6"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <div>
            <h2 class="text-lg font-black tracking-tight text-zinc-900 dark:text-white">Filter Histori Kehadiran</h2>
            <p class="text-xs font-bold text-zinc-500 dark:text-zinc-400">Pilih tanggal dan role untuk menyaring data
                masuk dan keluar</p>
        </div>

        <form wire:submit="applyFilter" class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
            <div class="relative w-full sm:w-52">
                <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                    <x-icons.search-alt class="h-4 w-4 text-zinc-400" />
                </div>
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari nama pegawai..."
                    class="block w-full rounded-xl border border-zinc-200 bg-white py-2.5 pl-9 pr-9 text-sm font-medium text-zinc-900 transition-all placeholder:font-normal placeholder:text-zinc-400 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                @if ($search)
                    <button type="button" wire:click="$set('search', '')"
                        class="absolute inset-y-0 right-3 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <x-icons.close class="h-3.5 w-3.5" />
                    </button>
                @endif
            </div>
            <div class="w-full sm:w-44">
                <x-input.select wire:model="role" :labels="false" id="role-filter" name="role" :defaultOption="'Semua Role'"
                    placeholder="Pilih Role" :options="$this->roleOptions" />
            </div>
            <div class="w-full sm:w-44">
                <input type="date" wire:model="date"
                    class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-red-500 focus:ring-red-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
            </div>
            <div class="w-full sm:w-auto">
                <x-button.primary type="submit" class="w-full justify-center">
                    <x-slot name="icon">
                        <span wire:loading.remove wire:target="applyFilter">
                            <x-icons.search-alt class="h-4 w-4" />
                        </span>
                        <span wire:loading wire:target="applyFilter">
                            <x-icons.loading class="h-4 w-4 !text-white" />
                        </span>
                    </x-slot>
                    <span wire:loading.remove wire:target="applyFilter">Filter</span>
                    <span wire:loading wire:target="applyFilter">Memproses...</span>
                </x-button.primary>
            </div>
        </form>
    </div>

    <div class="flex flex-col gap-4">
        {{-- Absensi Masuk --}}
        <div class="flex w-full flex-col gap-4 rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="flex items-center justify-between border-b border-zinc-200 pb-5 dark:border-zinc-800/50">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-lg shadow-emerald-500/20">
                        <x-icons.arrow-left-bracket class="h-5 w-5" />
                    </div>
                    <div>
                        <h2 class="text-xl font-black tracking-tight text-zinc-900 dark:text-white">Absensi Masuk</h2>
                        <p class="text-xs font-bold text-zinc-500 dark:text-zinc-400">Daftar rekam kehadiran masuk staf
                        </p>
                    </div>
                </div>
                <div
                    class="flex items-center gap-2 rounded-2xl border border-emerald-100 bg-emerald-50/50 px-4 py-2 text-xs font-bold text-emerald-700 dark:border-emerald-900/30 dark:bg-emerald-950/20 dark:text-emerald-400">
                    <x-icons.check-circle class="h-3.5 w-3.5" />
                    <span>{{ $ins->total() }} Hadir</span>
                </div>
            </div>

            {{-- Check-in Grid --}}
            <div class="flex w-full flex-col" wire:poll.300s>
                <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
                    @forelse ($ins as $row)
                        <x-attendance.card :row="$row" type="in" />
                    @empty
                        <div
                            class="col-span-full flex flex-col items-center justify-center rounded-lg border border-dashed border-zinc-200 bg-zinc-50/30 px-6 py-12 text-center dark:border-zinc-800 dark:bg-zinc-900/20">
                            <div
                                class="mb-3 flex h-12 w-12 items-center justify-center rounded-lg bg-zinc-100 text-zinc-400 dark:bg-zinc-800">
                                <x-icons.question-circle class="h-6 w-6" />
                            </div>
                            <p class="text-base font-bold text-zinc-900 dark:text-white">Belum Ada Data</p>
                            <p class="mt-1 max-w-xs text-sm leading-relaxed text-zinc-500 dark:text-zinc-400">
                                Tidak ada rekam kehadiran masuk untuk tanggal ini.
                            </p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-2">
                    {{ $ins->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>

        {{-- Absensi Keluar --}}
        <div class="flex w-full flex-col gap-4 rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary md:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="flex items-center justify-between border-b border-zinc-200 pb-5 dark:border-zinc-800/50">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-600 text-white shadow-lg shadow-red-500/20">
                        <x-icons.arrow-right-bracket class="h-5 w-5" />
                    </div>
                    <div>
                        <h2 class="text-xl font-black tracking-tight text-zinc-900 dark:text-white">Absensi Keluar</h2>
                        <p class="text-xs font-bold text-zinc-500 dark:text-zinc-400">Daftar rekam kehadiran keluar staf
                        </p>
                    </div>
                </div>
                <div
                    class="flex items-center gap-2 rounded-2xl border border-red-100 bg-red-50/50 px-4 py-2 text-xs font-bold text-red-700 dark:border-red-900/30 dark:bg-red-950/20 dark:text-red-400">
                    <x-icons.minus-circle class="h-3.5 w-3.5" />
                    <span>{{ $outs->total() }} Keluar</span>
                </div>
            </div>

            {{-- Check-out Grid --}}
            <div class="flex w-full flex-col" wire:poll.300s>
                <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
                    @forelse ($outs as $row)
                        <x-attendance.card :row="$row" type="out" />
                    @empty
                        <div
                            class="col-span-full flex flex-col items-center justify-center rounded-lg border border-dashed border-zinc-200 bg-zinc-50/30 px-6 py-12 text-center dark:border-zinc-800 dark:bg-zinc-900/20">
                            <div
                                class="mb-3 flex h-12 w-12 items-center justify-center rounded-lg bg-zinc-100 text-zinc-400 dark:bg-zinc-800">
                                <x-icons.question-circle class="h-6 w-6" />
                            </div>
                            <p class="text-base font-bold text-zinc-900 dark:text-white">Belum Ada Data</p>
                            <p class="mt-1 max-w-xs text-sm leading-relaxed text-zinc-500 dark:text-zinc-400">
                                Tidak ada rekam kehadiran keluar untuk tanggal ini.
                            </p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-2">
                    {{ $outs->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    @include('livewire.handler.attendance.partials.detail-modal')
</div>
