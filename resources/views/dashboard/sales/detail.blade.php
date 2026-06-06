{{-- Goal: Display details of a sales report, Livewire: None, Alpine: None --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    @php
        $statusClasses = [
            0 => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
            1 => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            2 => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        ];

        $statusLabels = [
            0 => 'Sedang Diajukan',
            1 => 'Disetujui',
            2 => 'Ditolak',
        ];
    @endphp

    <div class="w-full space-y-4">
        {{-- Header / Main Info Card --}}
        <div class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:shadow-none lg:p-6">
            <header class="flex items-center">
                <x-button.danger href="{{ route('sales.index') }}" wire:navigate class="my-auto me-4 max-h-10">
                    <x-slot name="icon">
                        <x-icons.angle-left class="h-4 w-4" />
                    </x-slot>
                    Kembali
                </x-button.danger>

                <div>
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                        {{ $data->title ?? 'N/A' }}
                    </h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        Detail Laporan Sales
                    </p>
                </div>
            </header>
        </div>

        {{-- Metrics & Info Card --}}
        <div class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:shadow-none lg:p-6">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="space-y-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Nama Customer</p>
                    <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $data->customer_name ?? 'N/A' }}</p>
                </div>

                @php
                    $telp = $data->customer_telp;
                    if (Str::startsWith($telp, '08')) {
                        $telp = Str::replaceFirst('08', '628', $telp);
                    }
                @endphp
                <div class="space-y-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">No. WhatsApp</p>
                    <div class="flex flex-col gap-1.5 items-start">
                        <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $data->customer_telp ?? 'N/A' }}</p>
                        <a class="inline-flex items-center gap-1.5 rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-1.5 text-xs font-semibold text-zinc-700 hover:bg-zinc-100 transition dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-300 dark:hover:bg-zinc-800"
                            href="https://api.whatsapp.com/send?phone={{ $telp }}&text=Halo, %2A{{ ucwords(strtolower($data->title)) }}%2A. %0A%0ASaya %2A{{ auth()->user()->name }}%2A, marketing dari %2APT. Indodacin Presisi Utama%2A. Saya ingin menghubungi Anda terkait pesanan atau layanan yang mungkin Anda butuhkan.%0A%0AJika ada pertanyaan atau ingin berdiskusi lebih lanjut, silakan balas pesan ini.%0A%0ATerima kasih!%F0%9F%98%8A"
                            target="_blank">
                            Chat di Whatsapp
                            <x-icons.arrow-up class="h-3 w-3 rotate-45" />
                        </a>
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Sales</p>
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                            <x-icons.user class="h-5 w-5" />
                        </div>
                        <div>
                            <div class="flex items-center gap-x-2">
                                <p class="font-semibold text-zinc-900 dark:text-white">{{ $data->pegawaiRelasi->full_name ?? 'N/A' }}</p>
                                @if ($data->pegawaiRelasi?->userRelasi)
                                    <x-dashboard.badge-inactive :is_active="$data->pegawaiRelasi->userRelasi->is_active ?? true" />
                                @endif
                            </div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $data->kode_pegawai }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Status Validasi</p>
                    <div>
                        <span class="{{ $statusClasses[$data->status] ?? $statusClasses[0] }} inline-flex items-center rounded-lg px-3 py-1 text-sm font-bold">
                            {{ $statusLabels[$data->status] ?? 'Unknown' }}
                        </span>
                        @if (in_array($data->status, [1, 2]) && $data->validateBy)
                            <div class="mt-1 flex items-center gap-x-2 text-[10px] text-zinc-500 dark:text-zinc-400">
                                <span>Oleh: {{ $data->validateBy->name }}</span>
                                <x-dashboard.badge-inactive :is_active="$data->validateBy?->is_active ?? true" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <hr class="my-6 border-zinc-200 dark:border-zinc-800">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div class="space-y-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Waktu Dibuat</p>
                    <p class="font-semibold text-zinc-900 dark:text-white">
                        {{ $data->created_at ? $data->created_at->locale('id')->isoFormat('D MMM YYYY HH:mm:ss') : 'N/A' }}
                    </p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Waktu Diupdate</p>
                    <p class="font-semibold text-zinc-900 dark:text-white">
                        {{ $data->updated_at ? $data->updated_at->locale('id')->isoFormat('D MMM YYYY HH:mm:ss') : 'N/A' }}
                    </p>
                </div>
            </div>

            @can('sales-approve')
                @if ($data->status == 0)
                    <hr class="my-6 border-zinc-200 dark:border-zinc-800">
                    <div class="flex flex-col items-center justify-between gap-4 sm:flex-row" id="action">
                        <div class="hidden sm:block">
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Konfirmasi Laporan</p>
                            <p class="text-sm text-zinc-600 dark:text-zinc-300">Silahkan verifikasi laporan berikut:</p>
                        </div>
                        <div class="flex w-full items-center justify-end gap-3 text-right sm:w-auto">
                            <livewire:handler.sales.validate-sales :label="'Konfirmasi Laporan'" :id="$data->id" />
                        </div>
                    </div>
                @endif
            @endcan
        </div>

        {{-- Split Grid: Details & Map --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            
            {{-- Card: Keterangan Laporan --}}
            <div class="rounded-xl border border-zinc-200 bg-white/60 p-6 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:shadow-none">
                <h3 class="mb-4 flex items-center gap-2 text-lg font-bold text-zinc-900 dark:text-white">
                    <x-icons.book-open class="h-5 w-5 text-blue-500" />
                    Keterangan Laporan
                </h3>

                <div class="prose prose-sm dark:prose-invert prose-p:leading-relaxed prose-p:m-0 prose-ul:m-0 prose-li:m-0 quill-content max-w-none rounded-lg border border-zinc-100 bg-zinc-50 p-4 text-sm text-zinc-700 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-300"
                    id="editor">
                    {!! $data->keterangan ?? 'Belum diupdate.' !!}
                </div>

                @if ($data->notes)
                    <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-900/30 dark:bg-red-900/10">
                        <h4 class="flex items-center gap-2 text-sm font-bold text-red-800 dark:text-red-400">
                            <x-icons.exclamation-circle class="h-4 w-4" />
                            Catatan Internal / Penolakan:
                        </h4>
                        <p class="mt-1 text-sm text-red-700 dark:text-red-300">{{ $data->notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Card: Lokasi Checkpoint --}}
            <div class="rounded-xl border border-zinc-200 bg-white/60 p-6 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:shadow-none">
                <h3 class="mb-4 flex items-center gap-2 text-lg font-bold text-zinc-900 dark:text-white">
                    <x-icons.map-pin class="h-5 w-5 text-red-500" />
                    Lokasi Checkpoint
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
                            {{ $data->lokasi ?? 'Alamat tidak tersedia' }}
                        </p>
                    </div>
                    <div class="mt-2 flex gap-4 text-xs text-zinc-400">
                        <span>Lat: {{ $data->latitude }}</span>
                        <span>Long: {{ $data->longitude }}</span>
                    </div>
                @else
                    <p class="p-2 text-sm text-zinc-500 lg:p-4">Belum diupdate.</p>
                @endif
            </div>
        </div>

        {{-- Card: Hasil Kuesioner Validasi (jika sudah divalidasi dan ada data order) --}}
        @if ($data->status == 1 && $data->order_notes)
            <div class="rounded-xl border border-zinc-200 bg-white/60 p-6 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:shadow-none">
                <h3 class="mb-4 flex items-center gap-2 text-lg font-bold text-zinc-900 dark:text-white">
                    <x-icons.checklist-stepper class="h-5 w-5 text-green-500" />
                    Hasil Kuesioner Validasi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Apakah customer melakukan pembelian?</p>
                        <p class="text-sm font-bold text-zinc-900 dark:text-white mt-1">
                            {{ $data->customer_make_order == 1 ? 'Ya' : 'Tidak' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Catatan / Detail Order</p>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white mt-1">
                            {{ $data->order_notes }}
                        </p>
                    </div>
                    @if ($data->proof_picture)
                        <div class="col-span-full">
                            <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-2">Bukti Followup</p>
                            <div class="w-40 aspect-square overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                                <img src="{{ asset('storage/sales/proof/' . $data->proof_picture) }}" alt="Bukti Followup" id="documentations"
                                    data-url="{{ asset('storage/sales/proof/' . $data->proof_picture) }}"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                    class="h-full w-full cursor-pointer object-cover transition-transform duration-500 hover:scale-110"
                                    loading="lazy">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Documentation Card --}}
        <div class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:shadow-none lg:p-6">
            <h3 class="mb-4 flex items-center gap-2 text-lg font-bold text-zinc-900 dark:text-white">
                <x-icons.camera class="h-5 w-5 text-indigo-500" />
                Dokumentasi Lapangan
            </h3>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5" id="captured-images">
                @forelse ($data->photoCollectRelasi as $photo)
                    <div class="group relative aspect-square overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                        <img src="{{ asset($photo->photourl) }}" alt="Dokumentasi" id="documentations"
                            data-url="{{ asset($photo->photourl) }}"
                            onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                            class="h-full w-full cursor-pointer object-cover transition-transform duration-500 group-hover:scale-110"
                            loading="lazy">
                    </div>
                @empty
                    <div class="col-span-full flex h-32 flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 dark:border-zinc-800">
                        <x-icons.camera class="h-8 w-8 text-zinc-300" />
                        <p class="mt-2 text-sm text-zinc-500">Tidak ada foto dokumentasi</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
@push('script')
    @vite('resources/js/pages/sales/detail.js')
@endpush
