{{-- Goal: Render form to create Attendance Inquiry, Livewire: App\Livewire\Handler\AttendanceInquiry\Create, Alpine: Geolocation event handling --}}
<div class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-sm backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 md:p-6 lg:p-8"
    id="attendance-inquiry-create-container" x-data="{
        gpsStatus: 'loading',
        gpsError: ''
    }" @gps-success.window="gpsStatus = 'success'"
    @gps-failed.window="gpsStatus = 'failed'; gpsError = $event.detail.error" @gps-loading.window="gpsStatus = 'loading'">

    {{-- Header --}}
    <div class="flex items-center gap-3 border-b border-zinc-200 pb-4 dark:border-zinc-800">
        <x-button.danger wire:navigate href="{{ route('attendance-inquiry.my-inquiries.index') }}"
            class="max-h-10 max-w-fit">
            <x-icons.angle-left class="h-5 w-5" />
        </x-button.danger>
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Buat Laporan Absensi Baru</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Silakan isi formulir di bawah ini beserta bukti
                pendukung untuk diverifikasi HRD.</p>
        </div>
    </div>

    {{-- Form --}}
    <form wire:submit.prevent="save" class="mt-6 space-y-6">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            {{-- Tipe Absen --}}
            <div>
                <x-input.select id="type_absen" name="type_absen" wire:model.live="type_absen">
                    <x-slot name="label">Tipe Absen <span class="text-red-500">*</span></x-slot>
                    <option value="in">Masuk (Clock In)</option>
                    <option value="out">Keluar (Clock Out)</option>
                </x-input.select>
                @error('type_absen')
                    <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Status Rute --}}
            <div>
                <x-input.select id="position_status" name="position_status" wire:model.live="position_status">
                    <x-slot name="label">Status Kehadiran <span class="text-red-500">*</span></x-slot>
                    <option value="1">Dalam Perjalanan (On route)</option>
                    <option value="2">Standby</option>
                    <option value="3">Onsite (Di Kantor/Lokasi Kerja)</option>
                </x-input.select>
                @error('position_status')
                    <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tanggal dan Waktu --}}
            <div>
                <x-input.basic type="datetime-local" id="waktu_absen" name="waktu_absen" wire:model.live="waktu_absen">
                    Tanggal dan Waktu Absen <span class="text-red-500">*</span>
                </x-input.basic>
                @error('waktu_absen')
                    <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nomor VT --}}
            <div>
                <x-input.basic type="text" id="no_vt" name="no_vt" wire:model.live="no_vt"
                    placeholder="Contoh: VT-12345">
                    No. VT <span class="font-normal text-zinc-400">(Opsional)</span>
                </x-input.basic>
                @error('no_vt')
                    <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Geolocation Tracker UI Card --}}
        <div class="rounded-xl border p-4 shadow-sm transition-all duration-300"
            :class="{
                'bg-blue-50/50 border-blue-200 dark:bg-blue-900/10 dark:border-blue-800': gpsStatus === 'loading',
                'bg-green-50/50 border-green-200 dark:bg-green-900/10 dark:border-green-800': gpsStatus === 'success',
                'bg-amber-50/50 border-amber-200 dark:bg-amber-900/10 dark:border-amber-800': gpsStatus === 'failed'
            }">
            <div class="flex items-center gap-3">
                <template x-if="gpsStatus === 'loading'">
                    <x-icons.loading-circle class="h-6 w-6 animate-spin text-blue-600 dark:text-blue-400" />
                </template>
                <template x-if="gpsStatus === 'success'">
                    <x-icons.check-circle class="h-6 w-6 text-green-600 dark:text-green-400" />
                </template>
                <template x-if="gpsStatus === 'failed'">
                    <x-icons.exclamation-circle class="h-6 w-6 text-amber-600 dark:text-amber-400" />
                </template>

                <div class="flex-1">
                    <h4 class="text-sm font-bold text-zinc-900 dark:text-white">Status Lokasi Koordinat</h4>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400" x-show="gpsStatus === 'loading'">Mencari sinyal
                        GPS Anda...</p>
                    <p class="text-xs text-zinc-600 dark:text-zinc-300" x-show="gpsStatus === 'success'">
                        Lokasi terkunci: <strong x-text="$wire.latitude"></strong>, <strong
                            x-text="$wire.longitude"></strong>
                    </p>
                    <p class="text-xs text-zinc-600 dark:text-zinc-300" x-show="gpsStatus === 'failed'"
                        x-text="gpsError"></p>
                </div>

                <button type="button" @click="if (window.triggerGeoScan) window.triggerGeoScan()"
                    class="text-xs font-bold text-blue-600 hover:text-blue-500 dark:text-blue-400"
                    x-show="gpsStatus !== 'loading'">
                    Pindai Ulang
                </button>
            </div>
        </div>

        {{-- Keterangan --}}
        <div>
            <x-input.textarea id="keterangan" name="keterangan" wire:model.live="keterangan" rows="4"
                placeholder="Tulis alasan keterlambatan atau kegagalan absensi..." :textLabel="'Keterangan *'" />
            @error('keterangan')
                <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        {{-- Bukti (Multiple File Upload) --}}
        <div>
            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Foto Bukti (Dokumentasi Error /
                Bukti Kehadiran) <span class="text-red-500">*</span></label>

            <div
                class="mt-2 flex justify-center rounded-xl border border-dashed border-zinc-300 bg-zinc-50/50 px-6 py-6 dark:border-zinc-800 dark:bg-zinc-900/50">
                <div class="text-center">
                    <x-icons.cloud-upload class="mx-auto h-12 w-12 text-zinc-400" />
                    <div class="mt-4 flex text-sm text-zinc-600 dark:text-zinc-400">
                        <label for="bukti_files"
                            class="relative cursor-pointer rounded-md font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 hover:text-blue-500 dark:text-blue-400">
                            <span>Pilih beberapa file foto</span>
                            <input id="bukti_files" type="file" class="sr-only" wire:model.live="newBukti" multiple
                                accept="image/*">
                        </label>
                        <p class="pl-1">atau seret ke sini</p>
                    </div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-500">Format yang diterima: JPG, JPEG, PNG hingga 3MB
                        per file</p>
                </div>
            </div>

            <div wire:loading wire:target="newBukti" class="mt-2 text-xs text-blue-600">
                <x-icons.loading-circle class="mr-1 inline h-4 w-4 animate-spin" /> Mengunggah & memproses gambar...
            </div>

            @error('bukti')
                <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
            @enderror
            @error('bukti.*')
                <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
            @enderror
            @error('newBukti')
                <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
            @enderror
            @error('newBukti.*')
                <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
            @enderror

            {{-- Preview section --}}
            @if (!empty($this->bukti))
                <div class="mt-4 flex flex-col gap-2">
                    <div
                        class="scrollbar-thin scrollbar-thumb-zinc-200 dark:scrollbar-thumb-zinc-800 overflow-x-auto rounded-xl border border-zinc-200 bg-zinc-50 p-3 dark:border-zinc-800 dark:bg-zinc-900/50">
                        <div class="flex gap-4">
                            @foreach ($this->bukti as $index => $photo)
                                <div class="relative shrink-0">
                                    @if (method_exists($photo, 'temporaryUrl'))
                                        <img class="h-24 w-24 rounded-lg border border-zinc-200 object-cover dark:border-zinc-800"
                                            src="{{ $photo->temporaryUrl() }}"
                                            onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';">
                                    @endif
                                    <x-button.danger type="button"
                                        class="absolute -end-2 -top-2 !rounded-full !p-1 shadow-md"
                                        wire:click="removeBukti({{ $index }})">
                                        <x-slot name="icon">
                                            <x-icons.close class="h-3 w-3" />
                                        </x-slot>
                                    </x-button.danger>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">
                        Total {{ count($this->bukti) }} file dipilih.
                    </p>
                </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 border-t border-zinc-200 pt-6 dark:border-zinc-800">
            <x-button.secondary href="{{ route('attendance-inquiry.my-inquiries.index') }}" wire:navigate>
                Batal
            </x-button.secondary>
            <x-button.primary type="submit">
                Kirim Laporan
            </x-button.primary>
        </div>
    </form>
</div>

@push('script')
    @vite(['resources/js/pages/attendance-inquiry/create.js'])
@endpush
