<div
    class="flex w-full flex-col items-center justify-center gap-2 rounded-lg p-2 border border-zinc-200 dark:bg-gray-700 dark:border-zinc-800 lg:gap-4 lg:p-4">

    <div class="flex w-full flex-row items-center justify-end gap-2">
        <p class="text-sm text-gray-800 dark:text-white">Filter:</p>

        <x-input.select class="w-12" name="status" id="status" :labels="false" :defaultOption="'Pilih status laporan'" :options="[0 => 'Diajukan', 1 => 'Disetujui', 2 => 'Ditolak', 3 => 'Semua']"
            wire:model.live.debounce.500ms="status_validasi" />
    </div>

    @forelse ($data as $row)
        <div
            class="flex w-full flex-col gap-2 border-b border-zinc-200 pb-2 text-gray-800 dark:border-zinc-800 dark:text-white">
            <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-8">
                <div class="text-right text-xs lg:text-left">
                    <p>Pukul {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('hh:mm:ss') }}</p>
                    <p>{{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, DD MMM YYYY') }}
                    </p>
                </div>

                <div class="flex flex-col">
                    <div class="flex flex-row items-center gap-2">
                        @php
                            $status_validasi = match ($row->status_validasi) {
                                0 => 'yellow',
                                1 => 'green',
                                2 => 'red',
                                3 => 'yellow',
                            };
                        @endphp

                        <h4 class="text-base font-semibold">{{ $row->judul }}</h4>

                        <span class="bg-{{ $status_validasi }}-500 rounded-lg px-2 py-0.5 text-xs text-white">
                            {{ $row->status_validasi_description }}
                        </span>
                    </div>
                    <p class="text-sm">
                        {{ $row->keterangan }}
                    </p>

                    @if (isset($row->documentations) && count($row->documentations) > 0)
                        <div class="mt-2 flex w-full flex-row gap-2 overflow-x-auto">
                            @foreach ($row->documentations as $i => $img)
                                <img class="h-20 w-20 rounded-xl object-cover" id="documentations"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                    data-url="{{ asset('storage/' . $img['path_file']) }}"
                                    src="{{ asset('storage/' . $img['path_file']) }}" alt=""
                                    onclick="javascript:void(0)" loading="lazy">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex flex-row justify-between text-xs">
                <span
                    class="rounded-lg bg-blue-500 px-2 py-0.5 text-white">{{ $row->status_produksi_description['label'] }}
                </span>
                <p class="text-right italic">Oleh: {{ $row->addedBy->name ?? 'Sistem' }}</p>
            </div>

            <div class="flex flex-row justify-end gap-2 text-xs">
                @if ($row->status_validasi == 0 && auth()->user()->hasPermissionTo('produksi-validate'))
                    <a class="cursor-pointer text-green-500 hover:underline"
                        wire:click="confirmProductionHistory('{{ $row->id }}')"
                        wire:confirm="Apakah anda yakin ingin mengkonfirmasi laporan ini?">Konfirmasi</a>

                    <a class="cursor-pointer text-red-500 hover:underline"
                        wire:click="rejectProductionHistory('{{ $row->id }}')"
                        wire:confirm="Apakah anda yakin ingin menolak laporan ini? laporan yang ditolak tidak akan muncul kembali.">
                        Tolak
                    </a>
                @endif

                @can('produksi-edit')
                    <a class="cursor-pointer text-gray-500 hover:underline" wire:navigate
                        href="{{ route('production.history.add', ['id' => $this->id, 'history_id' => $row->id]) }}">Ubah</a>
                @endcan

                @can('produksi-delete')
                    <a class="cursor-pointer text-red-500 hover:underline"
                        wire:click="deleteProductionHistory('{{ $row->id }}')"
                        wire:confirm.prompt="Apakah anda yakin ingin menghapus laporan ini?\nKetik HAPUS untuk mengkonfirmasi.|HAPUS">Hapus</a>
                @endcan
            </div>
        </div>
    @empty
        <p class="font-semibold text-gray-800 dark:text-white">
            Tidak ada riwayat produksi.
        </p>
    @endforelse

    {{ $data->links() }}
</div>
