{{-- Goal: Modal UI for importing pegawai data via Excel, Livewire: ImportPegawai, Alpine: file drag-drop --}}
<div>
    {{-- Trigger Button --}}
    <x-button.primary wire:click="openModal">
        <x-slot name="icon">
            <x-icons.file-excel class="h-5 w-5" />
        </x-slot>
        Import Excel
    </x-button.primary>

    {{-- Modal --}}
    <x-modal.base-modal show="showModal" id="import-pegawai-modal" title="Import Data Pegawai"
        subtitle="Upload file Excel untuk update data" maxWidth="lg"
        iconContainerClass="bg-blue-600 shadow-blue-500/20">
        <x-slot name="icon">
            <x-icons.cloud-upload class="h-5 w-5" />
        </x-slot>

        <div class="flex flex-col gap-5">

            {{-- Template Download --}}
            <div class="flex items-center justify-between rounded-lg border border-blue-200 bg-blue-50/50 p-3 dark:border-blue-900/50 dark:bg-blue-950/30">
                <div class="flex items-center gap-2">
                    <x-icons.file-excel class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Download template Excel</span>
                </div>
                <button wire:click="downloadTemplate" type="button"
                    class="text-sm font-semibold text-blue-600 transition hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Download
                </button>
            </div>

            {{-- Upload Area (only shown when no result yet) --}}
            @if (! $importResult)
                <div x-data="{ isDragging: false }" class="relative">
                    <label for="file-upload"
                        class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed p-8 transition-colors"
                        x-bind:class="isDragging
                            ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-950/20'
                            : 'border-zinc-300 bg-zinc-50/50 hover:border-zinc-400 dark:border-zinc-700 dark:bg-zinc-800/50 dark:hover:border-zinc-600'"
                        x-on:dragover.prevent="isDragging = true"
                        x-on:dragleave.prevent="isDragging = false"
                        x-on:drop.prevent="isDragging = false; $refs.fileInput.files = $event.dataTransfer.files; $refs.fileInput.dispatchEvent(new Event('change'))">

                        <x-icons.cloud-upload class="mb-3 h-10 w-10 text-zinc-400 dark:text-zinc-500" />

                        @if ($file)
                            <p class="text-sm font-semibold text-green-600 dark:text-green-400">
                                {{ $file->getClientOriginalName() }}
                            </p>
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                {{ number_format($file->getSize() / 1024, 1) }} KB
                            </p>
                        @else
                            <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">
                                Drag & drop file di sini, atau <span class="text-blue-600 dark:text-blue-400">pilih file</span>
                            </p>
                            <p class="mt-1 text-xs text-zinc-400 dark:text-zinc-500">
                                Format: .xlsx, .xls (Maks. 5MB)
                            </p>
                        @endif

                        <input id="file-upload" x-ref="fileInput" type="file" wire:model="file" accept=".xlsx,.xls" class="hidden" />
                    </label>

                    {{-- Loading indicator --}}
                    <div wire:loading wire:target="file"
                        class="absolute inset-0 flex items-center justify-center rounded-xl bg-white/80 dark:bg-zinc-900/80">
                        <x-icons.loading class="h-6 w-6 animate-spin text-blue-600" />
                    </div>
                </div>

                @error('file')
                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            @endif

            {{-- Import Result --}}
            @if ($importResult)
                <div class="flex flex-col gap-3">
                    {{-- Success count --}}
                    <div class="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50/60 p-3 dark:border-green-900/50 dark:bg-green-950/30">
                        <x-icons.check-circle class="h-5 w-5 text-green-600 dark:text-green-400" />
                        <span class="text-sm font-semibold text-green-700 dark:text-green-400">
                            {{ $importResult['updated'] }} data berhasil di-update
                        </span>
                    </div>

                    {{-- Skipped rows --}}
                    @if (! empty($importResult['skipped']))
                        <div class="rounded-lg border border-amber-200 bg-amber-50/60 p-3 dark:border-amber-900/50 dark:bg-amber-950/30">
                            <div class="mb-2 flex items-center gap-2">
                                <x-icons.exclamation-circle class="h-5 w-5 text-amber-600 dark:text-amber-400" />
                                <span class="text-sm font-semibold text-amber-700 dark:text-amber-400">
                                    {{ count($importResult['skipped']) }} baris di-skip
                                </span>
                            </div>
                            <ul class="max-h-32 space-y-1 overflow-y-auto pl-7 text-xs text-amber-600 dark:text-amber-400">
                                @foreach ($importResult['skipped'] as $skip)
                                    <li>{{ $skip }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Validation failures --}}
                    @if (! empty($importResult['failures']))
                        <div class="rounded-lg border border-red-200 bg-red-50/60 p-3 dark:border-red-900/50 dark:bg-red-950/30">
                            <div class="mb-2 flex items-center gap-2">
                                <x-icons.close class="h-5 w-5 text-red-600 dark:text-red-400" />
                                <span class="text-sm font-semibold text-red-700 dark:text-red-400">
                                    {{ count($importResult['failures']) }} baris gagal validasi
                                </span>
                            </div>
                            <ul class="max-h-32 space-y-1 overflow-y-auto pl-7 text-xs text-red-600 dark:text-red-400">
                                @foreach ($importResult['failures'] as $fail)
                                    <li>{{ $fail }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <x-slot name="footer">
            <x-button.secondary wire:click="closeModal">
                {{ $importResult ? 'Tutup' : 'Batal' }}
            </x-button.secondary>

            @if (! $importResult)
                <x-button.primary wire:click="import" wire:loading.attr="disabled" wire:target="import, file">
                    <x-slot name="icon">
                        <x-icons.cloud-upload wire:loading.remove wire:target="import" class="h-5 w-5" />
                        <x-icons.loading wire:loading wire:target="import" class="h-4 w-4 animate-spin" />
                    </x-slot>
                    <span wire:loading.remove wire:target="import">Import Data</span>
                    <span wire:loading wire:target="import">Mengimport...</span>
                </x-button.primary>
            @endif
        </x-slot>
    </x-modal.base-modal>
</div>
