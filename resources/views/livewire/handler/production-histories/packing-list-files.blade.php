{{-- Goal: Manage packing list document attachments, Caller: packing-list.kits (Livewire), Livewire: Handler\ProductionHistories\PackingListFiles --}}
<div class="flex flex-col gap-6">

    {{-- File List Section --}}
    <section class="space-y-3">
        <div class="flex items-center gap-2">
            <x-icons.clipboard-check class="h-4 w-4 text-blue-500" />
            <h4 class="text-sm font-bold text-zinc-900 dark:text-white">Daftar Dokumen Lampiran</h4>
        </div>

        <div
            class="overflow-hidden rounded-xl border border-zinc-200 bg-white/50 dark:border-zinc-800 dark:bg-zinc-900/50">
            <ul class="divide-y divide-zinc-100 dark:divide-zinc-800">
                @forelse ($data['files'] as $index => $row)
                    <li
                        class="group flex items-center justify-between gap-4 p-4 transition-colors hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50">
                        <div class="flex items-center gap-3 overflow-hidden">
                            {{-- File Icon based on type --}}
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                @if (str_contains(strtolower($row['tipe_dokumen']), 'excel') || str_contains(strtolower($row['nama_file']), 'xls'))
                                    <x-icons.file-excel class="h-5 w-5 text-green-600" />
                                @elseif(str_contains(strtolower($row['tipe_dokumen']), 'pdf'))
                                    <x-icons.file-invoice class="h-5 w-5 text-red-600" />
                                @else
                                    <x-icons.archive class="h-5 w-5 text-blue-600" />
                                @endif
                            </div>

                            <div class="flex flex-col overflow-hidden">
                                <a href="{{ route('spk.attachment.download', $row['url']) }}"
                                    class="truncate text-sm font-semibold text-zinc-900 hover:text-blue-600 dark:text-white dark:hover:text-blue-400">
                                    {{ $row['nama_file'] }}
                                </a>
                                <span class="text-[10px] font-medium uppercase tracking-wider text-zinc-500">
                                    {{ $row['tipe_dokumen'] }}
                                </span>
                            </div>
                        </div>

                        <div class="flex shrink-0 items-center gap-2">
                            <x-button.danger wire:click="removeFile('{{ $index }}', '{{ $row['_key'] }}')"
                                wire:confirm="Hapus file ini?" class="!p-2">
                                <x-icons.trash-bin class="h-4 w-4" />
                            </x-button.danger>
                        </div>
                    </li>
                @empty
                    <li class="flex flex-col items-center justify-center py-8 text-center">
                        <p class="text-xs italic text-zinc-500">Belum ada lampiran dokumen.</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </section>

    {{-- Upload Form Section --}}
    <x-utils.accordion-item id="accordion-packing-files" title="Tambah Dokumen Baru"
        description="Upload lampiran PDF, Excel, atau gambar" iconColor="blue" :expanded="false">
        <x-slot:icon>
            <x-icons.cloud-upload class="h-4 w-4" />
        </x-slot:icon>

        <form wire:submit.prevent="store" class="space-y-5">
            {{-- Dropzone Area --}}
            <div class="w-full" x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false"
                x-on:livewire-upload-error="uploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress">

                <label for="attachment"
                    class="relative flex min-h-[160px] w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 bg-white/50 p-6 transition-all hover:border-blue-400 hover:bg-blue-50/30 dark:border-zinc-700 dark:bg-zinc-900/50 dark:hover:border-blue-500/50">

                    <div class="flex flex-col items-center text-center">
                        @if (!$docForm->attachment)
                            <x-icons.cloud-upload class="mb-3 h-10 w-10 text-zinc-400 group-hover:text-blue-500" />
                            <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Klik atau seret file
                                ke sini</p>
                            <p class="mt-1 text-[10px] text-zinc-500">PDF, Excel, Word (Maks 2MB)</p>
                        @else
                            <div
                                class="flex items-center gap-2 rounded-lg bg-green-50 px-3 py-2 text-green-700 ring-1 ring-green-600/20 dark:bg-green-900/20 dark:text-green-400">
                                <x-icons.checklist-stepper class="h-4 w-4" />
                                <span
                                    class="text-xs font-bold">{{ $docForm->attachment->getClientOriginalName() }}</span>
                            </div>
                            <button type="button" wire:click="$set('docForm.attachment', null)"
                                class="mt-2 text-[10px] font-bold text-red-500 hover:underline">Hapus &
                                Ganti</button>
                        @endif
                    </div>

                    <input id="attachment" name="attachment" type="file" wire:model="docForm.attachment"
                        class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg" />

                    {{-- Uploading State Overlay --}}
                    <div x-show="uploading"
                        class="absolute inset-0 z-20 flex flex-col items-center justify-center rounded-xl bg-white/90 backdrop-blur-sm dark:bg-zinc-900/90">
                        <div class="flex w-48 flex-col items-center gap-3">
                            <x-icons.loading class="h-8 w-8 animate-spin text-blue-600" />
                            <div class="h-1.5 w-full overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-800">
                                <div class="h-full bg-blue-600 transition-all duration-300"
                                    :style="`width: ${progress}%`"></div>
                            </div>
                            <span class="text-[10px] font-bold text-zinc-600 dark:text-zinc-400">Mengupload: <span
                                    x-text="progress"></span>%</span>
                        </div>
                    </div>
                </label>

                @error('docForm.attachment')
                    <p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Type Selection & Submit --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <x-input.select id="attachment_type" name="attachment_type" :defaultOption="'Pilih Tipe Dokumen'" :options="[
                        'packing' => 'Packing List',
                        'detail' => 'Detail Item Packing',
                        'all' => 'Semua Dokumen',
                        'other' => 'Dokumen Lainnya',
                    ]"
                        :labels="true" :textLabel="'Kategori Dokumen'" wire:model.defer="docForm.attachment_type" />
                </div>

                <div class="shrink-0">
                    <x-button.primary type="submit" class="w-full sm:w-auto" wire:loading.attr="disabled"
                        wire:target="store">
                        <x-slot name="icon">
                            <x-icons.plus wire:loading.remove wire:target="store" class="icon h-5 w-5" />
                            <x-icons.loading wire:loading wire:target="store" class="h-4 w-4 animate-spin" />
                        </x-slot>

                        <span wire:loading.remove wire:target="store">Simpan Dokumen</span>
                        <span wire:loading wire:target="store">Memproses...</span>
                    </x-button.primary>
                </div>
            </div>
        </form>
    </x-utils.accordion-item>

</div>
