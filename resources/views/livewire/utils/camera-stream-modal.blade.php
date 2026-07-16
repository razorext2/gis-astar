{{-- Goal: Modal Overlay for Camera Streaming, Caller: Edit/Collect Views, Livewire: -, Alpine: dynamicBg --}}
<div>
    <!-- Backdrop -->
    <div class="fixed inset-0 z-[100] hidden bg-zinc-900/60 backdrop-blur-sm transition-opacity"
        id="camera-modal-backdrop" aria-hidden="true"></div>

    <!-- Modal Container -->
    <div class="fixed inset-0 z-[100] hidden items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6"
        id="camera-modal">
        <div
            class="relative w-full max-w-2xl transform overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-2xl transition-all dark:border-zinc-800 dark:bg-zinc-900">

            <!-- Header -->
            <div class="flex items-center justify-between border-b border-zinc-100 px-4 py-3 dark:border-zinc-800">
                <h3 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                    Ambil Foto
                </h3>
                <x-button.danger type="button" id="close-button" :iconOnly="true">
                    <x-icons.close class="h-5 w-5" />
                    <span class="sr-only">Tutup kamera</span>
                </x-button.danger>
            </div>

            <!-- Video Stream Container -->
            <div class="relative bg-zinc-100 dark:bg-zinc-950">
                <!-- Video -->
                <video class="w-full object-cover" id="video" autoplay playsinline></video>

                <!-- Capture Button (iOS Camera Style) -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 transform">
                    <x-button.secondary type="button" id="capture-image" :iconOnly="true" :pill="true"
                        class="!h-16 !w-16">
                        <x-icons.camera class="h-8 w-8" />
                        <span class="sr-only">Ambil foto</span>
                    </x-button.secondary>
                </div>
            </div>
        </div>
    </div>
</div>
