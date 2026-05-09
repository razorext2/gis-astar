<form class="grid grid-cols-2 gap-2 lg:gap-4" wire:submit.prevent="store" method="POST" type="multipart/form-data">

    {{-- judul --}}
    <div class="col-span-2 w-full">
        <x-input.basic placeholder="Masukkan judul laporan..." id="judul" name="judul" wire:model="title">
            Judul Laporan
        </x-input.basic>

        @error('title')
            <span class="mt-2 text-xs text-red-500"> {{ $message }} </span>
        @enderror
    </div>
    {{-- end judul --}}

    {{-- status produksi --}}
    <div class="col-span-2 w-full">

        <p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Pilih Status Produksi</p>

        <div class="flex flex-col gap-y-2">
            @foreach ($statuses as $row)
                @php
                    $lastStatus = $row['value'] < $status_produksi;
                @endphp

                <div class="flex flex-row items-center">
                    <input id="radio-statuses-{{ $row['value'] }}" type="radio" value="{{ $row['value'] }}"
                        name="radio-statuses-{{ $row['value'] }}"
                        class="h-4 w-4 border-zinc-200 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-600 dark:ring-offset-gray-700 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-700"
                        wire:model="status_baru" {{ $lastStatus ? 'disabled' : '' }}>

                    <label for="radio-statuses-{{ $row['value'] }}"
                        class="{{ $lastStatus ? 'dark:text-gray-500 text-gray-700' : 'text-gray-900 dark:text-gray-300 ' }} ms-2 text-sm font-medium">
                        {{ $row['label'] }}
                    </label>

                    <p class="ms-2 text-sm text-green-500">
                        {{ $row['value'] == $status_produksi ? '(status terakhir)' : '' }}
                    </p>
                </div>
            @endforeach
        </div>

        @error('status_produksi')
            <span class="mt-2 text-xs text-red-500"> {{ $message }} </span>
        @enderror
    </div>
    {{-- end status Produksi --}}

    {{-- dokumentasi --}}
    <div class="col-span-2 w-full">
        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="documentations">
            Dokumentasi
        </label>

        <div class="flex w-full flex-col gap-y-2">
            <label for="documentations"
                class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-zinc-200 bg-gray-50 transition-all duration-500 hover:bg-gray-100 dark:border-zinc-800 dark:bg-gray-700 dark:hover:border-zinc-800 dark:hover:bg-gray-800">
                <div class="flex flex-col items-center justify-center pb-6 pt-5">
                    <x-icons.cloud-upload class="mb-2 h-8 w-8 text-gray-500 dark:text-gray-400" />
                    <p class="mb-0.5 text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-semibold"> Klik untuk upload</span>
                    </p>
                    <p class="w-full text-center text-xs text-gray-500 dark:text-gray-400">
                        *Dokumentasi berupa foto progres pengerjaan, berbentuk file <span class="font-semibold">JPG,
                            PNG, JPEG, ataupun BMP</span>
                    </p>

                    <p class="w-full text-center text-xs text-red-500">
                        *Max ukuran per file: <span class="font-semibold">2MB</span>
                    </p>
                </div>
                <input id="documentations" name="documentations" type="file"
                    accept=".jpg,.jpeg,.png,.heic,.bmp;capture=camera" wire:model.live="newDocumentations"
                    class="hidden" multiple />
            </label>
        </div>

        @if ($documentations)
            <div class="mt-2 flex flex-col gap-2">
                <div
                    class="dark:highlight-white/5 relative min-w-0 overflow-auto rounded-xl border border-zinc-200 bg-gray-50 dark:border-zinc-800 dark:bg-gray-700">

                    <div class="flex overflow-x-scroll">

                        @foreach ($documentations as $index => $doc)
                            <div class="flex-none px-1.5 py-3 first:pl-3 last:pr-3">
                                <div class="relative flex flex-col items-center justify-center gap-3">
                                    @php
                                        $isStoredDoc = is_array($doc);
                                        $src =
                                            $isStoredDoc && !empty($doc['path_file'])
                                                ? asset('storage/' . $doc['path_file'])
                                                : (method_exists($doc, 'temporaryUrl')
                                                    ? $doc->temporaryUrl()
                                                    : '');
                                    @endphp
                                    <img class="w-24 rounded-lg" src="{{ $src }}">
                                    <x-button.danger class="absolute end-0 top-0 !rounded-lg !p-1 !shadow-none"
                                        type="button" wire:click="removeDocumentation({{ $index }})">
                                        <x-icons.close class="h-4 w-4" />
                                    </x-button.danger>

                                    @php
                                        $name = $isStoredDoc
                                            ? $doc['nama_file'] ?? ''
                                            : (method_exists($doc, 'getClientOriginalName')
                                                ? $doc->getClientOriginalName()
                                                : '');
                                        $label =
                                            strlen($name) > 10
                                                ? substr($name, 0, 5) . '...' . substr($name, -5)
                                                : $name;
                                    @endphp
                                    <p class="text-xs text-gray-600 dark:text-white">
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

        @error('newDocumentations.*')
            <span class="mt-2 block text-xs text-red-500"> {{ $message }} </span>
        @enderror
        @error('documentations')
            <span class="mt-2 block text-xs text-red-500"> {{ $message }} </span>
        @enderror
        @error('documentations.*')
            <span class="mt-2 block text-xs text-red-500"> {{ $message }} </span>
        @enderror
    </div>
    {{-- end Dokumentasi --}}

    {{-- keterangan --}}
    <div class="col-span-2 w-full">
        <x-input.textarea :labels="true" :textLabel="'Keterangan'" id="deskripsi" name="deskripsi" rows="10"
            wire:model="keterangan" />

        @error('keterangan')
            <span class="mt-2 text-xs text-red-500"> {{ $message }} </span>
        @enderror
    </div>
    {{-- end keterangan --}}

    <div class="relative col-span-2 w-full">
        <x-button.success wire:target="store" class="float-right" id="store" type="submit"
            wire:loading.attr="disabled" wire:target="store">
            <x-slot name="icon">
                <x-icons.angle-right wire:loading.remove wire:target="store" class="icon h-5 w-5" />
                <x-icons.loading wire:loading wire:target="store" class="h-4 w-4 animate-spin" />
            </x-slot>

            <span wire:target="store" wire:loading.remove>Simpan Laporan</span>
            <span wire:target="store" wire:loading class="flex items-center gap-2">
                Memproses...
            </span>
        </x-button.success>
    </div>

</form>
