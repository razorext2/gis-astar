<div
    class="col-span-2 rounded-xl bg-white p-4 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 lg:p-6">

    <header class="mb-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            Tanda Tangan Digital
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            Tanda tangan digital kamu untuk template approval laporan.
        </p>
    </header>

    {{-- form tambah ttd digital --}}
    @if (!$myModel->hasBeenSigned())
        <div id="accordion-ttd-digital" x-data="{ accordionTtdOpen: false }">
            <x-button.success type="button" class="w-full flex-row-reverse justify-between rounded-lg p-5"
                @click="accordionTtdOpen = !accordionTtdOpen" ::class="accordionTtdOpen ? 'rounded-b-none border-b-0' : ''">
                <x-slot name="icon">
                    <span class="transition-all duration-300 ease-in-out" :class="accordionTtdOpen ? 'rotate-180' : ''">
                        <x-icons.carred-down class="h-4 w-4" />
                    </span>
                </x-slot>

                <h3 class="text-base font-semibold text-white">
                    Buat TTD Digital?
                </h3>
            </x-button.success>

            <div class="flex flex-col gap-2 rounded-b-lg border border-zinc-200 p-2 dark:border-zinc-800 lg:gap-4 lg:p-4"
                x-show="accordionTtdOpen" x-collapse x-cloak>
                <p class="text-base text-gray-600 dark:text-gray-400">
                    Silakan corat coret tanda tangan kamu dengan menggambar di canvas yang disediakan dibawah ini.
                </p>

                <form action="{{ $myModel->getSignatureRoute() }}" method="POST">
                    @csrf
                    <div style="text-align: center">
                        <x-creagia-signature-pad border-color="#eaeaea" pad-classes="rounded-xl border-2"
                            button-classes="bg-gray-100 dark:text-gray-800 mt-2.5 px-4 py-2 rounded-xl"
                            clear-name="Hapus" submit-name="Simpan" />
                    </div>

                    @push('script')
                        <script src="{{ asset('vendor/sign-pad/sign-pad.min.js') }}"></script>
                    @endpush
                </form>
            </div>
        </div>
    @else
        <x-button.secondary wire:click="$set('showModalShowSignature', true)"
            class="!gap-2 !bg-transparent !px-0 !py-0 !text-blue-500 !shadow-none hover:!bg-transparent hover:!text-blue-300 dark:hover:!text-blue-400">
            <x-slot name="icon">
                <x-icons.eye class="h-3 w-3" />
            </x-slot>
            Lihat Tanda Tangan Digital
        </x-button.secondary>
    @endif
    {{-- end form tambah ttd digital --}}

    {{-- modal delete laporan fondasi --}}
    <div id="delete-laporan-fondasi-modal" wire:show="showModalShowSignature" wire:transition.duration.300ms
        class="fixed inset-0 z-[99] flex items-center justify-center bg-zinc-950/65 py-8 backdrop-blur-sm">

        @if ($showModalShowSignature)
            <div
                class="mx-4 my-6 flex w-fit flex-col gap-2 overflow-y-auto rounded-xl bg-white p-4 shadow-2xl ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800">

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
