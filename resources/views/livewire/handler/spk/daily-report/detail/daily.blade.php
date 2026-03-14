<div class="w-full">

    {{-- informasi project --}}
    <div
        class="mb-2 w-full rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700 lg:mb-4">

        {{-- HEADER --}}
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                Informasi Project
            </h3>
        </div>

        {{-- CONTENT --}}
        <div class="grid grid-cols-1 gap-2 p-2 lg:grid-cols-2 lg:gap-4 lg:p-4">

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
                </dd>
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
                @if (now()->lt(\Carbon\Carbon::parse($assignment->project->end_date)->endOfDay()))
                    <x-button.success wire:click="add" type="button" id="add-report-btn">
                        Tambah Laporan
                    </x-button.success>
                @endif
            @endcan
        </div>

        {{-- LIST CONTAINER --}}
        <div class="w-full rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
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

                                <x-button.success id="summary" class="text-sm" type="button"
                                    wire:click="summary('{{ $row->id }}')">
                                    <span wire:loading.remove wire:target="summary">Summary</span>
                                    <span wire:loading wire:target="summary">Memuat...</span>
                                </x-button.success>

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
            <div class="border-t border-gray-200 p-2 dark:border-gray-700 lg:p-4">
                {{ $this->dailyReports->links() }}
            </div>
        </div>
    </div>

    {{-- summary modal --}}
    <div id="summary-modal" wire:show="showSummaryModal" wire:transition.duration.300ms
        class="fixed inset-0 z-[99] flex items-center justify-center bg-black bg-opacity-70 py-8">
        @if ($showSummaryModal)
            <div class="relative mx-4 my-6 flex w-full flex-col gap-1 overflow-y-auto rounded-xl bg-white p-4 shadow-2xl dark:bg-dark-primary md:w-1/2 md:gap-2 lg:p-6"
                style="max-height: calc(100vh - 6rem);">

                <button class="absolute right-2 top-2" type="button" wire:click="$set('showSummaryModal', false)">
                    <x-icons.close class="h-6 w-6 text-red-600 hover:text-red-800" />
                </button>

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
                            class="mb-2 rounded-lg border border-gray-100 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800 sm:space-y-2 lg:mb-4">

                            <dl class="items-center justify-between gap-4 sm:flex">
                                <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Aktivitas</dt>
                                <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                    {{ ucwords($row['activity']) }}
                                </dd>
                            </dl>

                            <dl class="items-center justify-between gap-4 sm:flex">
                                <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Waktu</dt>
                                <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                    {{ \Carbon\Carbon::parse($row['start_time'])->locale('id')->isoFormat('HH:mm:ss') }}
                                    -
                                    {{ \Carbon\Carbon::parse($row['end_time'])->locale('id')->isoFormat('HH:mm:ss') }}
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
                            class="mb-2 rounded-lg border border-gray-100 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800 sm:space-y-2 lg:mb-4">
                            <p class="font-semibold text-gray-800 dark:text-white">Belum ada riwayat aktivitas.</p>
                        </div>
                    @endforelse
                </div>

                @can('laporan-harian-validate')
                    <div class="mx-auto flex w-fit justify-end gap-x-2">
                        @if ($modalData->status === 'submitted')
                            <x-button.success id="delivery-btn-done" wire:click="approve"
                                wire:confirm.prompt="Apakah anda yakin ingin menyetujui laporan ini?\nKetik YA untuk mengkonfirmasi|YA"
                                type="button">
                                Approve Laporan
                            </x-button.success>

                            {{--
                            <x-button.primary id="continue-btn-done" wire:click="continueAfterDelayConfirmation"
                                type="button">
                                Pengiriman Dilanjutkan?
                            </x-button.primary> --}}
                        @endif
                    </div>
                @endcan

            </div>
        @endif
    </div>
</div>
