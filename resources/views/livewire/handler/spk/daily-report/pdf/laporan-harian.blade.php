<div class="flex flex-col gap-4">

    <x-button.primary class="w-fit" id="summary-button" wire:click.prevent="previewPdf">
        Preview PDF
    </x-button.primary>

    <x-modal.base-modal show="showPreview" maxWidth="6xl" title="Laporan Harian Teknisi/Mekanik"
        subtitle="Pratinjau Dokumen PDF">

        <x-slot name="icon">
            <x-icons.file-invoice class="h-5 w-5" />
        </x-slot>

        <div
            class="h-[70vh] w-full overflow-hidden border border-zinc-200 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-950">
            @if ($pdfUrl)
                <iframe src="{{ $pdfUrl }}" class="h-full w-full" title="Laporan Harian Teknisi/Mekanik PDF"
                    frameborder="0">
                </iframe>
            @else
                <div class="flex h-full items-center justify-center">
                    <x-icons.loading class="h-8 w-8 animate-spin text-zinc-400" />
                </div>
            @endif
        </div>

        <x-slot name="footer">
            <x-button.secondary wire:click="$set('showPreview', false)" class="w-full justify-center sm:w-auto">
                Tutup Pratinjau
            </x-button.secondary>
        </x-slot>
    </x-modal.base-modal>
</div>
