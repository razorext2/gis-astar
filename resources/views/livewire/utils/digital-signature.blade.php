{{-- Goal: Tanda tangan digital untuk template approval laporan di profil, Livewire: App\Livewire\Utils\DigitalSignature, Alpine: N/A --}}
<div class="col-span-2 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ?
        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

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
        <x-utils.accordion-item id="accordion-ttd-digital" title="Buat TTD Digital?"
            description="Silakan corat coret tanda tangan kamu dengan menggambar di canvas yang disediakan dibawah ini."
            iconColor="blue" :expanded="false" class="w-full">
            <x-slot:icon>
                <x-icons.file-pen class="h-4 w-4" />
            </x-slot:icon>

            <form action="{{ $myModel->getSignatureRoute() }}" method="POST">
                @csrf
                <div style="text-align: center">
                    <x-creagia-signature-pad border-color="#eaeaea" pad-classes="rounded-xl border-2"
                        button-classes="bg-zinc-100 dark:text-gray-800 mt-2.5 px-4 py-2 rounded-xl hover:bg-zinc-200 transition-colors"
                        clear-name="Hapus" submit-name="Simpan" redirect-url="{{ route('profile.edit') }}" />
                </div>

                @push('script')
                    <script src="{{ asset('vendor/sign-pad/sign-pad.min.js') }}"></script>
                @endpush
            </form>
        </x-utils.accordion-item>
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

    {{-- Modal Preview Signature --}}
    <x-modal.base-modal show="showModalShowSignature" maxWidth="md" title="Tanda Tangan Digital"
        iconContainerClass="bg-blue-600 shadow-blue-500/20">

        <x-slot name="icon">
            <x-icons.pen-nib class="h-5 w-5" />
        </x-slot>

        <div class="space-y-4">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Berikut adalah pratinjau tanda tangan digital yang tersimpan di sistem.
            </p>

            <div
                class="overflow-hidden rounded-xl border border-zinc-200 bg-zinc-100 p-6 dark:border-zinc-800 dark:bg-zinc-950">
                @if ($myModel->signature)
                    <img class="mx-auto max-h-48 w-auto object-contain transition-transform duration-300 hover:scale-105"
                        src="{{ asset('storage/' . $myModel->signature->getSignatureImagePath()) }}"
                        alt="Tanda Tangan Digital" />
                @endif
            </div>
        </div>

        <x-slot name="footer">
            <x-button.secondary type="button" wire:click="$set('showModalShowSignature', false)">
                Batal
            </x-button.secondary>

            <x-button.danger wire:click="removeSignature" class="justify-center" wire:loading.attr="disabled"
                wire:target="removeSignature">
                <x-slot name="icon">
                    <x-icons.trash wire:loading.remove wire:target="removeSignature" class="h-5 w-5" />
                    <x-icons.loading wire:loading wire:target="removeSignature" class="h-4 w-4 animate-spin" />
                </x-slot>

                <span wire:loading.remove wire:target="removeSignature">Hapus</span>
                <span wire:loading wire:target="removeSignature">Menghapus...</span>
            </x-button.danger>
        </x-slot>
    </x-modal.base-modal>

</div>
