{{-- Goal: Assign Laporan ke Staf Form, Livewire: Handler\Spk\DailyReport\Assign, Alpine: - --}}
<x-utils.accordion-item id="accordion-assign-report" title="Assign Laporan ke Staf?"
    description="Silakan perbarui informasi pengiriman pada form di bawah ini untuk barang yang telah selesai diproses."
    iconColor="green" :expanded="true" class="w-full">
    <x-slot:icon>
        <x-icons.user-setting class="h-4 w-4" />
    </x-slot:icon>

    <form wire:submit.prevent="store" class="grid gap-2 lg:grid-cols-2 lg:gap-4">

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

            <div class="flex items-center gap-2">
                <div class="relative flex-1">
                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <x-icons.search class="h-4 w-4 text-zinc-400" />
                    </div>

                    <x-input.basic class="ps-10" wire:model="form.no_vt" id="no_vt" name="no_vt"
                        placeholder="cth: VT-12345678" :labels="false" />
                </div>

                <x-button.primary type="button" wire:click="fetchVT" class="shrink-0 focus:outline" id="no_vt_submit"
                    wire:loading.attr="disabled" wire:target="fetchVT">
                    <x-slot name="icon">
                        <x-icons.search wire:loading.remove wire:target="fetchVT" class="icon h-5 w-5" />
                        <x-icons.loading wire:loading wire:target="fetchVT" class="h-4 w-4 animate-spin" />
                    </x-slot>

                    <span wire:loading.remove wire:target="fetchVT">Cek VT</span>
                    <span wire:loading wire:target="fetchVT">Memproses...</span>
                </x-button.primary>
            </div>

            @error('form.no_vt')
                <span class="error mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        @if (!empty($partnerData))
            <fieldset class="col-span-2 flex flex-col gap-2 lg:gap-4">
                @foreach ($partnerData as $row)
                    <div class="flex items-center" wire:key="partner-{{ $row['NomorIdentitasTeknisi'] }}">
                        <input value="{{ $row['NomorIdentitasTeknisi'] }}"
                            id="checkbox-{{ $row['NomorIdentitasTeknisi'] }}" type="checkbox"
                            wire:model="partner.{{ $row['NomorIdentitasTeknisi'] }}"
                            class="h-4 w-4 rounded-sm border-zinc-200 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">

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

        {{-- deskripsi (Quill Editor) --}}
        <div class="col-span-2 space-y-2" x-data="{
            quill: null,
            init() {
                this.quill = new Quill(this.$refs.editor, {
                    theme: 'snow',
                    placeholder: 'Tulis deskripsi projek di sini...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            ['code-block'],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }]
                        ]
                    }
                });

                this.quill.on('text-change', () => {
                    const rawText = this.quill.getText().trim();
                    const content = rawText === '' ? '' : this.quill.root.innerHTML;
                    $wire.set('form.description', content);
                });
            }
        }">
            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Deskripsi Projek *</label>
            <div wire:ignore class="notranslate [&_.ql-editor]:min-h-[350px]" translate="no">
                <div x-ref="editor" class="rounded-b-lg bg-white text-gray-900 dark:bg-gray-800 dark:text-white">
                </div>
            </div>

            @error('form.description')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        {{-- actions --}}
        <div class="col-span-2 flex justify-end gap-2">
            <x-button.primary type="submit" id="submitBtn" wire:loading.attr="disabled" wire:target="store">
                <x-slot name="icon">
                    <x-icons.plus wire:loading.remove wire:target="store" class="icon h-5 w-5" />
                    <x-icons.loading wire:loading wire:target="store" class="h-4 w-4 animate-spin" />
                </x-slot>

                <span wire:loading.remove wire:target="store">Simpan</span>
                <span wire:loading wire:target="store">Menyimpan...</span>
            </x-button.primary>
        </div>

    </form>
</x-utils.accordion-item>
