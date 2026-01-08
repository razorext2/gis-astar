<div
    class="col-span-2 rounded-xl bg-white p-4 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">

    <header class="mb-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            Tanda Tangan Digital
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            Tanda tangan digital kamu untuk template approval laporan.
        </p>
    </header>

    @if ($myModel->hasBeenSigned())
        <button wire:click="$set('showModalShowSignature', true)"
            class="flex items-center gap-2 text-blue-500 transition-colors duration-300 ease-in-out hover:text-blue-300">
            <span> Lihat Tanda Tangan Digital </span>
            <x-icons.eye class="h-3 w-3" />
        </button>
    @endif

    {{-- form tambah ttd digital --}}
    @if (!$myModel->hasBeenSigned())
        <div id="accordion-ttd-digital" x-data="{ accordionTtdOpen: false }">
            <button type="button"
                class="flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 p-5 font-medium text-gray-500 transition-all duration-300 ease-in-out hover:bg-blue-100 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-800"
                @click="accordionTtdOpen = !accordionTtdOpen"
                :class="accordionTtdOpen ? 'rounded-b-none border-b-0' : ''">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                    Buat TTD Digital?
                </h3>

                <span class="transition-all duration-300 ease-in-out" :class="accordionTtdOpen ? 'rotate-180' : ''">
                    <x-icons.carred-down class="h-4 w-4" />
                </span>
            </button>


            <div class="flex flex-col gap-2 rounded-b-lg border border-gray-200 p-2 dark:border-gray-700 lg:gap-4 lg:p-4"
                x-show="accordionTtdOpen" x-collapse x-cloak>
                <p class="text-base text-gray-600 dark:text-gray-400">
                    Silakan corat coret tanda tangan kamu dengan menggambar di canvas yang disediakan dibawah ini.
                </p>

                <form action="{{ $myModel->getSignatureRoute() }}" method="POST">
                    @csrf
                    <div style="text-align: center">
                        <x-creagia-signature-pad />
                    </div>

                    @push('script')
                        <script src="{{ asset('vendor/sign-pad/sign-pad.min.js') }}"></script>
                    @endpush
                </form>
            </div>
        </div>
    @endif
    {{-- end form tambah ttd digital --}}

    {{-- modal delete laporan fondasi --}}
    <div id="delete-laporan-fondasi-modal" wire:show="showModalShowSignature" wire:transition.duration.300ms
        class="fixed inset-0 z-[99] flex items-center justify-center bg-black bg-opacity-70 py-8">

        @if ($showModalShowSignature)
            <div
                class="mx-4 my-6 flex w-fit flex-col gap-2 overflow-y-auto rounded-xl bg-white p-4 shadow-2xl dark:bg-dark-primary">

                <h2 class="text-center text-lg font-semibold text-gray-900 dark:text-white lg:text-xl">
                    Tanda tangan digital kamu
                </h2>

                <div class="items-center">
                    <img class="w-full rounded-lg bg-gray-200 dark:bg-gray-400"
                        src="{{ asset('storage/' . $myModel->signature->getSignatureImagePath()) }}" />
                </div>

                <div class="flex flex-row justify-end gap-2">
                    <x-button.danger id="delete-laporan-fondasi" type="button" wire:click="removeSignature">
                        <span wire:loading.remove wire:target="removeSignature">Hapus</span>
                        <span wire:loading wire:target="removeSignature">Loading</span>
                    </x-button.danger>

                    <x-button.primary id="cancel-delete-laporan-fondasi" type="button"
                        wire:click="$set('showModalShowSignature', false)">
                        Batal
                    </x-button.primary>
                </div>

            </div>
        @endif

    </div>


</div>
