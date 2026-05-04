<div class="w-full">
    {{-- informasi project --}}
    <div
        class="mb-2 w-full rounded-xl bg-white/60 shadow-sm border border-zinc-200 backdrop-blur-md dark:bg-gray-800 dark:border-zinc-800 lg:mb-4">
        {{-- HEADER --}}
        <div class="border-b border-zinc-200 px-6 py-4 dark:border-zinc-800">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                Informasi Project <span
                    class="bg-{{ $assignment->status == 'in_progress' ? 'yellow' : 'green' }}-500 text-{{ $assignment->status == 'in_progress' ? 'yellow' : 'green' }}-100 ms-2 rounded-lg px-2 py-0.5 text-xs">
                    {{ ucwords(str_replace('_', ' ', $assignment->status)) }}
                </span>
            </h3>
        </div>

        {{-- CONTENT --}}
        <div class="relative grid grid-cols-1 gap-2 p-2 lg:grid-cols-2 lg:gap-4 lg:p-4">
            @if ($assignment->status === 'completed')
                {{-- signature dan ekspor  --}}
                <x-button.link
                    class="absolute right-2 top-2 bg-green-100 ring-1 ring-green-700 hover:bg-green-300 focus:scale-105 dark:bg-green-800 dark:text-white dark:ring-zinc-800 dark:hover:bg-green-900"
                    id="signature-btn" type="button"
                    href="{{ route('report.general.customer-assignment', ['id' => $assignment->id]) }}" wire:navigate>
                    <x-icons.pen-nib class="h-5 w-5" />
                </x-button.link>
            @endif

            {{-- Customer Name --}}
            <div class="lg:col-span-2">
                <dt class="text-sm text-gray-500 dark:text-gray-400">
                    Perusahaan
                </dt>

                <dd class="font-medium text-gray-900 dark:text-white">
                    {{ $assignment->project->customer_name ?? '-' }}
                </dd>
            </div>

            {{-- PROJECT NAME --}}
            <div class="lg:col-span-2">
                <dt class="text-sm text-gray-500 dark:text-gray-400">
                    Nama Project
                </dt>

                <dd class="font-medium text-gray-900 dark:text-white">
                    {{ $assignment->project->project_name }}
                </dd>
            </div>

            {{-- DESCRIPTION --}}
            <div class="lg:col-span-2">
                <dt class="text-sm text-gray-500 dark:text-gray-400">
                    Deskripsi Project
                </dt>

                <dd class="mt-1 text-gray-800 dark:text-gray-200">
                    {{ $assignment->project->description }}
                </dd>
            </div>

            {{-- START DATE --}}
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">
                    Tanggal Mulai
                </dt>

                <dd class="font-medium text-gray-900 dark:text-white">
                    {{ \Carbon\Carbon::parse($assignment->project->start_date)->isoFormat('DD MMMM YYYY') }}
                </dd>
            </div>

            {{-- END DATE --}}
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">
                    Tanggal Selesai
                </dt>

                <dd class="font-medium text-gray-900 dark:text-white">
                    {{ \Carbon\Carbon::parse($assignment->project->end_date)->isoFormat('DD MMMM YYYY') }}
                </dd>
            </div>

            {{-- DEADLINE --}}
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">
                    Deadline
                </dt>

                <dd class="font-medium text-gray-900 dark:text-white">
                    {{ \Carbon\Carbon::parse($assignment->project->deadline)->isoFormat('DD MMMM YYYY') }}

                    @php
                        $sisa = $this->getSisaHari();
                    @endphp

                    <span @class([
                        'text-xs px-2.5 w-fit py-1 rounded-lg',
                        'bg-red-500 text-red-100' => $sisa['type'] === 'danger',
                        'bg-yellow-500 text-yellow-800' => $sisa['type'] === 'warning',
                        'bg-green-500 text-green-800' => $sisa['type'] === 'success',
                    ])>
                        {{ $sisa['label'] }}
                    </span>
                </dd>

                @if (!$assignment->project->extend_request && $assignment->status != 'completed')
                    @can('laporan-harian-extend')
                        <x-button.primary class="mt-2 text-sm" wire:click.prevent="$set('showExtendModal', true)"
                            type="button" id="extend-report-btn">
                            Permohonan Perpanjang Deadline?
                        </x-button.primary>
                    @endcan
                @endif
            </div>

            {{-- CREATED BY --}}
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">
                    Dibuat Oleh
                </dt>

                <dd class="font-medium text-gray-900 dark:text-white">
                    {{ $assignment->project->createdBy->name }}
                </dd>
            </div>

            {{-- extend request --}}
            @if ($assignment->project->extend_request)
                <div class="col-span-2 rounded-lg bg-gray-800 p-2 border border-zinc-200 dark:border-zinc-800 lg:p-4">
                    <div class="text-gray-800 dark:text-white">
                        <p>
                            <span class="font-semibold">
                                {{ $assignment->project->extendRequestBy->name }}
                            </span>
                            meminta perpanjangan deadline ke tanggal
                            <span class="font-semibold text-green-500">
                                {{ $assignment->project->extend_to->isoFormat('DD MMMM YYYY') }}
                            </span>
                            dengan alasan:
                        </p>
                        <p>
                            {{ ucfirst($assignment->project->extend_request_notes) }}
                        </p>
                    </div>

                    @if ($assignment->project->extend_request_status == 'pending')
                        @if ($showDenyProcessButton)
                            <div class="mt-2 border-t border-t-gray-400 pt-2 dark:border-t-gray-700">
                                <x-input.textarea id="extendRequestNotes" name="extendRequestNotes"
                                    wire:model="extend_request_rejected_notes" class="mt-2"
                                    placeholder="Alasan Penolakan" :labels="true" :textLabel="'Alasan penolakan'"
                                    :rows="6" />
                            </div>
                        @endif

                        @can('laporan-harian-validate')
                            <div class="mt-2 flex gap-2">
                                {{-- tombol terima --}}
                                <x-button.success wire:show="showAcceptButton" class="text-sm"
                                    wire:click.prevent="acceptExtendRequest">
                                    Terima
                                </x-button.success>

                                {{-- tombol cancel --}}
                                <x-button.primary wire:show="showCancelButton" class="text-sm"
                                    wire:click.prevent="handleCancelButton">
                                    Cancel
                                </x-button.primary>

                                {{-- tombol tolak --}}
                                <x-button.danger wire:show="showDenyButton" class="text-sm"
                                    wire:click.prevent="rejectExtendRequest">
                                    Tolak
                                </x-button.danger>

                                {{-- tombol proses tolak --}}
                                <x-button.danger wire:show="showDenyProcessButton" class="text-sm"
                                    wire:click.prevent="rejectExtendRequestProcess">
                                    Proses Tolak
                                </x-button.danger>
                            </div>
                        @endcan
                    @else
                        <div class="mt-2 border-t border-t-gray-400 pt-2 dark:border-t-gray-700">
                            @if ($assignment->project->extend_request_status == 'approved')
                                <p class="text-sm font-medium text-green-500">
                                    {{ '[' . $assignment->project->extend_request_validated_at . '] ' . $assignment->project->extendRequestValidatedBy->name }}
                                </p>
                                <p class="text-sm text-green-500">
                                    Perpanjangan telah
                                    disetujui. Deadline laporan telah diperpanjang ke tanggal
                                    <span
                                        class="font-semibold underline underline-offset-2">{{ $assignment->project->extend_to->isoFormat('DD MMMM YYYY') }}</span>
                                </p>
                            @else
                                <p class="text-sm font-medium text-red-500">
                                    {{ '[' . $assignment->project->extend_request_validated_at . '] ' . $assignment->project->extendRequestValidatedBy->name }}
                                </p>
                                <p class="text-sm text-red-500">
                                    Perpanjangan telah
                                    ditolak dengan alasan: <span
                                        class="font-semibold underline underline-offset-2">{{ $assignment->project->extend_request_validated_notes }}</span>
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            {{-- tandai sebagai selesai --}}
            @if ($assignment->status != 'completed')
                @can('laporan-harian-validate')
                    <div id="mark-as-complete-container">
                        <x-button.success id="btn-mark-as-complete" type="button" wire:click.prevent="markAsComplete"
                            wire:confirm.prompt="Apakah anda yakin ingin menandai Laporan ini sebagai Selesai?\nJika ya, silahkan ketik SELESAI|SELESAI">
                            Tandai Selesai
                        </x-button.success>
                    </div>
                @endcan
            @endif
        </div>

    </div>

    {{-- list report --}}
    <div class="flex flex-col gap-4">
        {{-- ACTION BAR --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <x-button.link href="{{ route('report.general.index') }}"
                class="flex w-fit items-center gap-2 ring-1 ring-red-600 dark:bg-red-800 dark:text-white" wire:navigate
                id="back-button">
                <x-slot name="icon">
                    <x-icons.angle-left class="h-5 w-5 text-red-500 dark:text-white" />
                </x-slot>
                Kembali
            </x-button.link>

            @can('laporan-harian-create')
                @if (now()->lt(\Carbon\Carbon::parse($assignment->project->end_date)->endOfDay()) && $assignment->status != 'completed')
                    <x-button.success wire:click.prevent="add" type="button" id="add-report-btn">
                        Tambah Laporan
                    </x-button.success>
                @endif
            @endcan
        </div>

        {{-- LIST CONTAINER --}}
        <div class="w-full rounded-xl bg-white/60 shadow-sm border border-zinc-200 backdrop-blur-md dark:bg-gray-800 dark:border-zinc-800">
            <div class="flex flex-col divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($this->dailyReports as $index => $row)
                    <div class="relative p-2 transition hover:bg-gray-50 dark:hover:bg-gray-700/40 lg:p-4">

                        {{-- WATERMARK --}}
                        <div class="pointer-events-none absolute inset-0 flex items-center justify-center">
                            <span
                                class="text-2xl font-bold text-gray-300 opacity-30 dark:text-gray-700 md:text-2xl lg:text-6xl">
                                {{ strtoupper($row->status) }}
                            </span>
                        </div>

                        {{-- HEADER --}}
                        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">

                            {{-- TIME INFO --}}
                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                <p class="font-medium">
                                    Pukul {{ \Carbon\Carbon::parse($row->submitted_at)->isoFormat('HH:mm:ss') }}
                                </p>

                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($row->submitted_at)->isoFormat('dddd, DD MMM YYYY') }}
                                </p>
                            </div>

                            {{-- REPORT DATE --}}
                            <div class="flex flex-col lg:items-end">
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    Tanggal Laporan
                                </span>

                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($row->report_date)->isoFormat('dddd, DD MMM YYYY') }}
                                </span>
                            </div>
                        </div>

                        @php
                            $report_date = \Carbon\Carbon::parse($row->report_date)->endOfDay();
                            $end_date = \Carbon\Carbon::parse($row->assignment->project->end_date)->endOfDay();
                        @endphp

                        @if (now()->gt($end_date) || now()->gt($report_date))
                            <div class="mt-2 w-full">
                                <p
                                    class="w-full bg-red-100 text-center text-xs text-red-600 dark:bg-transparent dark:text-red-500 md:text-sm">
                                    Tidak dapat menambah aktivitas dikarenakan sudah melewati batas waktu.
                                </p>
                            </div>
                        @endif

                        {{-- FOOTER --}}
                        <div class="mt-2 flex items-center justify-between">
                            {{-- STATUS BADGE --}}
                            <span
                                class="inline-flex items-center rounded-md bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900 dark:text-blue-200">
                                {{ ucfirst($row->status) }}
                            </span>

                            {{-- ACTION --}}
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

                                @can('laporan-harian-validate')
                                    <x-button.success id="summary" class="text-sm" type="button"
                                        wire:click.prevent="summary('{{ $row->id }}')">
                                        <span wire:loading.remove wire:target="summary">Summary</span>
                                        <span wire:loading wire:target="summary">Memuat...</span>
                                    </x-button.success>
                                @endcan

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center p-10 text-center">
                        <div class="text-sm text-gray-400">
                            Staf belum membuat laporan harian.
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="border-t border-zinc-200 p-2 dark:border-zinc-800 lg:p-4">
                {{ $this->dailyReports->links() }}
            </div>
        </div>
    </div>

    {{-- summary modal --}}
    @can('laporan-harian-validate')
        <div id="summary-modal" wire:show="showSummaryModal" wire:transition.duration.300ms
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-70 py-8">
            @if ($showSummaryModal)
                <div class="relative mx-4 my-6 flex w-full flex-col gap-1 overflow-y-auto rounded-xl bg-white p-4 shadow-2xl dark:bg-dark-primary md:w-1/2 md:gap-2 lg:p-6"
                    style="max-height: calc(100vh - 6rem);">

                    <x-button.secondary class="absolute right-2 top-2 !p-1 !bg-transparent ring-0 hover:!bg-gray-100 dark:hover:!bg-gray-800" type="button"
                        wire:click.prevent="$set('showSummaryModal', false)">
                        <x-slot name="icon">
                            <x-icons.close class="h-6 w-6 text-red-600 hover:text-red-800" />
                        </x-slot>
                    </x-button.secondary>

                    <h2
                        class="mb-2 flex items-center gap-x-2 text-lg font-semibold text-gray-900 dark:text-white lg:text-xl">
                        Rekap Aktivitas:
                        {{ \Carbon\Carbon::parse($modalData->report_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}
                    </h2>

                    <div class="h-96 overflow-auto">
                        @php
                            $activities = collect($modalData->hourlyReport)
                                ->sortByDesc(function ($item) {
                                    return Carbon\Carbon::parse($item['created_at']);
                                })
                                ->values()
                                ->toArray();
                        @endphp

                        @forelse($activities as $row)
                            <div
                                class="mb-2 rounded-lg border border-zinc-200 bg-gray-50 p-4 dark:border-zinc-800 dark:bg-gray-800 sm:space-y-2 lg:mb-4">

                                <dl class="items-start justify-between gap-4 sm:flex">
                                    <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">
                                        Aktivitas</dt>
                                    <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                        {!! nl2br($row['notes']) !!}
                                    </dd>
                                </dl>

                                <dl class="items-center justify-between gap-4 sm:flex">
                                    <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Waktu</dt>
                                    <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                        {{ \Carbon\Carbon::parse($row['start_time'])->locale('id')->isoFormat('HH:mm') }}
                                        -
                                        {{ \Carbon\Carbon::parse($row['end_time'])->locale('id')->isoFormat('HH:mm') }}
                                    </dd>
                                </dl>
                                <dl class="items-center justify-between gap-4 sm:flex">
                                    <dt class="mb-1 font-normal text-blue-500 dark:text-blue-400 sm:mb-0">
                                        Tanggal Dibuat
                                    </dt>
                                    <dd class="font-medium text-blue-500 dark:text-blue-400 sm:text-end">
                                        {{ \Carbon\Carbon::parse($row['created_at'])->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
                                    </dd>
                                </dl>

                            </div>
                        @empty
                            <div
                                class="mb-2 rounded-lg border border-zinc-200 bg-gray-50 p-4 dark:border-zinc-800 dark:bg-gray-800 sm:space-y-2 lg:mb-4">
                                <p class="font-semibold text-gray-800 dark:text-white">Belum ada riwayat aktivitas.</p>
                            </div>
                        @endforelse
                    </div>

                    @can('laporan-harian-validate')
                        <div class="mx-auto flex w-fit justify-end gap-x-2">
                            @if ($modalData->status === 'submitted')
                                <x-button.success id="delivery-btn-done" wire:click.prevent="approve"
                                    wire:confirm.prompt="Apakah anda yakin ingin menyetujui laporan ini?\nKetik YA untuk mengkonfirmasi|YA"
                                    type="button">
                                    Approve Laporan
                                </x-button.success>
                            @endif
                        </div>
                    @endcan

                </div>
            @endif
        </div>
    @endcan

    {{-- extend deadline modal --}}
    @can('laporan-harian-extend')
        <div id="extend-modal" wire:show="showExtendModal" wire:transition.duration.300ms
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-70 py-8">
            @if ($showExtendModal)
                <div class="relative mx-4 my-6 flex w-full flex-col gap-1 overflow-y-auto rounded-xl bg-white p-4 shadow-2xl dark:bg-dark-primary md:w-1/3 md:gap-2 lg:p-6"
                    style="max-height: calc(100vh - 6rem);">

                    <x-button.secondary class="absolute right-2 top-2 !p-1 !bg-transparent ring-0 hover:!bg-gray-100 dark:hover:!bg-gray-800" type="button"
                        wire:click.prevent="$set('showExtendModal', false)">
                        <x-slot name="icon">
                            <x-icons.close class="h-6 w-6 text-red-600 hover:text-red-800" />
                        </x-slot>
                    </x-button.secondary>

                    <h2
                        class="mb-2 flex items-center gap-x-2 text-lg font-semibold text-gray-900 dark:text-white lg:text-xl">
                        Request Perpanjangan Deadline
                    </h2>

                    <form wire:submit.prevent="extendProcess" method="POST">
                        <div class="flex h-96 flex-col gap-2 overflow-auto">
                            <div class="h-fit">
                                <x-input.basic id="days" name="days" wire:model="days" type="number"
                                    min="1" max="20" placeholder="Mau perpanjang berapa hari?">
                                    Jumlah Hari
                                </x-input.basic>

                                @error('days')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="h-fit">
                                <x-input.textarea id="extend-reason" name="extend-reason" wire:model="extend_reason"
                                    rows="10" placeholder="Apa alasan ingin perpanjang?" :labels="true"
                                    :textLabel="'Alasan Perpanjang'" />

                                @error('extend_reason')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @can('laporan-harian-extend')
                            <div class="mx-auto flex w-fit justify-end gap-x-2">
                                <x-button.success id="delivery-btn-done" type="submit">
                                    <span wire:loading.remove wire:target="extendProcess"> Ajukan Permintaan </span>
                                    <span wire:loading wire:target="extendProcess"> Memproses... </span>
                                </x-button.success>
                            </div>
                        @endcan
                    </form>

                </div>
            @endif
        </div>
    @endcan
</div>
