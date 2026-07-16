<div class="w-full space-y-4">
    {{-- informasi project --}}
    <div class="w-full rounded-xl border border-zinc-200 p-4 shadow dark:border-zinc-800 dark:shadow-none lg:p-6"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        {{-- HEADER --}}
        <div class="relative flex items-center gap-3 border-b border-zinc-200 pb-4 dark:border-zinc-800">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shadow-sm dark:bg-blue-900/30 dark:text-blue-400">
                <x-icons.info-circle class="h-5 w-5" />
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <h2 class="text-lg font-bold tracking-tight text-zinc-900 dark:text-white lg:text-xl">
                    Informasi Project
                </h2>
                <span
                    class="bg-{{ $assignment->status == 'in_progress' ? 'yellow' : 'green' }}-50 text-{{ $assignment->status == 'in_progress' ? 'yellow' : 'green' }}-600 ring-{{ $assignment->status == 'in_progress' ? 'yellow' : 'green' }}-500/20 dark:bg-{{ $assignment->status == 'in_progress' ? 'yellow' : 'green' }}-900/20 dark:text-{{ $assignment->status == 'in_progress' ? 'yellow' : 'green' }}-400 dark:ring-{{ $assignment->status == 'in_progress' ? 'yellow' : 'green' }}-500/30 rounded-lg px-2.5 py-1 text-xs font-bold ring-1 ring-inset">
                    {{ ucwords(str_replace('_', ' ', $assignment->status)) }}
                </span>
            </div>

            @if ($assignment->status === 'completed')
                {{-- signature dan ekspor  --}}
                <x-button.link
                    class="absolute right-0 top-0 bg-green-50 ring-1 ring-green-600 hover:bg-green-100 dark:bg-green-900/30 dark:text-green-400 dark:ring-green-500/30 dark:hover:bg-green-900/50"
                    id="signature-btn" type="button"
                    href="{{ route('report.general.customer-assignment', ['id' => $assignment->id]) }}" wire:navigate>
                    <x-icons.pen-nib class="h-4 w-4" />
                </x-button.link>
            @endif
        </div>

        {{-- CONTENT --}}
        <div class="grid grid-cols-1 gap-4 pt-4 sm:grid-cols-2 lg:grid-cols-4">
            {{-- Customer Name --}}
            <div class="flex flex-col sm:col-span-2 lg:col-span-4">
                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Perusahaan</dt>
                <dd class="text-sm font-semibold text-zinc-900 dark:text-white">
                    {{ $assignment->project->customer_name ?? '-' }}</dd>
            </div>

            {{-- PROJECT NAME --}}
            <div class="flex flex-col sm:col-span-2 lg:col-span-4">
                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Nama Project</dt>
                <dd class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $assignment->project->project_name }}
                </dd>
            </div>

            {{-- DESCRIPTION --}}
            <div class="flex flex-col sm:col-span-2 lg:col-span-4">
                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Deskripsi Project</dt>
                <dd class="mt-1 text-sm text-zinc-800 dark:text-zinc-200">{{ $assignment->project->description }}</dd>
            </div>

            {{-- START DATE --}}
            <div class="flex flex-col">
                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tanggal Mulai</dt>
                <dd class="text-sm font-semibold text-zinc-900 dark:text-white">
                    {{ \Carbon\Carbon::parse($assignment->project->start_date)->isoFormat('DD MMM YYYY') }}</dd>
            </div>

            {{-- END DATE --}}
            <div class="flex flex-col">
                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tanggal Selesai</dt>
                <dd class="text-sm font-semibold text-zinc-900 dark:text-white">
                    {{ \Carbon\Carbon::parse($assignment->project->end_date)->isoFormat('DD MMM YYYY') }}</dd>
            </div>

            {{-- DEADLINE --}}
            <div class="flex flex-col">
                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Deadline</dt>
                <dd class="flex flex-col gap-1 sm:flex-row sm:items-center sm:gap-2">
                    <span
                        class="text-sm font-semibold text-zinc-900 dark:text-white">{{ \Carbon\Carbon::parse($assignment->project->deadline)->isoFormat('DD MMM YYYY') }}</span>

                    @php
                        $sisa = $this->getSisaHari();
                    @endphp

                    <span @class([
                        'rounded-lg px-2 py-0.5 text-[10px] font-bold w-fit ring-1 ring-inset',
                        'bg-red-50 text-red-600 ring-red-500/20 dark:bg-red-900/20 dark:text-red-400 dark:ring-red-500/30' =>
                            $sisa['type'] === 'danger',
                        'bg-yellow-50 text-yellow-600 ring-yellow-500/20 dark:bg-yellow-900/20 dark:text-yellow-400 dark:ring-yellow-500/30' =>
                            $sisa['type'] === 'warning',
                        'bg-green-50 text-green-600 ring-green-500/20 dark:bg-green-900/20 dark:text-green-400 dark:ring-green-500/30' =>
                            $sisa['type'] === 'success',
                    ])>
                        {{ $sisa['label'] }}
                    </span>
                </dd>

                @if (!$assignment->project->extend_request && $assignment->status != 'completed')
                    @can('laporan-harian-extend')
                        <x-button.primary class="mt-2 min-h-0 w-fit px-2.5 py-1 text-xs"
                            wire:click.prevent="$set('showExtendModal', true)" type="button" id="extend-report-btn">
                            Perpanjang Deadline?
                        </x-button.primary>
                    @endcan
                @endif
            </div>

            {{-- CREATED BY --}}
            <div class="flex flex-col">
                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Dibuat Oleh</dt>
                <dd class="text-sm font-semibold text-zinc-900 dark:text-white">
                    {{ $assignment->project->createdBy->name }}</dd>
            </div>

            {{-- extend request --}}
            @if ($assignment->project->extend_request)
                <div class="mt-2 rounded-xl border border-zinc-100 bg-zinc-50 p-4 dark:border-zinc-800 sm:col-span-2 lg:col-span-4"
                    x-bind:class="dynamicBg ?
                        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                    <div class="text-sm text-zinc-800 dark:text-zinc-200">
                        <p>
                            <span class="font-semibold text-zinc-900 dark:text-white">
                                {{ $assignment->project->extendRequestBy->name }}
                            </span>
                            meminta perpanjangan deadline ke tanggal
                            <span class="font-bold text-blue-600 dark:text-blue-400">
                                {{ $assignment->project->extend_to->isoFormat('DD MMMM YYYY') }}
                            </span>
                            dengan alasan:
                        </p>
                        <p class="mt-1 font-medium italic text-zinc-600 dark:text-zinc-400">
                            "{{ ucfirst($assignment->project->extend_request_notes) }}"
                        </p>
                    </div>

                    @if ($assignment->project->extend_request_status == 'pending')
                        @if ($showDenyProcessButton)
                            <div class="mt-4 border-t border-zinc-200 pt-4 dark:border-zinc-800">
                                <x-input.textarea id="extendRequestNotes" name="extendRequestNotes"
                                    wire:model="extend_request_rejected_notes" placeholder="Alasan Penolakan..."
                                    :labels="true" :textLabel="'Alasan Penolakan'" :rows="3" />
                            </div>
                        @endif

                        @can('laporan-harian-approve')
                            <div class="mt-4 flex flex-wrap gap-2">
                                {{-- tombol terima --}}
                                <x-button.success wire:show="showAcceptButton" class="text-sm"
                                    wire:click.prevent="acceptExtendRequest">
                                    Terima Permohonan
                                </x-button.success>

                                {{-- tombol tolak --}}
                                <x-button.danger wire:show="showDenyButton" class="text-sm"
                                    wire:click.prevent="rejectExtendRequest">
                                    Tolak Permohonan
                                </x-button.danger>

                                {{-- tombol proses tolak --}}
                                <x-button.danger wire:show="showDenyProcessButton" class="text-sm"
                                    wire:click.prevent="rejectExtendRequestProcess">
                                    Proses Penolakan
                                </x-button.danger>

                                {{-- tombol cancel --}}
                                <x-button.secondary wire:show="showCancelButton" class="text-sm"
                                    wire:click.prevent="handleCancelButton">
                                    Batal
                                </x-button.secondary>
                            </div>
                        @endcan
                    @else
                        <div class="mt-3 border-t border-zinc-200 pt-3 dark:border-zinc-800">
                            @if ($assignment->project->extend_request_status == 'approved')
                                <div
                                    class="flex items-start gap-2 rounded-lg bg-green-50 p-3 ring-1 ring-inset ring-green-500/20 dark:bg-green-900/20 dark:ring-green-500/30">
                                    <x-icons.check-circle
                                        class="mt-0.5 h-4 w-4 shrink-0 text-green-600 dark:text-green-400" />
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold text-green-700 dark:text-green-400">
                                            Disetujui oleh {{ $assignment->project->extendRequestValidatedBy->name }}
                                            ({{ $assignment->project->extend_request_validated_at }})
                                        </span>
                                        <span class="text-xs text-green-600 dark:text-green-500">
                                            Deadline laporan telah diperpanjang ke tanggal <span
                                                class="font-bold underline underline-offset-2">{{ $assignment->project->extend_to->isoFormat('DD MMMM YYYY') }}</span>.
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="flex items-start gap-2 rounded-lg bg-red-50 p-3 ring-1 ring-inset ring-red-500/20 dark:bg-red-900/20 dark:ring-red-500/30">
                                    <x-icons.lock-time class="mt-0.5 h-4 w-4 shrink-0 text-red-600 dark:text-red-400" />
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold text-red-700 dark:text-red-400">
                                            Ditolak oleh {{ $assignment->project->extendRequestValidatedBy->name }}
                                            ({{ $assignment->project->extend_request_validated_at }})
                                        </span>
                                        <span class="text-xs text-red-600 dark:text-red-500">
                                            Alasan penolakan: <span
                                                class="font-bold">{{ $assignment->project->extend_request_validated_notes }}</span>
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            {{-- tandai sebagai selesai --}}
            @if ($assignment->status != 'completed' && auth()->user()->can('laporan-harian-approve'))
                <div class="mt-4 border-t border-zinc-200 pt-4 dark:border-zinc-800 sm:col-span-2 lg:col-span-4"
                    id="mark-as-complete-container">
                    <x-button.success id="btn-mark-as-complete" type="button" wire:click.prevent="markAsComplete"
                        wire:confirm.prompt="Apakah anda yakin ingin menandai Laporan ini sebagai Selesai?\nJika ya, silahkan ketik SELESAI|SELESAI"
                        wire:loading.attr="disabled" wire:target="markAsComplete" class="w-full sm:w-auto">
                        <x-slot name="icon">
                            <x-icons.check-circle wire:loading.remove wire:target="markAsComplete"
                                class="icon h-5 w-5" />
                            <x-icons.loading wire:loading wire:target="markAsComplete" class="h-4 w-4 animate-spin" />
                        </x-slot>

                        <span wire:loading.remove wire:target="markAsComplete">Tandai Laporan Selesai</span>
                        <span wire:loading wire:target="markAsComplete">Memproses...</span>
                    </x-button.success>
                </div>
            @endif
        </div>
    </div>

    {{-- list report --}}
    <div class="flex flex-col gap-4">
        {{-- ACTION BAR --}}
        @can('laporan-harian-create')
            <div class="flex justify-end">
                @if (now()->lt(\Carbon\Carbon::parse($assignment->project->end_date)->endOfDay()) && $assignment->status !== 'completed')
                    <x-button.primary wire:click.prevent="add" type="button" id="add-report-btn">
                        <x-slot name="icon">
                            <x-icons.plus class="h-5 w-5" />
                        </x-slot>
                        Tambah Laporan
                    </x-button.primary>
                @endif
            </div>
        @endcan

        {{-- LIST CONTAINER --}}
        <div class="w-full rounded-xl border border-zinc-200 p-4 shadow dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <div class="mb-4 flex items-center gap-3 border-b border-zinc-200 pb-4 dark:border-zinc-800">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shadow-sm dark:bg-blue-900/30 dark:text-blue-400">
                    <x-icons.file-invoice class="h-5 w-5" />
                </div>
                <div>
                    <h2 class="text-lg font-bold tracking-tight text-zinc-900 dark:text-white lg:text-xl">
                        Daftar Aktivitas Laporan
                    </h2>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @forelse ($this->dailyReports as $index => $row)
                    <div class="relative flex flex-col gap-4 overflow-hidden rounded-xl border border-zinc-100 p-4 shadow-sm dark:border-zinc-800 dark:shadow-none"
                        x-bind:class="dynamicBg ?
                            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

                        {{-- WATERMARK --}}
                        <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center justify-center">
                            <span
                                class="text-4xl font-black uppercase tracking-widest text-zinc-900/[0.03] dark:text-white/[0.02]">
                                {{ $row->status }}
                            </span>
                        </div>

                        {{-- HEADER ROW --}}
                        <div class="z-10 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-sm font-bold text-blue-600 ring-1 ring-inset ring-blue-500/20 dark:bg-blue-900/20 dark:text-blue-400 dark:ring-blue-500/30">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-zinc-900 dark:text-white">
                                        Tanggal Laporan:
                                        {{ \Carbon\Carbon::parse($row->report_date)->isoFormat('DD MMM YYYY') }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col sm:items-end">
                                <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                    Pukul {{ \Carbon\Carbon::parse($row->submitted_at)->isoFormat('HH:mm:ss') }}
                                </span>
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ \Carbon\Carbon::parse($row->submitted_at)->isoFormat('dddd, DD MMM YYYY') }}
                                </span>
                            </div>
                        </div>

                        @php
                            $report_date = \Carbon\Carbon::parse($row->report_date)->endOfDay();
                            $end_date = \Carbon\Carbon::parse($row->assignment->project->end_date)->endOfDay();
                        @endphp

                        @if (now()->gt($end_date) || now()->gt($report_date))
                            <div
                                class="z-10 rounded-lg bg-red-50 p-3 ring-1 ring-inset ring-red-500/20 dark:bg-red-900/20 dark:ring-red-500/30">
                                <p class="text-center text-xs font-medium text-red-600 dark:text-red-400">
                                    Tidak dapat menambah aktivitas dikarenakan sudah melewati batas waktu.
                                </p>
                            </div>
                        @endif

                        {{-- FOOTER / ACTIONS --}}
                        <div
                            class="z-10 flex flex-col gap-4 border-t border-zinc-100 pt-3 dark:border-zinc-800 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <span
                                    class="rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-900/20 dark:text-blue-400 dark:ring-blue-500/30">
                                    {{ ucfirst($row->status) }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                @php
                                    if ($route == 'daily-report.daily') {
                                        $redirectRoute = route('daily-report.hourly', [
                                            'id' => $row->assignment_id,
                                            'hourly' => $row->id,
                                        ]);
                                    } elseif ($route == 'report.general.daily') {
                                        $redirectRoute = route('report.general.hourly', [
                                            'id' => $row->assignment_id,
                                            'hourly' => $row->id,
                                        ]);
                                    } else {
                                        abort(404);
                                    }
                                @endphp

                                <x-button.link
                                    class="text-sm ring-blue-600 hover:bg-blue-100 dark:bg-blue-800 dark:text-white dark:hover:bg-blue-900"
                                    id="detail-button" href="{{ $redirectRoute }}" wire:navigate>
                                    Detail Aktivitas
                                </x-button.link>

                                @can('laporan-harian-approve')
                                    <x-button.success id="summary" class="text-sm" type="button"
                                        wire:click.prevent="summary('{{ $row->id }}')" wire:loading.attr="disabled"
                                        wire:target="summary">
                                        <x-slot name="icon">
                                            <x-icons.badge-check wire:loading.remove wire:target="summary"
                                                class="icon h-4 w-4" />
                                            <x-icons.loading wire:loading wire:target="summary"
                                                class="h-4 w-4 animate-spin" />
                                        </x-slot>

                                        <span wire:loading.remove wire:target="summary">Summary</span>
                                        <span wire:loading wire:target="summary">Memuat...</span>
                                    </x-button.success>
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
                            <x-icons.calendar class="h-8 w-8 text-zinc-400" />
                            <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Staf belum membuat
                                laporan harian.</span>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="mt-4 border-t border-zinc-200 pt-4 dark:border-zinc-800">
                {{ $this->dailyReports->links() }}
            </div>
        </div>
    </div>

    {{-- summary modal --}}
    @can('laporan-harian-approve')
        <x-modal.base-modal show="showSummaryModal" title="Rekap Aktivitas"
            subtitle="{{ $showSummaryModal && $modalData ? \Carbon\Carbon::parse($modalData->report_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY') : '' }}"
            iconContainerClass="bg-emerald-600 shadow-emerald-500/20" maxWidth="2xl">
            <x-slot name="icon">
                <x-icons.badge-check class="h-5 w-5" />
            </x-slot>

            @if ($modalData)
                <div class="flex flex-col gap-3">
                    @php
                        $activities = collect($modalData->hourlyReport)
                            ->sortByDesc(fn($item) => \Carbon\Carbon::parse($item['created_at']))
                            ->values()
                            ->toArray();
                    @endphp

                    @forelse ($activities as $row)
                        <div
                            class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/50">
                            <dl class="flex items-start justify-between gap-4 py-1">
                                <dt class="shrink-0 text-xs font-medium text-zinc-500 dark:text-zinc-400">Aktivitas</dt>
                                <dd class="text-right text-sm font-semibold text-zinc-900 dark:text-white">
                                    {!! nl2br(e($row['notes'])) !!}</dd>
                            </dl>
                            <dl class="flex items-center justify-between gap-4 py-1">
                                <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Waktu</dt>
                                <dd class="text-sm font-semibold text-zinc-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($row['start_time'])->locale('id')->isoFormat('HH:mm') }}
                                    –
                                    {{ \Carbon\Carbon::parse($row['end_time'])->locale('id')->isoFormat('HH:mm') }}
                                </dd>
                            </dl>
                            <dl class="flex items-center justify-between gap-4 py-1">
                                <dt class="text-xs font-medium text-blue-500 dark:text-blue-400">Tanggal Dibuat</dt>
                                <dd class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                                    {{ \Carbon\Carbon::parse($row['created_at'])->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
                                </dd>
                            </dl>
                        </div>
                    @empty
                        <div
                            class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 py-10 dark:border-zinc-800">
                            <x-icons.question-circle class="mb-2 h-8 w-8 text-zinc-400" />
                            <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Belum ada riwayat aktivitas.
                            </p>
                        </div>
                    @endforelse
                </div>
            @endif

            @can('laporan-harian-approve')
                @if ($modalData && $modalData->status === 'submitted')
                    <x-slot name="footer">
                        <x-button.secondary @click="open = false">Tutup</x-button.secondary>
                        <x-button.success id="approve-btn" wire:click.prevent="approve"
                            wire:confirm.prompt="Apakah anda yakin ingin menyetujui laporan ini?\nKetik YA untuk mengkonfirmasi|YA"
                            type="button" wire:loading.attr="disabled" wire:target="approve">
                            <x-slot name="icon">
                                <x-icons.angle-right wire:loading.remove wire:target="approve" class="icon h-5 w-5" />
                                <x-icons.loading wire:loading wire:target="approve" class="h-4 w-4 animate-spin" />
                            </x-slot>

                            <span wire:loading.remove wire:target="approve">Approve Laporan</span>
                            <span wire:loading wire:target="approve">Memproses...</span>
                        </x-button.success>
                    </x-slot>
                @endif
            @endcan
        </x-modal.base-modal>
    @endcan

    {{-- extend deadline modal --}}
    @can('laporan-harian-extend')
        <x-modal.base-modal show="showExtendModal" title="Request Perpanjangan Deadline"
            subtitle="Ajukan perpanjangan batas waktu laporan" iconContainerClass="bg-blue-600 shadow-blue-500/20"
            maxWidth="lg">
            <x-slot name="icon">
                <x-icons.clock class="h-5 w-5" />
            </x-slot>

            <form id="form-extend-deadline" wire:submit.prevent="extendProcess" method="POST"
                class="flex flex-col gap-5">
                <div>
                    <x-input.basic id="days" name="days" wire:model="days" type="number" min="1"
                        max="20" placeholder="Mau perpanjang berapa hari?">
                        Jumlah Hari
                    </x-input.basic>
                    @error('days')
                        <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-input.textarea id="extend-reason" name="extend-reason" wire:model="extend_reason" rows="6"
                        placeholder="Apa alasan ingin perpanjang?" :labels="true" :textLabel="'Alasan Perpanjang'" />
                    @error('extend_reason')
                        <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </form>

            @can('laporan-harian-extend')
                <x-slot name="footer">
                    <x-button.secondary @click="open = false">Batal</x-button.secondary>
                    <x-button.success id="extend-submit-btn" type="submit" form="form-extend-deadline"
                        wire:loading.attr="disabled" wire:target="extendProcess">
                        <x-slot name="icon">
                            <x-icons.plus wire:loading.remove wire:target="extendProcess" class="icon h-5 w-5" />
                            <x-icons.loading wire:loading wire:target="extendProcess" class="h-4 w-4 animate-spin" />
                        </x-slot>

                        <span wire:loading.remove wire:target="extendProcess">Ajukan Permintaan</span>
                        <span wire:loading wire:target="extendProcess">Memproses...</span>
                    </x-button.success>
                </x-slot>
            @endcan
        </x-modal.base-modal>
    @endcan
</div>
