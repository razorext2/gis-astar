{{-- Goal: Display production history list, Caller: production.show (Livewire), Livewire: Handler\ProductionHistories\HistoriesList --}}
<div class="flex w-full flex-col gap-6">

    {{-- Filter Header --}}
    <div class="flex items-center justify-between border-b border-zinc-100 pb-4 dark:border-zinc-800">
        <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
            Menampilkan {{ $data->total() }} riwayat
        </h3>

        <div class="flex items-center gap-2">
            <span class="text-xs font-medium text-zinc-400">Filter:</span>
            <x-input.select class="!py-1 text-xs" name="status" id="status" :labels="false"
                :defaultOption="'Semua Status'" :options="[0 => 'Diajukan', 1 => 'Disetujui', 2 => 'Ditolak', 3 => 'Semua']" wire:model.live.debounce.500ms="status_validasi" />
        </div>
    </div>

    {{-- Timeline List --}}
    <div class="relative space-y-8 before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-zinc-200 before:to-transparent dark:before:via-zinc-800 md:before:ml-[5.5rem]">
        @forelse ($data as $row)
            <div class="relative flex items-start gap-4 md:gap-8" wire:key="history-{{ $row->id }}">
                {{-- Date/Time Column --}}
                <div class="hidden shrink-0 flex-col items-end pt-1 md:flex md:w-20">
                    <span class="text-xs font-bold text-zinc-900 dark:text-white">
                        {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('HH:mm:ss') }}
                    </span>
                    <span class="text-[10px] text-zinc-500 dark:text-zinc-400">
                        {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('DD MMM YYYY') }}
                    </span>
                </div>

                {{-- Timeline Dot --}}
                <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-4 border-white bg-zinc-100 text-zinc-500 shadow-sm dark:border-zinc-900 dark:bg-zinc-800 dark:text-zinc-400">
                    @php
                        $icon = match ($row->status_validasi) {
                            1 => 'check',
                            2 => 'close',
                            default => 'clock',
                        };
                    @endphp
                    <x-dynamic-component :component="'icons.' . $icon" class="h-4 w-4" />
                </div>

                {{-- Content Card --}}
                <div class="flex flex-1 flex-col gap-3 rounded-xl border border-zinc-100 bg-white/40 p-4 shadow-sm backdrop-blur-sm dark:border-zinc-800 dark:bg-zinc-900/40">
                    <div class="flex flex-wrap items-start justify-between gap-2">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2">
                                <h4 class="text-sm font-bold text-zinc-900 dark:text-white">{{ $row->judul }}</h4>
                                
                                @php
                                    $badgeClasses = match ($row->status_validasi) {
                                        0 => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-900/20 dark:text-amber-400 dark:ring-amber-500/30',
                                        1 => 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-900/20 dark:text-green-400 dark:ring-green-500/30',
                                        2 => 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-900/20 dark:text-red-400 dark:ring-red-500/30',
                                        default => 'bg-zinc-50 text-zinc-700 ring-zinc-600/20 dark:bg-zinc-900/20 dark:text-zinc-400 dark:ring-zinc-500/30',
                                    };
                                @endphp
                                <span class="{{ $badgeClasses }} rounded-md px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider ring-1">
                                    {{ $row->status_validasi_description }}
                                </span>
                            </div>
                            <p class="text-xs font-medium text-zinc-500 md:hidden">
                                {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('HH:mm:ss, DD MMM YYYY') }}
                            </p>
                        </div>

                        <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-[10px] font-bold text-blue-600 ring-1 ring-blue-600/10 dark:bg-blue-900/30 dark:text-blue-400">
                            {{ $row->status_produksi_description['label'] }}
                        </span>
                    </div>

                    <p class="text-sm leading-relaxed text-zinc-600 dark:text-zinc-300">
                        {{ $row->keterangan }}
                    </p>

                    {{-- Documentations --}}
                    @if (isset($row->documentations) && count($row->documentations) > 0)
                        <div class="mt-2 flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                            @foreach ($row->documentations as $img)
                                <div class="group relative h-20 w-20 shrink-0 overflow-hidden rounded-lg ring-1 ring-zinc-200 dark:ring-zinc-700">
                                    <img class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
                                        onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                        src="{{ asset('storage/' . $img['path_file']) }}" 
                                        alt="Doc"
                                        loading="lazy">
                                    <div class="absolute inset-0 bg-black/0 transition-colors group-hover:bg-black/20"></div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Footer: Meta & Actions --}}
                    <div class="mt-2 flex items-center justify-between border-t border-zinc-100 pt-3 dark:border-zinc-800">
                        <div class="flex items-center gap-x-2 text-[10px] text-zinc-400 italic">
                            <span>Oleh: <span class="font-medium text-zinc-600 dark:text-zinc-400">{{ $row->addedBy->name ?? 'Sistem' }}</span></span>
                            @if ($row->addedBy)
                                <x-dashboard.badge-inactive :is_active="$row->addedBy?->is_active ?? true" />
                            @endif
                        </div>

                        <div class="flex items-center gap-4">
                            @if ($row->status_validasi == 0 && auth()->user()->hasPermissionTo('produksi-approve'))
                                <button wire:click="confirmProductionHistory('{{ $row->id }}')" 
                                    wire:confirm="Konfirmasi laporan ini?"
                                    class="text-xs font-bold text-green-600 hover:text-green-700 dark:text-green-400">
                                    Setujui
                                </button>
                                <button wire:click="rejectProductionHistory('{{ $row->id }}')" 
                                    wire:confirm="Tolak laporan ini?"
                                    class="text-xs font-bold text-red-600 hover:text-red-700 dark:text-red-400">
                                    Tolak
                                </button>
                            @endif

                            @can('produksi-edit')
                                <a href="{{ route('production.history.add', ['id' => $this->id, 'history_id' => $row->id]) }}" 
                                    wire:navigate
                                    class="text-xs font-medium text-zinc-500 hover:text-blue-600">Ubah</a>
                            @endcan

                            @can('produksi-delete')
                                <button wire:click="deleteProductionHistory('{{ $row->id }}')" 
                                    wire:confirm.prompt="Hapus laporan ini?\nKetik HAPUS untuk konfirmasi.|HAPUS"
                                    class="text-xs font-medium text-zinc-400 hover:text-red-600">Hapus</button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="rounded-full bg-zinc-100 p-4 dark:bg-zinc-800">
                    <x-icons.clipboard class="h-8 w-8 text-zinc-400" />
                </div>
                <h3 class="mt-4 text-sm font-semibold text-zinc-900 dark:text-white">Belum Ada Riwayat</h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">Laporan progres produksi akan muncul di sini.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $data->links(data: ['scrollTo' => false]) }}
    </div>
</div>
