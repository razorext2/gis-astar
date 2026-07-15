{{-- Goal: Detail view for collector report with industrial glassmorphism, Livewire: Handler\Collect\Show, Alpine: Modal handling --}}
@php
    $customerName = match ($data->bill_type) {
        'idcnonppn' => $data->collectTaskRelasi?->customer_name,
        'idcppn' => $data->collectTaskPpnRelasi?->customer_name,
        'idyppn' => $data->collectIdyPpnRelasi?->customer_name,
        default => 'Unknown',
    };
    $totalBill = match ($data->bill_type) {
        'idcnonppn' => $data->collectTaskRelasi?->total_bill ?? 0,
        'idcppn' => $data->collectTaskPpnRelasi?->total_bill ?? 0,
        'idyppn' => $data->collectIdyPpnRelasi?->total_bill ?? 0,
        default => 0,
    };
    $remainingBill = match ($data->bill_type) {
        'idcnonppn' => $data->collectTaskRelasi?->remaining_bill ?? 0,
        'idcppn' => $data->collectTaskPpnRelasi?->remaining_bill ?? 0,
        'idyppn' => $data->collectIdyPpnRelasi?->remaining_bill ?? 0,
        default => 0,
    };
    $paymentTypeStr = match ((string) $data->payment_type) {
        '0' => 'Tidak ada',
        '1' => 'Cash',
        '2' => 'Transfer',
        '3' => "Giro ( {$data->no_giro} )",
        default => 'Belum pilih',
    };
@endphp

<div class="space-y-4">
    {{-- Header Info Card --}}
    <div
        class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">No. Tagihan / SR
                </p>
                <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $data->no_sr }}</p>
                <span
                    class="{{ $data->bill_type === 'idcnonppn' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300' }} inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
                    {{ strtoupper($data->bill_type) }}
                </span>
            </div>

            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Nama Customer
                </p>
                <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $customerName }}</p>
            </div>

            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Kolektor</p>
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                        <x-icons.user class="h-5 w-5" />
                    </div>
                    <div>
                        <div class="flex items-center gap-x-2">
                            <p class="font-semibold text-zinc-900 dark:text-white">
                                {{ $data->pegawaiRelasi?->full_name ?? 'N/A' }}
                            </p>
                            <x-dashboard.badge-inactive :is_active="$data->pegawaiRelasi?->userRelasi?->is_active ?? true" />
                        </div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $data->kode_pegawai }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Status Laporan
                </p>
                <div>
                    @php
                        $statusClasses = [
                            0 => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300', // Belum dilengkapi
                            1 => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400', // Approved
                            2 => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400', // Diajukan
                            3 => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400', // Ditolak
                            4 => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400', // Revisi
                        ];
                        $statusLabels = [
                            0 => 'Belum Lengkap',
                            1 => 'Approved',
                            2 => 'Menunggu Persetujuan',
                            3 => 'Ditolak',
                            4 => 'Perlu Revisi',
                        ];
                    @endphp
                    <span
                        class="{{ $statusClasses[$data->status] ?? $statusClasses[0] }} inline-flex items-center rounded-lg px-3 py-1 text-sm font-bold">
                        {{ $statusLabels[$data->status] ?? 'Unknown' }}
                    </span>
                    @if ($data->status === 1 && $data->validatedBy)
                        <p class="mt-1 text-[10px] text-zinc-500 dark:text-zinc-400">
                            Oleh: {{ $data->validatedBy->name }}
                            ({{ \Carbon\Carbon::parse($data->validated_at)->format('d M Y H:i') }})
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <hr class="my-6 border-zinc-200 dark:border-zinc-800">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Waktu Dibuat
                </p>
                <p class="font-semibold text-zinc-900 dark:text-white">
                    {{ $data->filled_at ? \Carbon\Carbon::parse($data->filled_at)->format('d M Y H:i:s') : 'Belum Diupdate..' }}
                </p>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Total Tagihan
                </p>
                <p class="font-semibold text-zinc-900 dark:text-white">
                    {{ Number::currency($totalBill, 'IDR', 'id') }}
                </p>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Sisa Tagihan
                </p>
                <p class="font-semibold text-zinc-900 dark:text-white">
                    {{ Number::currency($remainingBill, 'IDR', 'id') }}
                </p>
            </div>
        </div>

        @if ($data->status === 2 && auth()->user()->can('collect-approve'))
            <hr class="my-6 border-zinc-200 dark:border-zinc-800">
            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                <div class="hidden sm:block">
                    <p class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Konfirmasi
                        Laporan
                    </p>
                    <p class="text-sm text-zinc-600 dark:text-zinc-300">Silahkan verifikasi laporan berikut:</p>
                </div>
                <div class="flex w-full items-center justify-end gap-3 sm:w-auto">
                    <x-button.secondary wire:click="$set('showRevisionModal', true)"
                        class="border-amber-500/50 text-amber-600 hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-amber-900/20">
                        Minta Revisi
                    </x-button.secondary>
                    {{-- <x-button.danger wire:click="$set('showDenyModal', true)">
                        Tolak Laporan
                    </x-button.danger> --}}
                    <x-button.primary wire:click="confirm" wire:loading.attr="disabled" class="min-w-[140px]">
                        <x-slot name="icon">
                            <x-icons.loading class="h-4 w-4 animate-spin" wire:loading wire:target="confirm" />
                        </x-slot>

                        <span wire:loading.remove wire:target="confirm">Approve Laporan</span>
                        <span wire:loading wire:target="confirm">Memproses...</span>
                    </x-button.primary>
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        {{-- Payment Details Card --}}
        <div
            class="rounded-xl border border-zinc-200 p-6 shadow-md dark:border-zinc-800 dark:shadow-none"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <h3 class="mb-4 flex items-center gap-2 text-lg font-bold text-zinc-900 dark:text-white">
                <x-icons.cash class="h-5 w-5 text-blue-500" />
                Informasi Pembayaran
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between border-b border-zinc-100 pb-2 dark:border-zinc-800">
                    <span class="text-zinc-500 dark:text-zinc-400">Status Bayar</span>
                    @php
                        $paidStatus = [
                            '0' => ['label' => 'Belum Bayar', 'class' => 'text-red-500'],
                            '1' => ['label' => 'Cicil', 'class' => 'text-amber-500'],
                            '2' => ['label' => 'Lunas', 'class' => 'text-green-500'],
                            '3' => ['label' => 'Tanda Terima', 'class' => 'text-blue-500'],
                            '4' => ['label' => 'Ada Kendala', 'class' => 'text-red-600 font-bold'],
                            '5' => ['label' => 'Antar Bon Lunas', 'class' => 'text-indigo-500'],
                        ];
                        $currentPaid = $paidStatus[$data->have_paid] ?? [
                            'label' => 'Belum diupdate.',
                            'class' => 'text-zinc-500',
                        ];
                    @endphp
                    <span class="{{ $currentPaid['class'] }} font-bold">{{ $currentPaid['label'] }}</span>
                </div>
                <div class="flex justify-between border-b border-zinc-100 pb-2 dark:border-zinc-800">
                    <span class="text-zinc-500 dark:text-zinc-400">Metode Pembayaran</span>
                    <span class="font-semibold text-zinc-900 dark:text-white">{{ $paymentTypeStr }}</span>
                </div>
                <div class="flex justify-between border-b border-zinc-100 pb-2 dark:border-zinc-800">
                    <span class="text-zinc-500 dark:text-zinc-400">Jumlah Dibayar</span>
                    <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                        {{ Number::currency($data->payment_amount ?? 0, 'IDR', 'id') }}
                    </span>
                </div>
                @if ($data->no_giro && $data->no_giro !== '-')
                    <div class="flex justify-between border-b border-zinc-100 pb-2 dark:border-zinc-800">
                        <span class="text-zinc-500 dark:text-zinc-400">No. Giro / Referensi</span>
                        <span class="font-mono text-zinc-900 dark:text-white">{{ $data->no_giro }}</span>
                    </div>
                @endif
            </div>

            <div class="mt-6">
                <h4 class="mb-2 text-sm font-bold text-zinc-900 dark:text-white">Keterangan Kolektor:</h4>
                <div
                    class="prose prose-sm dark:prose-invert prose-p:leading-relaxed prose-p:m-0 prose-ul:m-0 prose-li:m-0 max-w-none rounded-lg border border-zinc-100 bg-zinc-50 p-4 text-sm text-zinc-700 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-300">
                    {!! $data->keterangan ?? 'Belum diupdate.' !!}
                </div>
            </div>

            @if ($data->notes)
                <div
                    class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-900/30 dark:bg-red-900/10">
                    <h4 class="flex items-center gap-2 text-sm font-bold text-red-800 dark:text-red-400">
                        <x-icons.exclamation-circle class="h-4 w-4" />
                        Catatan Internal:
                    </h4>
                    <p class="mt-1 text-sm text-red-700 dark:text-red-300">{{ $data->notes }}</p>
                </div>
            @endif
        </div>

        {{-- Location Card --}}
        <div
            class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <h3 class="mb-4 flex items-center gap-2 text-lg font-bold text-zinc-900 dark:text-white">
                <x-icons.map-pin class="h-5 w-5 text-red-500" />
                Lokasi Penagihan
            </h3>

            @if ($data->latitude && $data->longitude)
                <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <iframe class="h-[300px] w-full grayscale-[20%] dark:hue-rotate-180 dark:invert-[90%]"
                        frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                        src="https://maps.google.com/maps?q={{ $data->latitude }},{{ $data->longitude }}&hl=id&z=17&t=k&output=embed">
                    </iframe>
                </div>
                <div class="mt-4 flex items-start gap-2">
                    <x-icons.map-pin class="mt-1 h-4 w-4 shrink-0 text-zinc-400" />
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        {{ $data->location ?? 'Alamat tidak tersedia' }}
                    </p>
                </div>
                <div class="mt-2 flex gap-4 text-xs text-zinc-400">
                    <span>Lat: {{ $data->latitude }}</span>
                    <span>Long: {{ $data->longitude }}</span>
                </div>
            @else
                <p class="p-2 lg:p-4">Belum diupdate.</p>
            @endif

        </div>
    </div>

    {{-- Documentation Card --}}
    <div
        class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <h3 class="mb-4 flex items-center gap-2 text-lg font-bold text-zinc-900 dark:text-white">
            <x-icons.camera class="h-5 w-5 text-indigo-500" />
            Dokumentasi Lapangan
        </h3>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
            @forelse ($data->photoCollectRelasi as $photo)
                <div
                    class="group relative aspect-square overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <img src="{{ asset($photo->photourl) }}" alt="Dokumentasi" id="documentations"
                        data-url="{{ asset($photo->photourl) }}"
                        onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                        class="h-full w-full cursor-pointer object-cover transition-transform duration-500 group-hover:scale-110"
                        loading="lazy">
                </div>
            @empty
                <div
                    class="col-span-full flex h-32 flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 dark:border-zinc-800">
                    <x-icons.camera class="h-8 w-8 text-zinc-300" />
                    <p class="mt-2 text-sm text-zinc-500">Tidak ada foto dokumentasi</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modals --}}
    <x-modal.base-modal show="showDenyModal" title="Tolak Laporan" max-width="md">
        <p class="mb-4 text-sm text-zinc-600 dark:text-zinc-400">
            Harap berikan alasan mengapa laporan ini ditolak. Kolektor akan melihat catatan ini.
        </p>
        <div class="space-y-4">
            <div>
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Alasan
                    Penolakan</label>
                <textarea wire:model="notes" rows="4"
                    class="w-full rounded-xl border-zinc-200 bg-zinc-50 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white"
                    placeholder="Contoh: Foto tidak jelas, jumlah bayar tidak sesuai..."></textarea>
                @error('notes')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <x-button.secondary wire:click="$set('showDenyModal', false)">Batal</x-button.secondary>
                <x-button.danger wire:click="deny" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="deny">Ya, Tolak!</span>
                    <x-icons.loading wire:loading wire:target="deny" class="h-4 w-4 animate-spin" />
                </x-button.danger>
            </div>
        </div>
    </x-modal.base-modal>

    <x-modal.base-modal show="showRevisionModal" title="Minta Revisi" max-width="md">
        <p class="mb-4 text-sm text-zinc-600 dark:text-zinc-400">
            Berikan instruksi revisi kepada kolektor. Mereka dapat memperbaiki laporan ini sebanyak 1x.
        </p>
        <div class="space-y-4">
            <div>
                <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Instruksi
                    Revisi</label>
                <textarea wire:model="notes" rows="4"
                    class="w-full rounded-xl border-zinc-200 bg-zinc-50 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white"
                    placeholder="Contoh: Harap lampirkan foto bukti transfer yang lebih jelas..."></textarea>
                @error('notes')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <x-button.secondary wire:click="$set('showRevisionModal', false)">Batal</x-button.secondary>
                <x-button.primary wire:click="revision" wire:loading.attr="disabled"
                    class="bg-amber-600 hover:bg-amber-700">
                    <span wire:loading.remove wire:target="revision">Kirim Permintaan</span>
                    <x-icons.loading wire:loading wire:target="revision" class="h-4 w-4 animate-spin" />
                </x-button.primary>
            </div>
        </div>
    </x-modal.base-modal>
</div>
