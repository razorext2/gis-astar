<div id="laporan-fondasi-container" x-data="{ open: @entangle('showLaporanFondasi') }">
    <section class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">

        <div
            class="z-0 flex flex-row items-center justify-between gap-2 bg-zinc-50/50 p-4 transition-all duration-500 ease-in-out hover:cursor-pointer hover:bg-zinc-100 dark:bg-zinc-800/50 dark:hover:bg-zinc-800 lg:gap-4"
            @click="open = !open">
            <div class="w-fit text-nowrap">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white">
                    Laporan Fondasi
                </h3>
            </div>

            <div class="relative hidden w-full rounded-full bg-zinc-200 dark:bg-zinc-800 lg:block">
                <div class="flex h-6 items-center justify-center gap-2 rounded-full bg-blue-600 p-0.5"
                    style="width: {{ $laporanFondasiLastProgress['value'] }}%">
                </div>

                <div
                    class="absolute left-1/2 top-1/2 flex -translate-x-1/2 -translate-y-1/2 flex-row text-center text-xs font-semibold leading-none text-zinc-900 dark:text-white">
                    <span>{{ $laporanFondasiLastProgress['value'] }}%</span>
                </div>
            </div>

            <div class="flex flex-row gap-x-2">
                @can('laporan-fondasi-create')
                    @if ($spk->added_by == auth()->id() || auth()->user()->can('spk-validate'))
                        <x-button.success wire:click="openCreateLaporanFondasiModal" class="z-10 w-fit">
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
                    <div
                        class="flex flex-col gap-2 p-4 transition hover:bg-zinc-50 dark:hover:bg-zinc-800/30">
                        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-8">
                            <div class="text-right text-xs text-zinc-500 dark:text-zinc-400 lg:text-left">
                                <p>Pukul {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('hh:mm:ss') }}</p>
                                <p>{{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, DD MMM YYYY') }}
                                </p>
                            </div>

                            <div class="flex flex-col">
                                <h4 class="text-base font-semibold text-zinc-900 dark:text-white"> {{ $row->judul }} </h4>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400"> {{ $row->keterangan }} </p>

                                @if (count($row->dokumentasi) > 0)
                                    <div class="mt-3 flex w-full flex-row gap-3 overflow-x-auto pb-2">
                                        @foreach ($row->dokumentasi as $i => $img)
                                            <img class="h-20 w-20 rounded-xl border border-zinc-200 object-cover dark:border-zinc-800" id="documentations"
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
                            <p class="rounded-md bg-green-500/20 px-2 py-0.5 font-medium text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800/50">
                                {{ $row->status_pengerjaan_description }}
                            </p>
                            <p class="text-right italic text-zinc-500 dark:text-zinc-400">Oleh: {{ $row->addedBy->name }}</p>
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
    @teleport('body')
        <div id="laporan-fondasi-modal" wire:show="showModalAddLaporanFondasi" wire:transition.duration.300ms
            class="fixed inset-0 z-[100] overflow-y-auto bg-zinc-900/60 backdrop-blur-md">

            <div class="flex min-h-full items-center justify-center p-4">
                @if ($showModalAddLaporanFondasi)
                    <div class="flex w-full flex-col gap-1 overflow-y-auto rounded-xl border border-zinc-200 bg-white p-4 shadow-2xl dark:border-zinc-800 dark:bg-dark-primary md:w-2/3 md:gap-2 lg:w-1/2 xl:w-2/5"
                        style="max-height: calc(100vh - 2rem);">

                        <h2 class="mb-2 text-center text-lg font-semibold text-zinc-900 dark:text-white lg:text-xl">
                            {{ $isEditing ? 'Edit' : 'Tambah' }} Laporan Fondasi
                        </h2>

                        <form wire:submit="{{ $isEditing ? 'updateLaporanFondasi' : 'storeLaporanFondasi' }}"
                            class="flex w-full flex-col gap-2 lg:gap-4">

                            <div class="w-full">
                                <x-input.basic name="title" id="title" wire:model="form.title">
                                    Judul Laporan
                                </x-input.basic>

                                @error('form.title')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            @if (!$isEditing)
                                <div class="w-full">
                                    <label class="mb-2 block text-sm font-medium text-zinc-900 dark:text-white"
                                        for="documentations">Dokumentasi</label>


                                    <div class="flex w-full flex-col gap-y-2">
                                        <label for="documentation-input"
                                            class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-zinc-200 bg-zinc-50 transition-all duration-500 hover:bg-zinc-100 dark:border-zinc-800 dark:bg-dark-secondary dark:hover:border-zinc-800 dark:hover:bg-zinc-800">
                                            <div class="flex flex-col items-center justify-center pb-6 pt-5">
                                                <x-icons.cloud-upload
                                                    class="mb-2 h-8 w-8 text-zinc-500 dark:text-zinc-400" />
                                                <p class="mb-0.5 text-sm text-zinc-500 dark:text-zinc-400">
                                                    <span class="font-semibold"> Klik untuk upload</span>
                                                </p>
                                                <p class="w-full text-center text-xs text-zinc-500 dark:text-zinc-400">
                                                    *Dokumentasi dapat berupa foto progress pengerjaan fondasi.
                                                </p>
                                            </div>
                                            <input id="documentation-input" name="documentations" type="file"
                                                accept=".png,.jpg,.jpeg,.heic,.bmp;capture=camera"
                                                wire:model.live="form.newDocumentations" class="hidden" multiple />
                                        </label>
                                    </div>

                                    @if ($form->documentations)
                                        <div class="mt-2 flex flex-col gap-2">
                                            <div
                                                class="dark:highlight-white/5 relative min-w-0 overflow-auto rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-800 dark:bg-dark-secondary">

                                                <div class="flex overflow-x-scroll">

                                                    @foreach ($form->documentations as $index => $doc)
                                                        <div class="flex-none px-1.5 py-3 first:pl-3 last:pr-3">
                                                            <div
                                                                class="relative flex flex-col items-center justify-center gap-3">
                                                                <img class="w-24 rounded-lg"
                                                                    src="{{ $doc->temporaryUrl() }}">
                                                                <x-button.danger type="button"
                                                                    class="absolute end-0 top-0 !p-1 hover:bg-red-600"
                                                                    wire:click="removeDocumentation({{ $index }})">
                                                                    <x-slot name="icon">
                                                                        <x-icons.close class="h-4 w-4" />
                                                                    </x-slot>
                                                                </x-button.danger>
                                                                <p class="text-xs text-zinc-600 dark:text-white">
                                                                    @php
                                                                        $name = $doc->getClientOriginalName();
                                                                        $label =
                                                                            strlen($name) > 10
                                                                                ? substr($name, 0, 5) .
                                                                                    '...' .
                                                                                    substr($name, -5)
                                                                                : $name;
                                                                    @endphp
                                                                    {{ $label }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        @php
                                                            $total = $index + 1;
                                                        @endphp
                                                    @endforeach
                                                </div>
                                            </div>

                                            <p class="text-xs text-zinc-600 dark:text-zinc-100">Total {{ $total ?? '0' }}
                                                file.
                                            </p>

                                        </div>
                                    @endif

                                    @error('form.newDocumentations.*')
                                        <span class="error mt-2 text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                    @error('form.documentations')
                                        <span class="error mt-2 text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                    @error('form.documentations.*')
                                        <span class="error mt-2 text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

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

                            <div class="w-full">
                                <x-input.textarea :textLabel="'Keterangan'" wire:model="form.description" id="keterangan"
                                    name="keterangan" :rows="8" />

                                @error('form.description')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex w-full justify-end space-x-2">
                                <x-button.primary id="save-laporan-fondasi" type="submit">
                                    <span wire:loading.remove
                                        wire:target="{{ $isEditing ? 'updateLaporanFondasi' : 'storeLaporanFondasi' }}">
                                        {{ $isEditing ? 'Update' : 'Simpan' }}
                                    </span>
                                    <span wire:loading
                                        wire:target="{{ $isEditing ? 'updateLaporanFondasi' : 'storeLaporanFondasi' }}">
                                        {{ $isEditing ? 'Mengupdate...' : 'Menyimpan...' }}
                                    </span>
                                </x-button.primary>

                                <x-button.secondary id="close-modal-laporan-fondasi"
                                    wire:click="closeLaporanFondasiModal">
                                    Batal
                                </x-button.secondary>
                            </div>
                        </form>

                    </div>
                @endif
            </div>
        </div>
    @endteleport
    {{-- end modal tambah laporan fondasi --}}

    {{-- modal delete laporan fondasi --}}
    @teleport('body')
        <div id="delete-laporan-fondasi-modal" wire:show="showModalDeleteLaporanFondasi" wire:transition.duration.300ms
            class="fixed inset-0 z-[100] overflow-y-auto bg-zinc-900/60 backdrop-blur-md">

            <div class="flex min-h-full items-center justify-center p-4">
                @if ($showModalDeleteLaporanFondasi)
                    <div class="flex w-fit flex-col gap-2 overflow-y-auto rounded-xl border border-zinc-200 bg-white p-4 shadow-2xl dark:border-zinc-800 dark:bg-dark-primary"
                        style="max-height: calc(100vh - 2rem);">

                        <h2 class="text-center text-lg font-semibold text-zinc-900 dark:text-white lg:text-xl">
                            Hapus Laporan Fondasi?
                        </h2>

                        <p class="text-center text-sm text-zinc-700 dark:text-zinc-100 lg:text-base">
                            Apakah anda yakin ingin menghapus Laporan ini?
                        </p>

                        <div class="flex flex-row justify-end gap-2">
                            <x-button.danger id="delete-laporan-fondasi" type="button"
                                wire:click="deleteLaporanFondasiAction">
                                <span wire:loading.remove wire:target="deleteLaporanFondasiAction">Hapus</span>
                                <span wire:loading wire:target="deleteLaporanFondasiAction">Loading</span>
                            </x-button.danger>

                            <x-button.secondary id="cancel-delete-laporan-fondasi" type="button"
                                wire:click="$set('showModalDeleteLaporanFondasi', false)">
                                Batal
                            </x-button.secondary>
                        </div>

                    </div>
                @endif
            </div>

        </div>
    @endteleport
    {{-- end modal delete laporan fondasi --}}

    @push('script')
        @vite('resources/js/pages/spk/show.js')
    @endpush
</div>
