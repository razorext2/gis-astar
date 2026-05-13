<div class="flex flex-col gap-1">
    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
        Pilih periode poin yang akan diredeem.
    </h3>
    <p class="text-xs text-zinc-500 dark:text-zinc-400 md:text-sm">
        Pilih tahun dan quartal, tanggal periode akan otomatis dihitung.
    </p>
</div>

<form wire:submit.prevent="process" class="mt-2 flex flex-col gap-4">
    @csrf

    {{-- Year + Quarter --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="flex flex-col gap-1">
            <x-input.select wire:model.live="year" id="year" name="year" :options="collect($this->availableYears)->mapWithKeys(fn($y) => [$y => $y])->toArray()"
                defaultOption="Pilih tahun" />
            @error('year')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col gap-1">
            <x-input.select wire:model.live="quarter" id="quarter" name="quarter" :options="[
                '1' => 'Kuarter 1',
                '2' => 'Kuarter 2',
                '3' => 'Kuarter 3',
                '4' => 'Kuarter 4',
            ]"
                defaultOption="Pilih quarter" />
            @error('quarter')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{-- Auto-calculated date range info --}}
    @if ($quarter && $year)
        <div
            class="flex flex-col gap-2 rounded-lg border border-zinc-200 bg-zinc-50/80 p-4 dark:border-zinc-800 dark:bg-zinc-800/50">
            <div class="flex items-center gap-2">
                <x-icons.calendar class="h-4 w-4 text-blue-500" />
                <span class="text-sm font-semibold text-zinc-900 dark:text-white">Periode Quartal</span>
            </div>
            <p class="text-sm text-zinc-700 dark:text-zinc-300">
                {{ $this->dateRange['from']->locale('id')->isoFormat('D MMMM Y') }}
                <span class="mx-1 text-zinc-400">s/d</span>
                {{ $this->dateRange['to']->locale('id')->isoFormat('D MMMM Y') }}
            </p>

            @if ($isQuartalRedeemed)
                <div
                    class="mt-1 flex items-center gap-2 rounded-md bg-amber-50 px-3 py-2 ring-1 ring-inset ring-amber-500/20 dark:bg-amber-900/20">
                    <svg class="h-4 w-4 shrink-0 text-amber-500" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 6a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 6Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-xs font-medium text-amber-700 dark:text-amber-400">
                        Quartal ini sudah pernah di-redeem. Anda masih bisa melihat summary atau redeem
                        teknisi yang belum di-redeem.
                    </p>
                </div>
            @endif
        </div>
    @endif

    {{-- Redeem Mode --}}
    <div class="flex flex-col gap-2">
        <label class="text-sm font-medium text-zinc-900 dark:text-white">Mode Redeem</label>
        <div class="flex flex-col gap-2 sm:flex-row sm:gap-4">
            <label
                class="{{ $redeemMode === 'all' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-zinc-200 dark:border-zinc-800' }} flex cursor-pointer items-center gap-3 rounded-lg border px-4 py-3 transition-colors">
                <input type="radio" wire:model.live="redeemMode" name="redeemMode" value="all"
                    class="text-blue-600 focus:ring-blue-500">
                <div>
                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">Redeem Semua</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Redeem poin semua teknisi sekaligus
                    </p>
                </div>
            </label>
            <label
                class="{{ $redeemMode === 'selected' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-zinc-200 dark:border-zinc-800' }} flex cursor-pointer items-center gap-3 rounded-lg border px-4 py-3 transition-colors">
                <input type="radio" wire:model.live="redeemMode" name="redeemMode" value="selected"
                    class="text-blue-600 focus:ring-blue-500">
                <div>
                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">Pilih Teknisi</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Pilih teknisi tertentu untuk di-redeem
                    </p>
                </div>
            </label>
        </div>
    </div>

    {{-- Submit --}}
    <div>
        <x-button.primary class="mx-auto" type="submit" id="proceed-accumulation" wire:loading.attr="disabled"
            wire:target="process">
            <x-slot name="icon">
                <x-icons.angle-right wire:loading.remove wire:target="process" class="icon h-5 w-5" />
                <x-icons.loading wire:loading wire:target="process" class="h-4 w-4 animate-spin" />
            </x-slot>
            <span wire:loading wire:target="process">Memproses...</span>
            <span wire:loading.remove wire:target="process">Akumulasikan</span>
        </x-button.primary>
    </div>
</form>
