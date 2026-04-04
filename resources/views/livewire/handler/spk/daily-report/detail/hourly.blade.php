<div class="flex flex-col gap-2 lg:gap-4">

    @php
        if ($route === 'report.general.hourly') {
            $redirectRoute = route('report.general.daily', ['id' => $dailyReport->assignment_id]);
        } elseif ($route === 'daily-report.hourly') {
            $redirectRoute = route('daily-report.daily', ['id' => $dailyReport->assignment_id]);
        }
    @endphp

    <div>
        <x-button.link href="{{ $redirectRoute }}"
            class="flex w-fit items-center gap-2 ring-1 ring-red-600 dark:bg-red-800 dark:text-white" wire:navigate
            id="back-button">
            <x-slot name="icon">
                <x-icons.angle-left class="h-5 w-5 text-red-500 dark:text-white" />
            </x-slot>
            Kembali
        </x-button.link>
    </div>

    @can('laporan-harian-create')
        @if (
            $dailyReport->report_date == now()->format('Y-m-d') &&
                now()->lt(\Carbon\Carbon::parse($dailyReport->assignment->project->end_date)->endOfDay()) &&
                $dailyReport->assignment->status != 'completed')
            <div wire:show="showAddForm" id="accordion-packing-form" x-data="{ accordionOpen: true }">
                <button type="button"
                    class="flex w-full items-center justify-between gap-3 rounded-lg p-5 font-medium text-gray-500 ring-1 ring-gray-200 transition-all duration-300 ease-in-out hover:bg-blue-100 dark:text-gray-400 dark:ring-gray-600 dark:hover:bg-gray-800"
                    @click="accordionOpen = !accordionOpen" :class="accordionOpen ? 'rounded-b-none ring-b-0' : ''">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                        Tambah aktivitas?
                    </h3>

                    <span class="transition-all duration-300 ease-in-out" :class="accordionOpen ? 'rotate-180' : ''">
                        <x-icons.carred-down class="h-4 w-4" />
                    </span>
                </button>

                {{-- Form Tambah Aktivitas --}}
                <div x-show="accordionOpen" x-collapse x-cloak
                    class="w-full rounded-b-lg bg-white p-2 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700 lg:p-4">

                    <form wire:submit.prevent="store" class="grid grid-cols-1 gap-4 lg:grid-cols-2">

                        {{-- START TIME --}}
                        <div class="space-y-2">
                            <x-input.basic required wire:model="form.start_time" id="start_time" name="start_time"
                                type="time">
                                Waktu Mulai
                            </x-input.basic>

                            @error('form.start_time')
                                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- END TIME --}}
                        <div class="space-y-2">
                            <x-input.basic required wire:model="form.end_time" id="end_time" name="end_time"
                                type="time">
                                Waktu Selesai
                            </x-input.basic>

                            @error('form.end_time')
                                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- ACTIVITY --}}
                        <div class="col-span-1 space-y-2 lg:col-span-2">
                            <x-input.basic required type="text" id="activity" name="activity" wire:model="form.activity"
                                placeholder="Contoh: Instalasi pondasi timbangan">
                                Aktivitas
                            </x-input.basic>

                            @error('form.activity')
                                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div
                            class="col-span-2 grid w-full grid-cols-1 gap-2 rounded-lg border border-gray-200 p-2 dark:border-gray-600 lg:gap-4 lg:p-4">

                            <div x-show="$wire.docForm.new_attachments.length > 0">
                                <span class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                    Daftar Lampiran
                                </span>

                                <ul
                                    class="divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white shadow-sm dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-700">

                                    @foreach ($docForm->new_attachments as $index => $row)
                                        <li
                                            class="flex items-center gap-2 p-2 transition hover:bg-gray-50 dark:hover:bg-gray-800">
                                            <div
                                                class="w-8 text-center text-sm font-medium text-gray-600 dark:text-gray-400">
                                                {{ $index + 1 }}.
                                            </div>

                                            <div class="flex-1">
                                                <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $row['nama_file'] }}
                                                </p>
                                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $row['tipe_dokumen'] }}
                                                </p>
                                            </div>

                                            <button type="button" wire:click="removeAttachment({{ $index }})"
                                                class="text-sm font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                Hapus
                                            </button>
                                        </li>
                                    @endforeach

                                </ul>

                                @error('docForm.new_attachments.*')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                    for="attachment">Dokumentasi</label>

                                <div class="flex w-full flex-col gap-y-2" x-data="{ uploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="uploading = true"
                                    x-on:livewire-upload-finish="uploading = false"
                                    x-on:livewire-upload-cancel="uploading = false"
                                    x-on:livewire-upload-error="uploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <label for="attachment"
                                        class="flex h-36 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 transition-all duration-500 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-800">
                                        <div class="flex flex-col items-center justify-center pb-6 pt-5">
                                            <x-icons.cloud-upload class="mb-2 h-8 w-8 text-gray-500 dark:text-gray-400" />

                                            <p wire:loading.remove wire:target="docForm.attachment"
                                                class="mb-0.5 text-sm text-gray-500 dark:text-white"> Klik untuk upload
                                            </p>

                                            <p class="mb-0.5 text-sm text-gray-500 dark:text-gray-400">
                                                @if ($docForm->attachment)
                                                    <span class="font-semibold dark:text-white">
                                                        {{ $docForm->attachment->getClientOriginalName() }}</span>
                                                @endif
                                            </p>

                                            <div x-show="uploading"
                                                class="mb-2 flex flex-col items-center gap-2 text-gray-800 dark:text-white">
                                                <span wire:target="docForm.attachment" class="font-semibold">
                                                    Sedang Mengupload...</span>

                                                <x-button.danger id="cancel-upload" type="button" class="text-xs"
                                                    wire:click="$cancelUpload('docForm.attachment')">
                                                    Cancel
                                                </x-button.danger>
                                            </div>

                                            <p class="w-full text-center text-xs text-gray-500 dark:text-gray-400">
                                                *Dokumentasi dapat berupa file Gambar (Min, 10KB, Maks 2MB)
                                            </p>
                                        </div>
                                        <input id="attachment" name="attachment" type="file"
                                            wire:model="docForm.attachment" class="hidden" accept="image/*" />
                                    </label>

                                    <div x-show="uploading" class="h-4 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                        <div class="h-4 rounded-full bg-blue-600" x-bind:style="{ width: progress + '%' }">
                                        </div>
                                    </div>

                                </div>

                                @error('docForm.attachment')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex w-full justify-end">
                                <x-button.primary id="add-attachment" wire:click="storeLampiran" type="button">
                                    Tambah
                                </x-button.primary>
                            </div>

                        </div>

                        {{-- NOTES --}}
                        <div class="col-span-1 space-y-2 lg:col-span-2">
                            <x-input.textarea required id="notes" name="notes" wire:model="form.notes"
                                :labels="true" :textLabel="'Catatan'" :placeholder="'Cth: Instalasi dimulai dengan cara...'" />

                            @error('form.notes')
                                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- ACTION --}}
                        <div class="col-span-1 flex justify-end lg:col-span-2">
                            <x-button.success type="submit">
                                <span wire:loading.remove wire:target="store">Simpan Aktivitas</span>
                                <span wire:loading wire:target="store">Menyimpan...</span>
                            </x-button.success>
                        </div>

                    </form>

                </div>
            </div>
        @else
            <p class="w-full text-center text-sm text-red-500">
                Anda tidak dapat menambahkan aktivitas karena waktu laporan telah berakhir atau laporan telah ditandai
                sebagai Selesai.
            </p>
        @endif
    @endcan

    <div>
        <div class="mb-2 flex w-full items-center justify-between lg:mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                Daftar Aktivitas
            </h3>

            @if ($dailyReport->status === 'draft')
                <div class="flex gap-2 lg:gap-4">
                    @can('laporan-harian-edit')
                        <x-button.primary id="submit" type="button" wire:click.prevent="reportSubmit">
                            <span wire:loading.remove wire:target="reportSubmit">Ajukan Laporan</span>
                            <span wire:loading wire:target="reportSubmit">Mengajukan...</span>
                        </x-button.primary>
                    @endcan
                </div>
            @endif
        </div>

        {{-- LIST CONTAINER --}}
        <div class="w-full rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
            <div class="flex flex-col divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($this->hourlyReports as $index => $row)
                    <div class="p-2 transition hover:bg-gray-50 dark:hover:bg-gray-700/40 lg:p-4">
                        {{-- HEADER --}}
                        <div
                            class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3 lg:flex-row lg:items-center lg:justify-between lg:gap-4">
                            {{-- TIME INFO --}}
                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                <p class="font-medium">
                                    Pukul {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('HH:mm:ss') }}
                                </p>

                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, DD MMM YYYY') }}
                                </p>
                            </div>

                            {{-- REPORT DATE --}}
                            <div class="flex flex-col sm:text-right lg:text-center">
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    Waktu Aktivitas
                                </span>

                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($row->start_time)->isoFormat('HH:mm') }} -
                                    {{ \Carbon\Carbon::parse($row->end_time)->isoFormat('HH:mm') }}
                                </span>
                            </div>

                            {{-- activity --}}
                            <div class="flex flex-col gap-2 lg:items-end lg:gap-4">
                                <div class="flex flex-col lg:items-end">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        Aktivitas
                                    </span>

                                    <span class="font-semibold text-gray-900 dark:text-white lg:text-right">
                                        {{ ucfirst($row->activity) }}
                                    </span>
                                </div>

                                <div class="flex flex-col lg:items-end">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        Catatan
                                    </span>

                                    <span class="font-semibold text-gray-900 dark:text-white lg:text-right">
                                        {{ $row->notes }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- lampiran --}}
                        <div class="mx-auto mt-4">
                            <p class="mb-2 text-xs text-gray-500 dark:text-gray-400 lg:text-right">
                                Dokumentasi
                            </p>

                            <div class="flex overflow-x-auto lg:justify-end">
                                <div class="flex min-w-max gap-3">
                                    @foreach ($row->files as $file)
                                        <div class="flex-shrink-0">
                                            <img id="documentations" class="h-24 w-24 rounded-lg object-cover lg:w-36"
                                                src="{{ url('file/' . $file->file_path) }}" alt="Lampiran aktivitas"
                                                onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                                data-url="{{ url('file/' . $file->file_path) }}" alt=""
                                                onclick="javascript:void(0)" loading="lazy">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER --}}
                        <div class="mt-4 flex items-center justify-between">
                            {{-- ACTION --}}
                            @can('laporan-harian-delete')
                                <x-button.danger
                                    class="text-sm ring-blue-600 hover:bg-blue-100 dark:bg-blue-800 dark:text-white dark:hover:bg-blue-900"
                                    id="detail-button"
                                    wire:confirm.prompt="Anda yakin ingin menghapus laporan ini?\nKetik YA jika anda yakin.|YA"
                                    wire:click="delete('{{ $row->id }}')">
                                    <x-slot name="icon">
                                        <x-icons.trash-bin class="h-4 w-4" />
                                    </x-slot>

                                    <span wire:loading.remove wire:target="delete">Hapus</span>
                                    <span wire:loading wire:target="delete">Menghapus...</span>
                                </x-button.danger>
                            @endcan
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
                {{ $this->hourlyReports->links() }}
            </div>
        </div>
    </div>

    @push('script')
        @vite('resources/js/pages/spk/show.js')
    @endpush
</div>
