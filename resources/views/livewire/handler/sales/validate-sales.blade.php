<div>
    <x-button.success class="float-right" wire:click="$set('showModal', true)">
        <x-slot name="icon">
            <x-icons.angle-right class="h-5 w-5" />
        </x-slot>
        {{ $label }}
    </x-button.success>

    <div wire:show="showModal" wire:transition.duration.300ms
        class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-950/65 p-4 backdrop-blur-sm">
        @if ($showModal)
            <!-- Modal box -->
            <div
                class="flex w-full flex-col gap-1 rounded-xl ring-1 ring-zinc-200 bg-white p-2 shadow-2xl dark:ring-zinc-800 dark:bg-dark-primary md:w-2/3 md:gap-2 md:p-4 lg:w-1/2 lg:p-6 xl:w-2/5">
                @if ($step == 1)
                    <h2 class="mb-2 text-center text-2xl font-semibold text-gray-900 dark:text-white lg:text-3xl">
                        Konfirmasi?</h2>

                    @if ($showDetail)
                        <div class="grid max-h-[450px] w-full gap-1 overflow-auto text-left md:grid-cols-2">
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
                                class="col-span-2 flex flex-col items-start rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700">
                                <p class="text-sm text-gray-600 dark:text-gray-300">Customer</p>
                                <p class="text-navy-700 text-base font-medium dark:text-white">
                                    {{ $data->customer_name ?? 'N/A' }} (+{{ $customer_telp ?? 'N/A' }})
                                </p>
                                <a class="inline-flex text-base font-medium text-gray-800 underline dark:text-white"
                                    href="https://api.whatsapp.com/send?phone={{ $customer_telp ?? 'N/A' }}&text=Halo, %2A{{ ucwords(strtolower($data->title ?? 'N/A')) }}%2A. %0A%0ASaya marketing dari %2APT. Indodacin Presisi Utama%2A, perusahaan yang bergerak dibidang %2ATimbangan%2A. Saya ingin menghubungi Anda terkait pesanan atau layanan yang mungkin Anda butuhkan.%0A%0AJika ada pertanyaan atau ingin berdiskusi lebih lanjut, silakan balas pesan ini.%0A%0ATerima kasih!%F0%9F%98%8A"
                                    target="_blank">
                                    Chat customer
                                </a>
                            </div>

                            <div
                                class="col-span-2 flex flex-col items-start rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700">
                                <p class="text-sm text-gray-600 dark:text-gray-300">Lokasi checkpoint</p>
                                <span
                                    class="text-navy-700 text-base font-medium dark:text-white">{{ $data->lokasi ?? 'N/A' }}</span>
                                <span class="text-left text-xs font-medium text-gray-400">
                                    <a class="inline-flex underline"
                                        href="https://www.google.com/maps/search/?api=1&query={{ $data->latitude ?? 'N/A' }},{{ $data->longitude ?? 'N/A' }}"
                                        target="_blank">
                                        {{ $data->latitude ?? 'N/A' }}, {{ $data->longitude ?? 'N/A' }}
                                    </a>
                                </span>
                            </div>

                            <div
                                class="col-span-2 flex flex-col items-start rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700">
                                <p class="mb-2 text-sm text-gray-600 dark:text-gray-300">Dokumentasi</p>
                                <div class="relative mx-auto flex-none items-center gap-4 rounded-xl p-2">
                                    @if ($data->photoCollectRelasi && $data->photoCollectRelasi->count() > 0)
                                        @foreach ($data->photoCollectRelasi as $photo)
                                            <div class="relative me-2 flex-none items-center gap-4 rounded-xl p-2">
                                                <img class="h-52 w-52 rounded-xl object-cover transition duration-300 ease-in-out hover:scale-150 lg:hover:scale-[2]"
                                                    id="documentations"
                                                    onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                                    src="{{ asset($photo->photourl) }}" alt=""loading="lazy">
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="font-semibold text-gray-800 dark:text-white"> Tidak ada dokumentasi
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <x-detail.label label="Keterangan" id="keterangan">
                                {{ strip_tags($data->keterangan ?? 'N/A') }}
                            </x-detail.label>

                            <div
                                class="col-span-2 flex flex-col items-start rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                                <p class="text-sm text-gray-600 dark:text-gray-300">Status</p>
                                <p class="pt-1.5 text-base font-medium text-gray-800" id="status">
                                    <span
                                        class="rounded-xl bg-yellow-100 px-4 py-2 text-sm font-medium text-yellow-800 ring-1 ring-zinc-200">
                                        Sedang diajukan.
                                    </span>
                                </p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-800 dark:text-gray-200">Apakah anda yakin ingin mengonfirmasi laporan ini?
                        </p>
                    @endif

                    <div class="mt-4 flex justify-end space-x-2">
                        <x-button.success id="questionnaireBtn" type="submit" wire:click="toQuestionnaire">
                            <span> Konfirmasi </span>
                        </x-button.success>
                        <x-button.danger id="rejectionBtn" type="submit" wire:click="toRejection">
                            <span> Tolak </span>
                        </x-button.danger>
                        <x-button.primary id="cancelBtn" wire:click="resetModal">Batal</x-button.primary>
                    </div>
                @elseif($step == 2)
                    <form wire:submit="confirmQuestionnaire" enctype="multipart/form-data">
                        @csrf
                        <h2 class="mb-2 text-center text-2xl font-semibold text-gray-900 dark:text-white lg:text-3xl">
                            Kuisioner</h2>
                        <div
                            class="flex max-h-96 w-full flex-col gap-2 overflow-y-auto text-gray-800 dark:text-white md:gap-4">
                            <p>Jawab pertanyaan - pertanyaan berikut sebelum konfirmasi laporan.</p>

                            <div>
                                <x-input.basic placeholder="Cth: Bp. Bintan" id="customer_name" name="customer_name"
                                    wire:model="customer_name" required>
                                    Nama Customer
                                </x-input.basic>

                                @error('customer_name')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <x-input.basic placeholder="Cth: Jl. xxx" id="customer_address" name="customer_address"
                                    wire:model="customer_address" required>
                                    Alamat Customer
                                </x-input.basic>

                                @error('customer_address')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <span class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                    Apakah customer melakukan pembelian?
                                </span>
                                <div class="mb-2 ms-1 flex items-center">
                                    <input id="option-1" type="radio" name="customer_make_order"
                                        wire:model="customer_make_order" value="1"
                                        class="h-4 w-4 border-zinc-200 focus:ring-2 focus:ring-blue-300 dark:border-zinc-800 dark:bg-gray-700 dark:focus:bg-blue-600 dark:focus:ring-blue-600"
                                        checked>
                                    <label for="option-1"
                                        class="ms-2 block text-sm font-medium text-gray-900 dark:text-gray-300">
                                        Ya
                                    </label>
                                </div>

                                <div class="ms-1 flex items-center">
                                    <input id="option-2" type="radio" name="customer_make_order"
                                        wire:model="customer_make_order" value="0"
                                        class="h-4 w-4 border-zinc-200 focus:ring-2 focus:ring-blue-300 dark:border-zinc-800 dark:bg-gray-700 dark:focus:bg-blue-600 dark:focus:ring-blue-600">
                                    <label for="option-2"
                                        class="ms-2 block text-sm font-medium text-gray-900 dark:text-gray-300">
                                        Tidak
                                    </label>
                                </div>

                                @error('customer_make_order')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <span class="block text-sm font-medium text-gray-900 dark:text-white">
                                    Catatan
                                </span>
                                <p class="mb-2 text-wrap text-xs text-gray-500 dark:text-gray-400">
                                    Jika customer order, sebutkan apa saja yg diorder. Jika tidak, jelaskan alasan
                                    customer tidak order
                                </p>
                                <x-input.textarea :labels="false" id="order_notes" name="order_notes"
                                    wire:model="order_notes" />

                                @error('order_notes')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                                x-on:livewire-upload-finish="uploading = false"
                                x-on:livewire-upload-cancel="uploading = false"
                                x-on:livewire-upload-error="uploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                    for="user_avatar">Bukti Followup
                                    Customer</label>

                                <div x-show="uploading" class="mb-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                    <div class="rounded-full bg-blue-600 py-1 text-center text-xs font-medium leading-none text-blue-100"
                                        x-bind:style="{ width: progress + '%' }"> </div>
                                </div>

                                @if ($proof_pic)
                                    <img src="{{ $proof_pic->temporaryUrl() }}" alt="Proof Picture"
                                        class="mb-2 max-h-44 w-full rounded-lg object-cover">

                                    <x-button.danger class="!px-2.5 !py-1 !text-xs"
                                        type="button" wire:click="$cancelUpload('proof_pic')">
                                        Cancel Upload
                                    </x-button.danger>
                                @endif

                                <input
                                    class="block w-full cursor-pointer rounded-lg border border-zinc-200 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-zinc-800 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                                    id="proof_pic" name="proof_pic" wire:model="proof_pic" type="file">

                                @error('proof_pic')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end space-x-2">
                            <x-button.success id="confirmQuestionnaireBtn" type="submit">
                                <span wire:loading wire:target="proof_pic">Uploading...</span>
                                <span wire:loading wire:target="confirmQuestionnaireBtn">Menyimpan...</span>
                                <span wire:loading.remove wire:target="proof_pic, confirmQuestionnaireBtn">Proses
                                    Konfirmasi</span>
                            </x-button.success>
                            <x-button.primary id="cancelBtn" wire:click="resetModal">Batal</x-button.primary>
                        </div>
                    </form>
                @elseif($step == 3)
                    <h2 class="mb-4 text-center text-2xl font-semibold text-gray-900 dark:text-white lg:text-3xl">
                        Alasan Penolakan
                    </h2>
                    <div class="flex w-full flex-col gap-2 text-gray-800 dark:text-white md:gap-4">
                        <p>Berikan alasan kenapa laporan ini harus ditolak:</p>
                        <x-input.textarea :labels="false" id="rejectionReason" name="rejectionReason"
                            wire:model="rejectionReason" />
                    </div>

                    <div class="mt-4 flex justify-end space-x-2">
                        <x-button.success id="confirmRejectionBtn" type="submit" wire:click="confirmRejection">
                            <span> Konfirmasi Penolakan </span>
                        </x-button.success>
                        <x-button.primary id="cancelBtn" wire:click="resetModal">Batal</x-button.primary>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
