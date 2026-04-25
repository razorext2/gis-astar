{{-- Goal: Modal Overlay for Camera Streaming, Caller: Edit/Collect Views, Alpine: None --}}
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
                <button type="button"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-zinc-400 hover:bg-zinc-100 hover:text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-200 dark:hover:bg-zinc-800 dark:hover:text-white dark:focus:ring-zinc-700"
                    id="close-button">
                    <x-icons.close class="h-5 w-5" />
                    <span class="sr-only">Tutup kamera</span>
                </button>
            </div>

            <!-- Video Stream Container -->
            <div class="relative bg-zinc-100 dark:bg-zinc-950">
                <!-- Video -->
                <video class="w-full object-cover" id="video" autoplay playsinline></video>

                <!-- Gradient Overlay for Bottom Tools -->
                <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-black/60 to-transparent"></div>

                <!-- Capture Button (iOS Camera Style) -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 transform">
                    <button type="button" id="capture-image"
                        class="group relative flex h-16 w-16 items-center justify-center rounded-full bg-white/20 p-1 backdrop-blur-md transition-all hover:bg-white/30 focus:outline-none focus:ring-4 focus:ring-white/50 active:scale-95">
                        <div
                            class="h-full w-full rounded-full bg-white shadow-sm transition-transform group-hover:scale-90 group-active:scale-75">
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
