<div class="grid grid-cols-1 gap-2 lg:gap-4">

    <section>
        <h4 class="mb-2 text-base font-semibold text-gray-800 dark:text-white">Daftar Dokumen</h4>

        <div
            class="flex flex-col rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-700">

            <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                @forelse ($data['files'] as $index => $row)
                    <li
                        class="group flex items-center justify-between gap-2 p-2 transition-all duration-150 ease-in-out hover:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 lg:p-4">
                        <a href="{{ route('spk.attachment.download', $row['url']) }}"
                            class="grow text-gray-900 group-hover:text-blue-500 dark:text-gray-100">
                            <p class="text-base font-medium">
                                {{ $row['nama_file'] }}
                            </p>
                            <p
                                class="mt-0.5 text-sm text-gray-500 group-hover:text-blue-400 dark:text-gray-400 dark:group-hover:text-blue-200">
                                {{ $row['tipe_dokumen'] }}
                            </p>
                        </a>

                        <div class="h-fit w-fit">
                            <x-button.danger id="remove-documentation"
                                wire:click="removeFile('{{ $index }}', '{{ $row['_key'] }}')">
                                <x-icons.trash-bin class="h-4 w-4" />
                            </x-button.danger>
                        </div>
                    </li>
                @empty
                    <li class="p-2 text-xs font-semibold capitalize italic lg:p-4">
                        Tidak ada lampiran.
                    </li>
                @endforelse
            </ul>

        </div>
    </section>

    <div id="accordion-packing-form" x-data="{ accordionOpen: false }">
        <button type="button"
            class="d flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 bg-green-500 p-5 font-medium text-white transition-all duration-300 ease-in-out hover:bg-green-400 dark:border-gray-600 dark:bg-green-600 dark:hover:bg-green-500"
            @click="accordionOpen = !accordionOpen" :class="accordionOpen ? 'rounded-b-none border-b-0' : ''">
            <h3 class="text-base font-semibold text-white">
                Tambah Dokumen?
            </h3>

            <span class="transition-all duration-300 ease-in-out" :class="accordionOpen ? 'rotate-180' : ''">
                <x-icons.carred-down class="h-4 w-4" />
            </span>
        </button>

        <form class="flex flex-col gap-2 rounded-b-lg border border-gray-200 p-5 dark:border-gray-700 lg:gap-4"
            x-show="accordionOpen" x-collapse x-cloak wire:submit.prevent="store" method="post">

            <div class="w-full">
                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                    for="attachment">Lampiran</label>

                <div class="flex w-full flex-col gap-y-2" x-data="{ uploading: false, progress: 0 }"
                    x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false"
                    x-on:livewire-upload-cancel="uploading = false" x-on:livewire-upload-error="uploading = false"
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
                                *Dokumentasi dapat berupa file PNG, JPG, PDF, DOC, XLS (Min 10KB, Maks
                                2MB)
                            </p>
                        </div>
                        <input id="attachment" name="attachment" type="file" wire:model="docForm.attachment"
                            class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx" />
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

            <div class="w-full">
                <x-input.select id="attachment_type" name="attachment_type" :defaultOption="'Pilih Tipe Dokumen'" :options="[
                    'packing' => 'Packing List',
                    'detail' => 'Detail Item Packing',
                    'all' => 'Semua Dokumen',
                    'other' => 'Dokumen Lainnya',
                ]"
                    :labels="true" :textLabel="'Tipe Dokumen'" wire:model.defer="docForm.attachment_type" />

                @error('docForm.attachment_type')
                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex w-full justify-end">
                <x-button.primary id="add-attachment" type="submit">
                    Tambah
                </x-button.primary>
            </div>
        </form>
    </div>
</div>
