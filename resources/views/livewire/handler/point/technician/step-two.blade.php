{{-- Goal: Display grouped technician points with optional selection, Livewire: StepTwo, Alpine: checkbox interaction --}}
<div class="mt-4 flex flex-col gap-4 text-zinc-800 dark:text-white">

    {{-- Select All / Deselect All (only in selected mode) --}}
    @if ($redeemMode === 'selected')
        <div class="flex items-center gap-3">
            <x-button.primary class="w-fit text-xs" type="button" wire:click="selectAll">
                Pilih Semua
            </x-button.primary>
            <x-button.secondary class="w-fit text-xs" type="button" wire:click="deselectAll">
                Hapus Semua
            </x-button.secondary>
            <span class="ml-auto text-xs text-zinc-500 dark:text-zinc-400">
                {{ count($selectedPegawai) }} teknisi dipilih
            </span>
        </div>
    @endif

    @foreach ($results as $kodePegawai => $data)
        @php
            $total = $data->sum('point');
            $isSelected = in_array($kodePegawai, $selectedPegawai);
        @endphp

        <div x-data="{ open: false }"
            class="overflow-hidden rounded-xl border shadow-sm backdrop-blur-md transition-all duration-300 {{ $isSelected ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/10' : 'border-zinc-200 bg-white/60 dark:border-zinc-800 dark:bg-zinc-900/60' }}">

            {{-- Header row --}}
            <div class="flex items-center gap-3 p-4">
                @if ($redeemMode === 'selected')
                    <button type="button" wire:click.stop="togglePegawai('{{ $kodePegawai }}')"
                        class="flex h-5 w-5 shrink-0 items-center justify-center rounded border transition-colors {{ $isSelected ? 'border-blue-500 bg-blue-500 text-white' : 'border-zinc-300 bg-white dark:border-zinc-600 dark:bg-zinc-800' }}">
                        @if ($isSelected)
                            <x-icons.check class="h-3 w-3" />
                        @endif
                    </button>
                @endif

                <div class="flex-1 cursor-pointer" @click="open = !open">
                    <p class="font-semibold text-zinc-900 dark:text-white">
                        {{ $kodePegawai }} —
                        {{ $data->first()->pegawai?->full_name ?? 'Teknisi belum terdaftar disistem.' }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <span
                        class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-bold text-green-700 dark:bg-green-900/30 dark:text-green-400">
                        {{ $total }} Poin
                    </span>
                    <button type="button" @click="open = !open"
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-zinc-100 transition-all duration-300 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700"
                        :class="open ? 'rotate-180 !bg-blue-50 dark:!bg-blue-900/30 text-blue-600' : 'text-zinc-500 dark:text-zinc-400'">
                        <x-icons.carred-down class="h-4 w-4" />
                    </button>
                </div>
            </div>

            {{-- Detail kunjungan --}}
            <div x-show="open" x-collapse x-cloak>
                <div class="border-t border-zinc-200 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:bg-zinc-800/30">
                    <div class="relative max-h-44 overflow-auto rounded-lg border border-zinc-200 bg-white p-2 shadow-inner dark:border-zinc-700 dark:bg-zinc-900">
                        @if ($data->count() > 5)
                            <div class="sticky top-0 z-10 w-full mb-2 bg-white pb-2 dark:bg-zinc-900">
                                <x-input.basic name="no_vt_{{ $kodePegawai }}"
                                    wire:input="searchKunjungan('{{ $kodePegawai }}')"
                                    wire:model.live="no_vt.{{ $kodePegawai }}" class="w-full" id="no_vt_{{ $kodePegawai }}"
                                    placeholder="Cari nomor kunjungan..." />
                            </div>
                        @endif

                        @php
                            $listData = $filteredKunjungan[$kodePegawai] ?? $data;
                        @endphp

                        @forelse ($listData as $item)
                            <div
                                class="mt-2 flex w-full items-center justify-between gap-2 text-center text-sm lg:text-base">
                                <p class="text-zinc-700 dark:text-zinc-300">{{ $item->from_vt }}</p>
                                <p class="font-semibold text-green-600 dark:text-green-400">+{{ $item->point }} Poin
                                </p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $item->updated_at->format('d M Y') }}</p>
                            </div>
                        @empty
                            <p class="text-center text-sm text-zinc-500 py-2">Tidak ada data kunjungan.</p>
                        @endforelse
                    </div>

                    <hr class="mt-4 border-zinc-200 dark:border-zinc-700">
                    <table class="mt-3 w-full text-right text-sm">
                        <tr>
                            <td class="text-left text-zinc-500 dark:text-zinc-400">Total Poin Valid</td>
                            <td class="font-semibold text-green-600 dark:text-green-400">{{ $total }} Poin</td>
                        </tr>
                        @php
                            $bonus = 0;
                            if ($total >= 150) {
                                $bonus = 100;
                            } elseif ($total >= 125) {
                                $bonus = 75;
                            } elseif ($total >= 100) {
                                $bonus = 50;
                            } elseif ($total >= 75) {
                                $bonus = 25;
                            }
                        @endphp
                        <tr>
                            <td class="text-left text-zinc-500 dark:text-zinc-400">Bonus</td>
                            <td class="font-semibold text-green-600 dark:text-green-400">+{{ $bonus }} Poin</td>
                        </tr>
                        <tr>
                            <td class="text-left font-semibold text-zinc-900 dark:text-white">Akumulasi</td>
                            <td class="font-bold text-green-600 dark:text-green-400">{{ $total + $bonus }} Poin</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>
