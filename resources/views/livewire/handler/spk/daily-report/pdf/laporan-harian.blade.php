<div class="flex flex-col gap-4" x-data="{ open: false, pdfUrl: '' }"
    x-on:show-pdf-modal.window="open = true; pdfUrl = $event.detail.url">

    <x-button.primary class="w-fit" id="summary-button" wire:click.prevent="previewPdf">
        Preview PDF
    </x-button.primary>

    @if ($showPreview)
        <!-- Overlay -->
        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-transition.opacity>
            <!-- Modal -->
            <div class="h-[85vh] w-[90vw] overflow-hidden rounded-lg bg-white text-gray-800 shadow-xl dark:bg-dark-secondary dark:text-white"
                @keydown.escape.window="open=false">
                <div class="flex items-center justify-between border-b px-4 py-2">
                    <h2 class="font-semibold">Laporan Harian Teknisi/Mekanik</h2>

                    <x-button.secondary class="!bg-transparent !p-1 !ring-0 hover:!bg-gray-100 dark:hover:!bg-gray-800" @click="open=false; $wire.set('showPreview', false)">
                        <x-slot name="icon">
                            <x-icons.close class="h-5 w-5 text-red-500" />
                        </x-slot>
                    </x-button.secondary>
                </div>

                <!-- Konten PDF: iframe -->
                <div class="h-[calc(85vh-48px)] w-full">
                    <iframe x-bind:src="pdfUrl" class="h-full w-full"
                        title="Laporan Harian Teknisi/Mekanik PDF" frameborder="0">
                    </iframe>
                </div>
            </div>
        </div>
    @endif

</div>
