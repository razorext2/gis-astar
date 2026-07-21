{{-- Goal: Reusable detail card for leave request information, Deps: LeaveRequest --}}
@props(['request', 'showApprovalRole' => false])

<div class="flex flex-col gap-4">
    {{-- Applicant Info Card --}}
    <div class="overflow-hidden rounded-xl border border-zinc-200 shadow-sm dark:border-zinc-800"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <div class="dark: bg-zinc-50/50 p-4"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <h2 class="flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-zinc-500">
                <x-icons.user-circle class="h-4 w-4" />
                Informasi Pemohon
            </h2>
        </div>
        <div class="p-6">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
                <div
                    class="flex h-20 w-20 shrink-0 items-center justify-center rounded-xl bg-red-100 text-3xl font-black text-red-600 dark:bg-red-900/30 dark:text-red-400">
                    {{ collect(explode(' ', $request->user->name))->map(fn($n) => Str::substr($n, 0, 1))->take(2)->implode('') }}
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">{{ $request->user->name }}</h3>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-zinc-500">
                        <span class="flex items-center gap-1.5">
                            <span
                                class="font-mono font-bold text-zinc-700 dark:text-zinc-300">{{ $request->user->kode_pegawai ? '(' . $request->user->kode_pegawai . ')' : '' }}</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <x-icons.briefcase class="h-4 w-4" />
                            {{ $request->user->pegawai->jabatanRelasi->nama_jabatan ?? '-' }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <x-icons.landmark class="h-4 w-4" />
                            {{ $request->user->pegawai->jabatanRelasi->divisionRelasi->nama_divisi ?? '-' }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <x-icons.map-pin class="h-4 w-4" />
                            {{ $request->user->pegawai->jabatanRelasi->placementRelasi->penempatan ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Leave Info Card --}}
    <div class="rounded-xl border border-zinc-200 p-6 shadow-sm dark:border-zinc-800"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <div class="mb-6 flex items-center justify-between border-b border-zinc-100 pb-4 dark:border-white/5">
            <div class="flex items-center gap-3">
                <div class="h-10 w-1 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]"></div>
                <div>
                    <h2 class="text-lg font-bold text-zinc-800 dark:text-white">Detail Pengajuan</h2>

                    <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                        {{ $request->user->pegawai->jabatanRelasi->nama_jabatan ?? 'Staf' }}
                        <span class="mx-1 text-zinc-300">•</span>
                        Penanggung Jawab:
                        @if ($request->user->pegawai->jabatanRelasi?->supervisors->isNotEmpty())
                            {{ $request->user->pegawai->jabatanRelasi->supervisors->pluck('name')->implode(', ') }}
                        @else
                            <a href="{{ Route::has('jabatan.edit') && isset($request->user->pegawai->jabatanRelasi->id) ? route('jabatan.edit', $request->user->pegawai->jabatanRelasi->id) : '#' }}"
                                class="font-black italic text-red-500 hover:underline">
                                (Atasan belum diatur)
                            </a>
                        @endif
                    </p>
                </div>

                <hr class="my-2 border-zinc-200 dark:border-zinc-800">
            </div>

            @if ($showApprovalRole && isset($request->approval_role_label))
                <div class="flex flex-col items-end">
                    <span
                        class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-[10px] font-black uppercase tracking-tighter text-red-700 dark:bg-red-900/30 dark:text-red-400">
                        {{ $request->approval_role_label }}
                    </span>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
            <div class="flex flex-col gap-4">
                <div class="space-y-1">
                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Tipe Cuti</p>
                    <p class="text-lg font-bold text-zinc-900 dark:text-white">
                        {{ $request->leaveType->name ?? '-' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Waktu Pelaksanaan</p>
                    <div class="flex items-center gap-3">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Dari</span>
                            <span
                                class="font-bold text-zinc-900 dark:text-white">{{ $request->start_date->format('d M Y') }}</span>
                        </div>
                        <x-icons.arrow-right class="h-4 w-4 text-zinc-300" />
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Sampai</span>
                            <span
                                class="font-bold text-zinc-900 dark:text-white">{{ $request->end_date->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-4">
                <div class="space-y-1">
                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Total Durasi</p>
                    <p class="text-3xl font-black text-red-600 dark:text-red-500">
                        {{ $request->total_days }} <span class="text-sm font-bold uppercase tracking-tight">Hari
                            Kerja</span>
                    </p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Personel Backup</p>
                    <div class="flex items-center gap-2">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-xl bg-zinc-100 text-xs font-bold dark:bg-zinc-800">
                            {{ Str::substr($request->backupPerson->name ?? '?', 0, 1) }}
                        </div>
                        <span
                            class="font-bold text-zinc-900 dark:text-white">{{ $request->backupPerson->name ?? 'Tidak Ada' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 space-y-2">
            <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Alasan / Keperluan</p>
            <div class="dark: rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 text-zinc-700 dark:border-white/5 dark:text-zinc-300"
                x-bind:class="dynamicBg ?
                    'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                    'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                @if (strip_tags($request->reason) === $request->reason)
                    <div class="whitespace-pre-line">
                        {{ $request->reason }}
                    </div>
                @else
                    <div class="prose prose-sm dark:prose-invert max-w-none">
                        {!! $request->reason !!}
                    </div>
                @endif
            </div>
        </div>

        {{-- Attachments --}}
        @if (isset($request->attachments) && count($request->attachments) > 0)
            <div class="mt-8 space-y-2">
                <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Lampiran Dokumen</p>
                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                    @foreach ($request->attachments as $path)
                        <a href="{{ Route::has('file.show') ? route('file.show', ['path' => $path]) : '#' }}" target="_blank"
                            class="group flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-zinc-200 p-3 transition-colors hover:border-red-500 dark:border-zinc-800">
                            <div class="flex min-w-0 items-center gap-3">
                                <x-icons.paper-clip class="h-5 w-5 shrink-0 text-gray-400 group-hover:text-red-500" />
                                <span
                                    class="truncate text-sm font-medium text-gray-600 dark:text-gray-400">{{ basename($path) }}</span>
                            </div>
                            <x-icons.chevron-right class="h-4 w-4 shrink-0 text-gray-300" />
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-8 flex justify-end border-t border-zinc-100 pt-6 dark:border-white/5">
            <x-button.primary id="summary-button" wire:click="summary" type="button" wire:loading.attr="disabled"
                wire:target="summary">
                <x-slot name="icon">
                    <x-icons.file-invoice wire:loading.remove wire:target="summary" class="h-5 w-5" />
                    <x-icons.loading wire:loading wire:target="summary" class="h-4 w-4 animate-spin" />
                </x-slot>

                <span wire:loading.remove wire:target="summary">Preview PDF</span>
                <span wire:loading wire:target="summary">Memuat...</span>
            </x-button.primary>
        </div>

        <x-modal.base-modal show="showSummary" title="Leave Request Summary" subtitle="Preview Dokumen"
            iconContainerClass="bg-blue-600 shadow-blue-500/20" maxWidth="7xl">
            <x-slot name="icon">
                <x-icons.file-invoice class="h-5 w-5" />
            </x-slot>

            <div class="-m-6 h-[70vh]" x-data="{ pdfUrl: '' }" x-on:show-pdf-modal.window="pdfUrl = $event.detail.url">
                <template x-if="pdfUrl">
                    <iframe x-bind:src="pdfUrl" class="h-full w-full" title="Leave Request Summary PDF"
                        frameborder="0"></iframe>
                </template>
            </div>
        </x-modal.base-modal>
    </div>
</div>
