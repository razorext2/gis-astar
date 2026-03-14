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
                    <div class="p-2 transition hover:bg-gray-50 dark:hover:bg-gray-700/40 lg:p-4">

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
</div>
