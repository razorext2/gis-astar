<div class="fixed left-0 right-0 top-0 z-[100] hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
    id="camera-modal">
    <div class="relative max-h-full w-full max-w-2xl p-4">
        <div class="relative rounded-xl bg-white shadow ring-1 ring-zinc-200 dark:bg-dark-secondary dark:ring-zinc-800">
            <div class="space-y-4 p-1">
                <div class="relative">
                    <!-- Video -->
                    <video class="rounded-lg" id="video" width="100%" height="auto" autoplay></video>

                    <!-- Button -->
                    <button
                        class="absolute bottom-4 left-1/2 h-14 w-14 -translate-x-1/2 transform rounded-full bg-white/60 shadow-lg ring-2 ring-white hover:bg-white/80 focus:outline-none md:bottom-6 md:h-16 md:w-16"
                        id="capture-image">
                        <x-icons.camera class="mx-auto h-8 w-8 text-white md:h-10 md:w-10" />
                    </button>

                    {{-- close button --}}
                    <button class="absolute right-2 top-2 h-auto w-auto transform focus:outline-none md:top-2"
                        id="close-button" data-modal-hide="camera-modal" type="button">
                        <x-icons.close class="h-8 w-8 text-red-600 hover:text-red-800" />
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>
