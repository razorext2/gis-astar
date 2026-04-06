<div id="accordion-packing-form" x-data="{ accordionOpen: true }">
    <button type="button"
        class="flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 p-5 font-medium text-gray-500 transition-all duration-300 ease-in-out hover:bg-blue-100 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-800"
        @click="accordionOpen = !accordionOpen" :class="accordionOpen ? 'rounded-b-none border-b-0' : ''">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white">
            Assign Laporan ke Staf?
        </h3>

        <span class="transition-all duration-300 ease-in-out" :class="accordionOpen ? 'rotate-180' : ''">
            <x-icons.carred-down class="h-4 w-4" />
        </span>
    </button>

    <div class="rounded-b-lg border border-gray-200 p-5 dark:border-gray-700" x-show="accordionOpen" x-collapse x-cloak>
        <div id="delivery-history-add-form" class="w-full">
            <p class="text-base text-gray-600 dark:text-gray-400">
                Silakan perbarui informasi pengiriman pada form dibawah ini untuk barang yang telah selesai
                diproses.
            </p>

            <form type="post" wire:submit.prevent="store" class="mt-2 grid gap-2 lg:grid-cols-2 lg:gap-4">

                {{-- nama customer --}}
                <div class="col-span-2">
                    <x-input.basic id="customer_name" name="customer_name" placeholder="Input nama customer..."
                        wire:model="form.customer_name">
                        Nama Customer
                    </x-input.basic>

                    @error('form.customer_name')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- nama project --}}
                <div class="col-span-2">
                    <x-input.basic id="project_name" name="project_name" placeholder="Input nama projek..."
                        wire:model="form.project_name">
                        Nama Projek
                    </x-input.basic>

                    @error('form.project_name')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- fetch vt --}}
                <div class="col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="no_vt">
                        Cari No. VT
                    </label>

                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                            <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400" />
                        </div>

                        <x-input.basic class="ps-10" wire:model="form.no_vt" id="no_vt" name="no_vt"
                            placeholder="cth: VT-12345678" :labels="false" />

                        <x-button.primary type="button" wire:click="fetchVT"
                            class="absolute bottom-[1px] end-0 focus:outline" id="no_vt_submit">
                            Cek VT
                        </x-button.primary>
                    </div>

                    @error('form.no_vt')
                        <span class="error mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                @if (!empty($partnerData))
                    <fieldset class="col-span-2 flex flex-col gap-2 lg:gap-4">
                        @foreach ($partnerData as $row)
                            <div class="flex items-center">
                                <input value="{{ $row['NomorIdentitasTeknisi'] }}"
                                    id="checkbox-{{ $row['NomorIdentitasTeknisi'] }}" type="checkbox"
                                    wire:model="partner.{{ $row['NomorIdentitasTeknisi'] }}"
                                    class="h-4 w-4 rounded-sm border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">

                                <label for="checkbox-{{ $row['NomorIdentitasTeknisi'] }}"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    [{{ $row['NomorKunjungan'] }}] - ({{ $row['NomorIdentitasTeknisi'] }})
                                    {{ $row['NamaTeknisi'] }}
                                </label>
                            </div>
                        @endforeach
                    </fieldset>
                @endif

                {{-- waktu mulai --}}
                <div class="col-span-2 lg:col-span-1">
                    <x-input.basic id="start_date" name="start_date" wire:model="form.start_date" type="date">
                        Waktu Mulai
                    </x-input.basic>

                    @error('form.start_date')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- waktu selesai --}}
                <div class="col-span-2 lg:col-span-1">
                    <x-input.basic id="end_date" name="end_date" wire:model="form.end_date" type="date">
                        Waktu Selesai
                    </x-input.basic>

                    @error('form.end_date')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- deskripsi --}}
                <div class="col-span-2">
                    <x-input.textarea id="description" name="description" wire:model="form.description"
                        :textLabel="'Deskripsi Projek'" />

                    @error('form.description')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- actions --}}
                <div class="col-span-2 flex justify-end gap-2">
                    <x-button.primary type="submit" id="submitBtn">
                        <span wire:loading.remove wire:target="store">Simpan</span>
                        <span wire:loading wire:target="store">Menyimpan...</span>
                    </x-button.primary>
                </div>

            </form>
        </div>
    </div>
</div>
