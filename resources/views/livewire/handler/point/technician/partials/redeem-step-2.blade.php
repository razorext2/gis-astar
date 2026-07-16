<div class="flex flex-col gap-1">
    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
        {{ $redeemMode === 'selected' ? 'Pilih teknisi yang akan di-redeem.' : 'Validasi poin tiap teknisi.' }}
    </h3>
    <p class="text-xs text-zinc-500 dark:text-zinc-400 md:text-sm">
        Cek terlebih dahulu setiap data poin yang didapatkan oleh teknisi sebelum melanjutkan.
    </p>
</div>

@if ($results->isNotEmpty())
    <livewire:handler.point.technician.step-two :results="$result" :redeemMode="$redeemMode" key="step-two-{{ $step }}" />

    {{-- Action Bottom for Step 2 --}}
    <div
        class="mt-6 flex flex-col items-center justify-between gap-4 border-t border-zinc-200 pt-6 dark:border-zinc-800 sm:flex-row">
        <x-button.danger wire:click="$set('step', 1)" class="w-full sm:w-auto">
            <x-icons.angle-left class="h-5 w-5" />
        </x-button.danger>

        <x-button.success class="w-full sm:w-auto" wire:click="openModal">
            Lanjut Konfirmasi
            <x-slot name="icon">
                <x-icons.angle-right class="h-5 w-5" />
            </x-slot>
        </x-button.success>
    </div>

    {{-- Confirmation Modal --}}
    <x-modal.base-modal show="showModal" id="konfirmasi-redeem" title="Konfirmasi Pengajuan" subtitle="Verifikasi Data"
        maxWidth="lg" iconContainerClass="bg-blue-600 shadow-blue-500/20">
        <x-slot name="icon">
            <x-icons.info-circle class="h-5 w-5" />
        </x-slot>

        <p class="text-zinc-700 dark:text-zinc-300">
            Apakah anda yakin ingin melakukan redeem poin
            <b>{{ $redeemMode === 'selected' ? count($selectedPegawai) . ' teknisi terpilih' : 'semua teknisi' }}</b>
            untuk quartal <b>Q{{ $quarter }}</b> tahun <b>{{ $year }}</b>?
        </p>

        <x-slot name="footer">
            <x-button.danger wire:click="closeModal">Batal</x-button.danger>
            <x-button.success wire:click="validateData" wire:loading.attr="disabled" wire:target="validateData">
                <x-slot name="icon">
                    <x-icons.angle-right wire:loading.remove wire:target="validateData" class="icon h-5 w-5" />
                    <x-icons.loading wire:loading wire:target="validateData" class="h-4 w-4 animate-spin" />
                </x-slot>
                <span wire:loading.remove wire:target="validateData">Konfirmasi</span>
                <span wire:loading wire:target="validateData">Memproses...</span>
            </x-button.success>
        </x-slot>
    </x-modal.base-modal>
@else
    <div class="py-8 text-center">
        <p class="text-zinc-500 dark:text-zinc-400">Tidak ada data ditemukan.</p>
        <a href="{{ route('points.redeem', ['step' => 1]) }}"
            class="mt-2 inline-block text-blue-500 hover:underline dark:text-blue-400">Kembali</a>
    </div>
@endif
