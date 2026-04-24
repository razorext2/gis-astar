<div id="laporan-fondasi-container">
    <section class="rounded-lg text-gray-800 ring-1 ring-zinc-200 dark:text-white dark:ring-zinc-800 lg:gap-4">

        <div
            class="{{ $showLaporanFondasi ? 'rounded-t-lg' : 'rounded-lg' }} z-0 flex flex-row items-center justify-between gap-2 p-2.5 transition-all duration-500 ease-in-out hover:cursor-pointer hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-800 lg:gap-4">
            <div class="w-fit text-nowrap">
                <h3 class="text-lg font-[900] text-red-600 dark:text-white">
                    Laporan Fondasi
                </h3>
            </div>

            <div class="relative hidden w-full rounded-full bg-blue-200 lg:block">
                <div class="flex h-6 items-center justify-center gap-2 rounded-full bg-blue-600 p-0.5"
                    style="width: {{ $laporanFondasiLastProgress['value'] }}%">
                </div>

                <div
                    class="absolute left-1/2 top-1/2 flex -translate-x-1/2 -translate-y-1/2 flex-row text-center text-xs font-medium leading-none text-white">
                    <span>{{ $laporanFondasiLastProgress['value'] }}%</span>
                    {{-- <span>({{ $laporanFondasiLastProgress['description'] }})</span> --}}
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

                <x-button.primary class="w-fit" wire:click="$toggle('showLaporanFondasi')">
                    <x-icons.carred-down
                        class="{{ $showLaporanFondasi ? 'rotate-180' : '' }} h-5 w-5 transition-all duration-300 ease-in-out dark:text-white" />
                </x-button.primary>
            </div>
        </div>

        @if ($showLaporanFondasi)
            <div class="flex flex-col gap-2 p-2 lg:gap-4 lg:p-4">
                @forelse ($laporanFondasi as $row)
                    <div
                        class="flex flex-col gap-2 border-b border-zinc-200 pb-2 text-gray-800 dark:border-zinc-800 dark:text-white">
                        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-8">
                            <div class="text-right text-xs lg:text-left">
                                <p>Pukul {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('hh:mm:ss') }}</p>
                                <p>{{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, DD MMM YYYY') }}
                                </p>
                            </div>

                            <div class="flex flex-col">
                                <h4 class="text-base font-semibold"> {{ $row->judul }} </h4>
                                <p class="text-sm"> {{ $row->keterangan }} </p>

                                @if (count($row->dokumentasi) > 0)
                                    <div class="mt-2 flex w-full flex-row gap-2 overflow-x-auto">
                                        @foreach ($row->dokumentasi as $i => $img)
                                            <img class="h-20 w-20 rounded-xl object-cover" id="documentations"
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
                            <p class="rounded-lg bg-green-500 px-2 py-0.5">{{ $row->status_pengerjaan_description }}
                            </p>
                            <p class="text-right italic">Oleh: {{ $row->addedBy->name }}</p>
                        </div>

                        <div class="flex flex-row justify-end gap-2 text-xs">
                            @can('laporan-fondasi-edit')
                                @if ($spk->added_by == auth()->id())
                                    <a class="cursor-pointer text-gray-500 hover:underline"
                                        wire:click="editLaporanFondasi('{{ $row->id }}')">Edit</a>
                                @endif
                            @endcan

                            @can('laporan-fondasi-delete')
                                <a class="cursor-pointer text-red-500 hover:underline"
                                    wire:click="deleteLaporanFondasi('{{ $row->id }}')">Delete</a>
                            @endcan
                        </div>
                    </div>
                @empty
                    <p class="text-center text-sm">
                        Belum ada laporan fondasi.
                    </p>
                @endforelse

                {{ $laporanFondasi->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </section>
    {{-- end laporan fondasi --}}

    {{-- modal tambah laporan Fondasi --}}
    <div id="laporan-fondasi-modal" wire:show="showModalAddLaporanFondasi" wire:transition.duration.300ms
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-70 py-8">

        @if ($showModalAddLaporanFondasi)
            <div class="mx-4 my-6 flex w-full flex-col gap-1 overflow-y-auto rounded-xl bg-white p-4 shadow-2xl dark:bg-dark-primary md:w-2/3 md:gap-2 lg:w-1/2 xl:w-2/5"
                style="max-height: calc(100vh - 6rem);">

                <h2 class="mb-2 text-center text-lg font-semibold text-gray-900 dark:text-white lg:text-xl">
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
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                for="documentations">Dokumentasi</label>


                            <div class="flex w-full flex-col gap-y-2">
                                <label for="documentation-input"
                                    class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-zinc-200 bg-gray-50 transition-all duration-500 hover:bg-gray-100 dark:border-zinc-800 dark:bg-gray-700 dark:hover:border-zinc-800 dark:hover:bg-gray-800">
                                    <div class="flex flex-col items-center justify-center pb-6 pt-5">
                                        <x-icons.cloud-upload class="mb-2 h-8 w-8 text-gray-500 dark:text-gray-400" />
                                        <p class="mb-0.5 text-sm text-gray-500 dark:text-gray-400">
                                            <span class="font-semibold"> Klik untuk upload</span>
                                        </p>
                                        <p class="w-full text-center text-xs text-gray-500 dark:text-gray-400">
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
                                        class="dark:highlight-white/5 relative min-w-0 overflow-auto rounded-xl border border-zinc-200 bg-gray-50 dark:border-zinc-800 dark:bg-gray-700">

                                        <div class="flex overflow-x-scroll">

                                            @foreach ($form->documentations as $index => $doc)
                                                <div class="flex-none px-1.5 py-3 first:pl-3 last:pr-3">
                                                    <div
                                                        class="relative flex flex-col items-center justify-center gap-3">
                                                        <img class="w-24 rounded-lg" src="{{ $doc->temporaryUrl() }}">
                                                        <button type="button"
                                                            class="absolute end-0 top-0 rounded-lg bg-red-500 p-1 text-white hover:bg-red-600"
                                                            wire:click="removeDocumentation({{ $index }})">
                                                            <x-icons.close class="h-4 w-4" />
                                                        </button>
                                                        <p class="text-xs text-gray-600 dark:text-white">
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

                                    <p class="text-xs text-gray-600 dark:text-gray-100">Total {{ $total ?? '0' }}
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
                        <x-button.success id="save-laporan-fondasi" type="submit">
                            <span wire:loading.remove
                                wire:target="{{ $isEditing ? 'updateLaporanFondasi' : 'storeLaporanFondasi' }}">
                                {{ $isEditing ? 'Update' : 'Simpan' }}
                            </span>
                            <span wire:loading
                                wire:target="{{ $isEditing ? 'updateLaporanFondasi' : 'storeLaporanFondasi' }}">
                                {{ $isEditing ? 'Mengupdate...' : 'Menyimpan...' }}
                            </span>
                        </x-button.success>

                        <x-button.primary id="close-modal-laporan-fondasi" wire:click="closeLaporanFondasiModal">
                            Batal
                        </x-button.primary>
                    </div>
                </form>

            </div>
        @endif

    </div>
    {{-- end modal tambah laporan fondasi --}}

    {{-- modal delete laporan fondasi --}}
    <div id="delete-laporan-fondasi-modal" wire:show="showModalDeleteLaporanFondasi" wire:transition.duration.300ms
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-70 py-8">

        @if ($showModalDeleteLaporanFondasi)
            <div class="mx-4 my-6 flex w-fit flex-col gap-2 overflow-y-auto rounded-xl bg-white p-4 shadow-2xl dark:bg-dark-primary"
                style="max-height: calc(100vh - 6rem);">

                <h2 class="text-center text-lg font-semibold text-gray-900 dark:text-white lg:text-xl">
                    Hapus Laporan Fondasi?
                </h2>

                <p class="text-center text-sm text-gray-700 dark:text-gray-100 lg:text-base">
                    Apakah anda yakin ingin menghapus Laporan ini?
                </p>

                <div class="flex flex-row justify-end gap-2">
                    <x-button.danger id="delete-laporan-fondasi" type="button"
                        wire:click="deleteLaporanFondasiAction">
                        <span wire:loading.remove wire:target="deleteLaporanFondasiAction">Hapus</span>
                        <span wire:loading wire:target="deleteLaporanFondasiAction">Loading</span>
                    </x-button.danger>

                    <x-button.primary id="cancel-delete-laporan-fondasi" type="button"
                        wire:click="$set('showModalDeleteLaporanFondasi', false)">
                        Batal
                    </x-button.primary>
                </div>

            </div>
        @endif

    </div>
    {{-- end modal delete laporan fondasi --}}

    @push('script')
        @vite('resources/js/pages/spk/show.js')
    @endpush
</div>
