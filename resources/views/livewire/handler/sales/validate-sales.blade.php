{{-- Goal: Modal interface for validating sales reports, Livewire: App\Livewire\Handler\Sales\ValidateSales, Alpine: None --}}
<div>
    @if ($label)
        <x-button.success class="float-right" wire:click="openModal({{ $id }})">
            <x-slot name="icon">
                <x-icons.angle-right class="h-4 w-4" />
            </x-slot>
            {{ $label }}
        </x-button.success>
    @endif

    <x-modal.base-modal show="showModal" maxWidth="3xl" :title="$step == 1 ? 'Konfirmasi Laporan' : ($step == 2 ? 'Konfirmasi Detail' : 'Alasan Penolakan')" :subtitle="$step == 1
        ? 'Review detail laporan di bawah ini'
        : ($step == 2
            ? 'Lengkapi detail berikut sebelum konfirmasi laporan'
            : 'Berikan alasan kenapa laporan ini harus ditolak')" :iconContainerClass="$step == 1
        ? 'bg-blue-600 shadow-blue-500/20'
        : ($step == 2
            ? 'bg-emerald-600 shadow-emerald-500/20'
            : 'bg-red-600 shadow-red-500/20')">

        <x-slot name="icon">
            <x-icons.clipboard-check class="h-5 w-5" />
        </x-slot>

        @if ($step == 1)
            @if ($showDetail)
                <div class="grid w-full gap-2 text-left md:grid-cols-2">
                    <x-detail.label label="Kode Pegawai" id="kode_pegawai">
                        {{ $data->kode_pegawai ?? 'N/A' }}
                    </x-detail.label>

                    <x-detail.label label="Nama Pegawai" id="nama_pegawai">
                        {{ $data->pegawaiRelasi?->full_name ?? 'N/A' }}
                    </x-detail.label>

                    <x-detail.label label="Waktu Dibuat" id="created_at">
                        {{ $data->created_at ?? 'N/A' }}
                    </x-detail.label>

                    <x-detail.label label="Waktu Diupdate" id="updated_at">
                        {{ $data->updated_at ?? 'N/A' }}
                    </x-detail.label>

                    <x-detail.label class="!col-span-2" label="Judul laporan" id="title">
                        {{ $data->title ?? 'N/A' }}
                    </x-detail.label>

                    <div
                        class="col-span-2 flex flex-col items-start rounded-xl border border-zinc-200 bg-zinc-50 p-3 dark:border-zinc-800 dark:bg-zinc-800/50">
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Customer</p>
                        <p class="text-base font-medium text-zinc-900 dark:text-white">
                            {{ $data->customer_name ?? 'N/A' }} (+{{ $customer_telp ?? 'N/A' }})
                        </p>
                        <a class="inline-flex text-base font-medium text-blue-600 underline hover:text-blue-700 dark:text-blue-400"
                            href="https://api.whatsapp.com/send?phone={{ $customer_telp ?? 'N/A' }}&text=Halo, %2A{{ ucwords(strtolower($data->title ?? 'N/A')) }}%2A. %0A%0ASaya marketing dari %2APT. Indodacin Presisi Utama%2A, perusahaan yang bergerak dibidang %2ATimbangan%2A. Saya ingin menghubungi Anda terkait pesanan atau layanan yang mungkin Anda butuhkan.%0A%0AJika ada pertanyaan atau ingin berdiskusi lebih lanjut, silakan balas pesan ini.%0A%0ATerima kasih!%F0%9F%98%8A"
                            target="_blank">
                            Chat customer
                        </a>
                    </div>

                    <div
                        class="col-span-2 flex flex-col items-start rounded-xl border border-zinc-200 bg-zinc-50 p-3 dark:border-zinc-800 dark:bg-zinc-800/50">
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Lokasi checkpoint</p>
                        <span
                            class="text-base font-medium text-zinc-900 dark:text-white">{{ $data->lokasi ?? 'N/A' }}</span>
                        <span class="text-left text-xs font-medium text-zinc-500">
                            <a class="inline-flex underline hover:text-zinc-700 dark:hover:text-zinc-300"
                                href="https://www.google.com/maps/search/?api=1&query={{ $data->latitude ?? 'N/A' }},{{ $data->longitude ?? 'N/A' }}"
                                target="_blank">
                                {{ $data->latitude ?? 'N/A' }}, {{ $data->longitude ?? 'N/A' }}
                            </a>
                        </span>
                    </div>

                    <div
                        class="col-span-2 flex flex-col items-start rounded-xl border border-zinc-200 bg-zinc-50 p-3 dark:border-zinc-800 dark:bg-zinc-800/50">
                        <p class="mb-2 text-sm text-zinc-600 dark:text-zinc-400">Dokumentasi</p>
                        <div class="relative flex w-full items-center gap-4 overflow-x-auto">
                            @php
                                $validPhotos = collect();
                                $hasPhotos = $data->photoCollectRelasi && $data->photoCollectRelasi->count() > 0;
                                if ($hasPhotos) {
                                    foreach ($data->photoCollectRelasi as $photo) {
                                        if (
                                            $photo->photourl &&
                                            file_exists(public_path(ltrim($photo->photourl, '/')))
                                        ) {
                                            $validPhotos->push($photo);
                                        }
                                    }
                                }
                            @endphp

                            @if ($validPhotos->count() > 0)
                                @foreach ($validPhotos as $photo)
                                    <div class="relative flex-none" wire:key="photo-{{ $photo->id }}">
                                        <img class="h-40 w-40 rounded-xl border border-zinc-200 object-cover transition duration-300 hover:scale-110 dark:border-zinc-700"
                                            id="documentations"
                                            onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                            src="{{ asset($photo->photourl) }}" alt="" loading="lazy">
                                    </div>
                                @endforeach
                            @elseif ($hasPhotos)
                                <div class="relative flex-none">
                                    <img class="h-40 w-40 rounded-xl border border-zinc-200 object-cover transition duration-300 hover:scale-110 dark:border-zinc-700"
                                        id="documentations" src="{{ asset('assets/img/noImage.webp') }}" alt="No Image"
                                        loading="lazy">
                                </div>
                            @else
                                <p class="font-medium text-zinc-800 dark:text-zinc-200"> Tidak ada dokumentasi
                                </p>
                            @endif
                        </div>
                    </div>

                    <x-detail.label label="Keterangan" id="keterangan" class="!col-span-2">
                        {{ strip_tags($data->keterangan ?? 'N/A') }}
                    </x-detail.label>

                    <div
                        class="col-span-2 flex flex-col items-start rounded-xl border border-zinc-200 bg-zinc-50 p-3 dark:border-zinc-800 dark:bg-zinc-800/50">
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Status</p>
                        <p class="pt-1.5 text-base font-medium" id="status">
                            <span
                                class="rounded-lg bg-yellow-100 px-3 py-1.5 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                                Sedang diajukan.
                            </span>
                        </p>
                    </div>
                </div>
            @else
                <p class="py-4 text-center text-zinc-800 dark:text-zinc-200">Apakah anda yakin ingin mengonfirmasi
                    laporan ini?</p>
            @endif
        @elseif($step == 2)
            <form id="form-validation" wire:submit="confirmValidation" enctype="multipart/form-data">
                <div class="flex w-full flex-col gap-4 text-zinc-800 dark:text-zinc-200">
                    <div>
                        <x-input.basic placeholder="Cth: Bp. Bintan" id="customer_name" name="customer_name"
                            wire:model="customer_name" required>
                            Nama Customer <span class="text-red-500 font-bold">*</span>
                        </x-input.basic>
                        @error('customer_name')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input.basic placeholder="Cth: Jl. xxx" id="customer_address" name="customer_address"
                            wire:model="customer_address" required>
                            Alamat Customer <span class="text-red-500 font-bold">*</span>
                        </x-input.basic>
                        @error('customer_address')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <span class="mb-2 block text-sm font-medium text-zinc-900 dark:text-zinc-100">
                            Apakah customer melakukan pembelian? <span class="text-red-500 font-bold">*</span>
                        </span>
                        <div class="mb-2 ms-1 flex items-center">
                            <input id="option-1" type="radio" name="customer_make_order"
                                wire:model="customer_make_order" value="1"
                                class="h-4 w-4 border-zinc-200 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:focus:ring-blue-600"
                                checked>
                            <label for="option-1"
                                class="ms-2 block text-sm font-medium text-zinc-900 dark:text-zinc-300">
                                Ya
                            </label>
                        </div>

                        <div class="ms-1 flex items-center">
                            <input id="option-2" type="radio" name="customer_make_order"
                                wire:model="customer_make_order" value="0"
                                class="h-4 w-4 border-zinc-200 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:focus:ring-blue-600">
                            <label for="option-2"
                                class="ms-2 block text-sm font-medium text-zinc-900 dark:text-zinc-300">
                                Tidak
                            </label>
                        </div>
                        @error('customer_make_order')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <span class="mb-2 block text-sm font-medium text-zinc-900 dark:text-zinc-100">
                            Apakah customer memberikan nomor telepon? <span class="text-red-500 font-bold">*</span>
                        </span>
                        <div class="mb-2 ms-1 flex items-center">
                            <input id="phone-option-1" type="radio" name="gives_phone_number"
                                wire:model.live="gives_phone_number" value="1"
                                class="h-4 w-4 border-zinc-200 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:focus:ring-blue-600">
                            <label for="phone-option-1"
                                class="ms-2 block text-sm font-medium text-zinc-900 dark:text-zinc-300">
                                Ya
                            </label>
                        </div>

                        <div class="ms-1 flex items-center">
                            <input id="phone-option-2" type="radio" name="gives_phone_number"
                                wire:model.live="gives_phone_number" value="0"
                                class="h-4 w-4 border-zinc-200 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:focus:ring-blue-600">
                            <label for="phone-option-2"
                                class="ms-2 block text-sm font-medium text-zinc-900 dark:text-zinc-300">
                                Tidak
                            </label>
                        </div>
                        @error('gives_phone_number')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">
                            Catatan <span class="text-red-500 font-bold">*</span>
                        </span>
                        <p class="mb-2 text-xs text-zinc-500 dark:text-zinc-400">
                            Jika customer order, sebutkan apa saja yg diorder. Jika tidak, jelaskan alasan
                            customer tidak order
                        </p>
                        <x-input.textarea :labels="false" id="order_notes" name="order_notes"
                            wire:model="order_notes" />
                        @error('order_notes')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                        x-on:livewire-upload-finish="uploading = false; progress = 0"
                        x-on:livewire-upload-cancel="uploading = false; progress = 0" x-on:livewire-upload-error="uploading = false; progress = 0"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <label class="mb-2 block text-sm font-medium text-zinc-900 dark:text-zinc-100"
                            for="proof_pic">
                            Bukti Followup Customer
                            @if ($gives_phone_number)
                                <span class="text-red-500 font-bold">*</span> <span class="text-xs text-red-500 font-normal">(Wajib)</span>
                            @else
                                <span class="text-xs text-zinc-400 font-normal">(Opsional)</span>
                            @endif
                        </label>

                        <div x-show="uploading"
                            class="mb-2 w-full overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-700">
                            <div class="rounded-full bg-blue-600 py-1 text-center text-xs font-medium leading-none text-white transition-all duration-300 ease-out"
                                x-bind:style="{ width: progress + '%' }"></div>
                        </div>

                        @if ($proof_pic)
                            <div class="mt-2 flex flex-col gap-2">
                                <div class="relative w-fit">
                                    <img class="h-32 w-32 rounded-xl border border-zinc-200 object-cover dark:border-zinc-800"
                                        src="{{ $proof_pic->temporaryUrl() }}" alt="Proof Picture">
                                    <button type="button"
                                        class="absolute -end-2 -top-2 inline-flex items-center justify-center rounded-full bg-red-600 p-1 text-white shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                        wire:click="removeProofPic">
                                        <x-icons.close class="h-3.5 w-3.5" />
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="flex w-full flex-col gap-y-2">
                                <label for="proof_pic"
                                    class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 bg-zinc-50 transition-all duration-500 hover:bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-900/50 dark:hover:border-zinc-700 dark:hover:bg-zinc-900">
                                    <div class="flex flex-col items-center justify-center pb-6 pt-5">
                                        <x-icons.cloud-upload class="mb-2 h-8 w-8 text-zinc-400 dark:text-zinc-500" />
                                        <p class="mb-0.5 text-sm font-semibold text-zinc-600 dark:text-zinc-400">
                                            Klik untuk upload
                                        </p>
                                        <p class="w-full text-center text-xs text-zinc-400 dark:text-zinc-500">
                                            PNG, JPG, JPEG (Maks. 2MB)
                                        </p>
                                    </div>
                                </label>
                            </div>
                        @endif

                        <input id="proof_pic" name="proof_pic" type="file" accept="image/*"
                            wire:model="proof_pic" class="hidden" />

                        @error('proof_pic')
                            <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </form>
        @elseif($step == 3)
            <div class="flex w-full flex-col gap-2 text-zinc-800 dark:text-zinc-200 md:gap-4">
                <x-input.textarea :labels="false" id="rejectionReason" name="rejectionReason"
                    wire:model="rejectionReason" placeholder="Tuliskan detail alasan penolakan di sini..." />
            </div>
        @endif

        <x-slot name="footer">
            <div class="flex w-full flex-col gap-2 sm:flex-row sm:justify-end">
                @if ($step == 1)
                    <x-button.secondary class="w-full justify-center sm:w-auto" wire:click="resetModal">
                        Batal
                    </x-button.secondary>
                    <x-button.danger class="w-full justify-center sm:w-auto" wire:click="toRejection">
                        Tolak
                    </x-button.danger>
                    <x-button.success class="w-full justify-center sm:w-auto" wire:click="toValidation">
                        Konfirmasi
                    </x-button.success>
                @elseif($step == 2)
                    <x-button.secondary class="w-full justify-center sm:w-auto" wire:click="resetModal">
                        Batal
                    </x-button.secondary>
                    @if ($label)
                        <x-button.danger class="w-full justify-center sm:w-auto" wire:click="toRejection">
                            Tolak
                        </x-button.danger>
                    @endif
                    <x-button.success class="w-full justify-center sm:w-auto" type="submit" form="form-validation"
                        wire:loading.attr="disabled" wire:target="proof_pic, confirmValidation">
                        <x-slot name="icon">
                            <x-icons.angle-right wire:loading.remove wire:target="proof_pic, confirmValidation"
                                class="icon h-5 w-5" />
                            <x-icons.loading wire:loading wire:target="proof_pic, confirmValidation"
                                class="h-4 w-4 animate-spin" />
                        </x-slot>

                        <span wire:loading wire:target="proof_pic">Uploading...</span>
                        <span wire:loading wire:target="confirmValidation">Menyimpan...</span>
                        <span wire:loading.remove wire:target="proof_pic, confirmValidation">Proses
                            Konfirmasi</span>
                    </x-button.success>
                @elseif($step == 3)
                    <x-button.secondary class="w-full justify-center sm:w-auto" wire:click="resetModal">
                        Batal
                    </x-button.secondary>
                    <x-button.danger class="w-full justify-center sm:w-auto" wire:click="confirmRejection"
                        wire:loading.attr="disabled" wire:target="confirmRejection">
                        <x-slot name="icon">
                            <x-icons.angle-right wire:loading.remove wire:target="confirmRejection"
                                class="icon h-5 w-5" />
                            <x-icons.loading wire:loading wire:target="confirmRejection"
                                class="h-4 w-4 animate-spin" />
                        </x-slot>

                        <span wire:loading wire:target="confirmRejection">Proses...</span>
                        <span wire:loading.remove wire:target="confirmRejection">Konfirmasi Penolakan</span>
                    </x-button.danger>
                @endif
            </div>
        </x-slot>
    </x-modal.base-modal>
</div>
