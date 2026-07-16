<div class="flex flex-col gap-4 rounded-xl border border-zinc-200 p-4 shadow dark:border-zinc-800 lg:p-6"
    x-bind:class="dynamicBg ?
        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

    <div class="flex items-center gap-3 border-b border-zinc-200 pb-4 dark:border-zinc-800">
        <div
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shadow-sm dark:bg-blue-900/30 dark:text-blue-400">
            <x-icons.users class="h-5 w-5" />
        </div>
        <div>
            <h2 class="text-lg font-bold tracking-tight text-zinc-900 dark:text-white lg:text-xl">
                Daftar staff pada project ini
            </h2>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
        @forelse ($this->assignments as $index => $row)
            <div class="flex flex-col gap-4 rounded-xl border border-zinc-100 p-4 shadow-sm dark:border-zinc-800 dark:shadow-none"
                x-bind:class="dynamicBg ?
                    'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                    'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

                <div
                    class="flex flex-col gap-3 border-b border-zinc-100 pb-3 dark:border-zinc-800 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3 text-sm font-semibold text-zinc-900 dark:text-white">
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-sm font-bold text-blue-600 ring-1 ring-inset ring-blue-500/20 dark:bg-blue-900/20 dark:text-blue-400 dark:ring-blue-500/30">
                            {{ $index + 1 }}
                        </span>
                        <div class="flex flex-col">
                            <span
                                class="text-base font-bold text-zinc-900 dark:text-white">{{ ucwords($row->project->project_name) }}</span>
                            <span
                                class="text-xs font-medium text-zinc-500 dark:text-zinc-400">[{{ $row->project->spk->customer['nama_perusahaan'] }}]</span>
                        </div>
                    </div>
                    <div class="flex flex-col sm:items-end">
                        <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                            Pukul {{ \Carbon\Carbon::parse($row->assign_at)->isoFormat('HH:mm:ss') }}
                        </span>
                        <span class="text-xs text-zinc-500 dark:text-zinc-400">
                            {{ \Carbon\Carbon::parse($row->assign_at)->isoFormat('dddd, DD MMM YYYY') }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4">
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tipe Laporan</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ ucfirst($row->laporan_type) }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Nomor VT</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $row->nomor_vt }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Nama Staf</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">[{{ $row->assignTo->kode_pegawai }}]
                            {{ $row->assignTo->name }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Deadline</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($row->project->start_date)->isoFormat('DD MMM YYYY') }} s/d
                            {{ \Carbon\Carbon::parse($row->project->end_date)->isoFormat('DD MMM YYYY') }}
                        </span>
                    </div>
                </div>

                <div
                    class="flex flex-col gap-4 border-t border-zinc-100 pt-3 dark:border-zinc-800 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <span
                            class="rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-900/20 dark:text-blue-400 dark:ring-blue-500/30">
                            {{ ucfirst($row->status) }}
                        </span>
                    </div>

                    <div class="flex gap-2">
                        <x-button.link
                            class="ring-blue-600 hover:bg-blue-100 dark:bg-blue-800 dark:text-white dark:hover:bg-blue-900"
                            id="detail-button" href="{{ route('daily-report.daily', ['id' => $row->id]) }}"
                            wire:navigate>
                            Detail
                        </x-button.link>
                        @can('laporan-harian-spk-unassign')
                            <x-button.danger id="unassign-button" wire:click="unassign('{{ $row->id }}')"
                                wire:confirm.prompt="Anda yakin ingin menghapus staf ini dari projek?\nKetik YA jika ingin menghapus|YA">
                                Unassign
                            </x-button.danger>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-zinc-100 bg-zinc-50 p-6 text-center shadow-sm dark:border-zinc-800 dark:shadow-none"
                x-bind:class="dynamicBg ?
                    'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                    'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                <div class="flex flex-col items-center justify-center gap-2">
                    <x-icons.users class="h-8 w-8 text-zinc-400" />
                    <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Belum ada staf yang
                        diassign.</span>
                </div>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="border-t border-zinc-200 pt-4 dark:border-zinc-800">
        {{ $this->assignments->links() }}
    </div>
</div>
