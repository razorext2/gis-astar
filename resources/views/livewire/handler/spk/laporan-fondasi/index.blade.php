<div id="laporan-fondasi-container" x-data="{ open: @entangle('showLaporanFondasi') }">
    <section
        class="overflow-hidden rounded-xl border border-zinc-200 bg-white/60 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none">

        <div class="flex items-center justify-between space-x-2 p-4 transition-all duration-500 ease-in-out hover:cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800/30 lg:p-6"
            @click="open = !open">

            <h3 class="text-lg font-bold text-zinc-900 dark:text-white">
                Laporan Fondasi
            </h3>

            <div class="relative hidden w-full rounded-xl bg-zinc-200 dark:bg-zinc-800 lg:block">
                <div class="flex h-6 items-center justify-center gap-2 rounded-xl bg-blue-600 p-0.5"
                    style="width: {{ $laporanFondasiLastProgress['value'] }}%">
                </div>

                <div
                    class="absolute left-1/2 top-1/2 flex -translate-x-1/2 -translate-y-1/2 flex-row text-center text-xs font-semibold leading-none text-zinc-900 dark:text-white">
                    <span>{{ $laporanFondasiLastProgress['value'] }}%</span>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                @can('laporan-fondasi-create')
                    @if ($spk->added_by == auth()->id() || auth()->user()->can('spk-validate'))
                        <x-button.success wire:click.stop="openCreateLaporanFondasiModal" class="z-10 w-fit !p-2">
                            <x-icons.plus class="h-5 w-5 dark:text-white" />
                        </x-button.success>
                    @endif
                @endcan

                <x-button.secondary class="!p-2" @click.stop="open = !open">
                    <x-icons.carred-down class="h-5 w-5 transition-transform duration-300 dark:text-white"
                        ::class="open ? 'rotate-180' : ''" />
                </x-button.secondary>
            </div>

        </div>

        <div x-show="open" x-collapse>
            <div class="flex flex-col divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($laporanFondasi as $row)
                    <div class="flex flex-col gap-2 p-4 transition hover:bg-zinc-100 dark:hover:bg-zinc-800/30 lg:p-6">
                        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-8">
                            <div class="text-right text-xs text-zinc-500 dark:text-zinc-400 lg:text-left">
                                <p>Pukul {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('hh:mm:ss') }}</p>
                                <p>{{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, DD MMM YYYY') }}
                                </p>
                            </div>

                            <div class="flex flex-col">
                                <h4 class="text-base font-semibold text-zinc-900 dark:text-white"> {{ $row->judul }}
                                </h4>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400"> {{ $row->keterangan }} </p>

                                @if (count($row->dokumentasi) > 0)
                                    <div class="mt-3 flex w-full flex-row gap-3 overflow-x-auto pb-2">
                                        @foreach ($row->dokumentasi as $i => $img)
                                            <img class="h-20 w-20 rounded-xl border border-zinc-200 object-cover dark:border-zinc-800"
                                                id="documentations"
                                                onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                                data-url="{{ asset('storage/' . $img['path_file']) }}"
                                                src="{{ asset('storage/' . $img['path_file']) }}" alt=""
                                                onclick="javascript:void(0)" loading="lazy">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-row justify-between text-xs">
                            <p
                                class="rounded-md border border-green-200 bg-green-500/20 px-2 py-0.5 font-medium text-green-700 dark:border-green-800/50 dark:text-green-400">
                                {{ $row->status_pengerjaan_description }}
                            </p>
                            <p class="text-right italic text-zinc-500 dark:text-zinc-400">Oleh:
                                {{ $row->addedBy->name }}</p>
                        </div>

                        <div class="flex flex-row justify-end gap-3 text-xs">
                            @can('laporan-fondasi-edit')
                                @if ($spk->added_by == auth()->id())
                                    <a class="cursor-pointer text-zinc-500 transition hover:text-blue-600 hover:underline dark:text-zinc-400 dark:hover:text-blue-400"
                                        wire:click="editLaporanFondasi('{{ $row->id }}')">Edit</a>
                                @endif
                            @endcan

                            @can('laporan-fondasi-delete')
                                <a class="cursor-pointer text-red-500 transition hover:text-red-600 hover:underline dark:text-red-400 dark:hover:text-red-300"
                                    wire:click="deleteLaporanFondasi('{{ $row->id }}')">Delete</a>
                            @endcan
                        </div>
                    </div>
                @empty
                    <p class="p-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                        Belum ada laporan fondasi.
                    </p>
                @endforelse

                <div class="p-4">
                    {{ $laporanFondasi->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>
    </section>
    {{-- end laporan fondasi --}}

    {{-- modal tambah laporan Fondasi --}}
    <x-modal.base-modal show="showModalAddLaporanFondasi" :title="($isEditing ? 'Edit' : 'Tambah') . ' Laporan Fondasi'" subtitle="Input Progress Pekerjaan Fondasi"
        iconContainerClass="bg-blue-600 shadow-blue-500/20" maxWidth="2xl">
        <x-slot name="icon">
            @if ($isEditing)
                <x-icons.file-pen class="h-5 w-5" />
            @else
                <x-icons.plus class="h-5 w-5" />
            @endif
        </x-slot>

        @if ($showModalAddLaporanFondasi)
            <form wire:submit="{{ $isEditing ? 'updateLaporanFondasi' : 'storeLaporanFondasi' }}"
                id="form-laporan-fondasi" class="flex flex-col gap-6">

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <div class="flex flex-col gap-4">
                        <div class="w-full">
                            <x-input.basic name="title" id="title" wire:model="form.title">
                                Judul Laporan
                            </x-input.basic>

                            @error('form.title')
                                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <x-input.select id="progress" name="progress" :labels="true" :textLabel="'Progres Pengerjaan'"
                                :defaultOption="'Pilih Status'" :options="[
                                    10 => 'Persiapan bahan',
                                    33 => 'Tahap 1',
                                    50 => 'Tahap 2',
                                    88 => 'Finishing',
                                    100 => 'Selesai',
                                ]" wire:model="form.progress" />

                            @error('form.progress')
                                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="w-full">
                        <x-input.textarea :textLabel="'Keterangan'" wire:model="form.description" id="keterangan"
                            name="keterangan" :rows="5" />

                        @error('form.description')
                            <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @if (!$isEditing)
                    <div class="w-full">
                        <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                            for="documentations">Dokumentasi Foto</label>

                        <div class="flex w-full flex-col gap-y-2">
                            <label for="documentation-input"
                                class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 bg-zinc-50/50 transition-all duration-300 hover:bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-900/50 dark:hover:bg-zinc-800">
                                <div class="flex flex-col items-center justify-center pb-6 pt-5">
                                    <x-icons.cloud-upload class="mb-2 h-8 w-8 text-zinc-400 dark:text-zinc-500" />
                                    <p class="mb-0.5 text-sm font-semibold text-zinc-600 dark:text-zinc-400">
                                        Klik untuk upload
                                    </p>
                                    <p class="w-full text-center text-xs text-zinc-400 dark:text-zinc-500">
                                        Dapat berupa foto progress pengerjaan fondasi.
                                    </p>
                                </div>
                                <input id="documentation-input" name="documentations" type="file"
                                    accept=".png,.jpg,.jpeg,.heic,.bmp;capture=camera"
                                    wire:model.live="form.newDocumentations" class="hidden" multiple />
                            </label>
                        </div>

                        @if ($form->documentations)
                            <div class="mt-4 flex flex-col gap-2">
                                <div
                                    class="scrollbar-thin scrollbar-thumb-zinc-200 dark:scrollbar-thumb-zinc-800 overflow-x-auto rounded-xl border border-zinc-200 bg-zinc-50 p-3 dark:border-zinc-800 dark:bg-zinc-900/50">
                                    <div class="flex gap-4">
                                        @foreach ($form->documentations as $index => $doc)
                                            <div class="relative shrink-0">
                                                <img class="h-24 w-24 rounded-lg border border-zinc-200 object-cover dark:border-zinc-800"
                                                    src="{{ $doc->temporaryUrl() }}">
                                                <x-button.danger type="button"
                                                    class="absolute -end-2 -top-2 !rounded-full !p-1 shadow-md"
                                                    wire:click="removeDocumentation({{ $index }})">
                                                    <x-slot name="icon">
                                                        <x-icons.close class="h-3 w-3" />
                                                    </x-slot>
                                                </x-button.danger>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                    Total {{ count($form->documentations) }} file dipilih.
                                </p>
                            </div>
                        @endif

                        @error('form.newDocumentations.*')
                            <span class="error mt-2 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                        @error('form.documentations')
                            <span class="error mt-2 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
            </form>
        @endif

        <x-slot name="footer">
            <x-button.secondary @click="open = false">
                Batal
            </x-button.secondary>
            <x-button.primary type="submit" form="form-laporan-fondasi">
                <span wire:loading.remove
                    wire:target="{{ $isEditing ? 'updateLaporanFondasi' : 'storeLaporanFondasi' }}">
                    {{ $isEditing ? 'Update Laporan' : 'Simpan Laporan' }}
                </span>
                <span wire:loading wire:target="{{ $isEditing ? 'updateLaporanFondasi' : 'storeLaporanFondasi' }}">
                    {{ $isEditing ? 'Mengupdate...' : 'Menyimpan...' }}
                </span>
            </x-button.primary>
        </x-slot>
    </x-modal.base-modal>

    {{-- modal delete laporan fondasi --}}
    <x-modal.base-modal show="showModalDeleteLaporanFondasi" title="Hapus Laporan?"
        subtitle="Tindakan Tidak Dapat Dibatalkan" iconContainerClass="bg-red-600 shadow-red-500/20" maxWidth="md">
        <x-slot name="icon">
            <x-icons.trash class="h-5 w-5" />
        </x-slot>

        <div class="py-2">
            <p class="text-sm font-semibold leading-relaxed text-zinc-700 dark:text-zinc-300">
                Apakah Anda yakin ingin menghapus laporan fondasi ini? Data yang dihapus tidak dapat
                dikembalikan.
            </p>
        </div>

        <x-slot name="footer">
            <x-button.secondary @click="open = false">
                Batal
            </x-button.secondary>
            <x-button.danger wire:click="deleteLaporanFondasiAction">
                <span wire:loading.remove wire:target="deleteLaporanFondasiAction">Hapus Laporan</span>
                <span wire:loading wire:target="deleteLaporanFondasiAction">Menghapus...</span>
            </x-button.danger>
        </x-slot>
    </x-modal.base-modal>
    {{-- end modal delete laporan fondasi --}}

    @push('script')
        @vite('resources/js/pages/spk/show.js')
    @endpush
</div>
