{{-- Goal: Render form to create Attendance Inquiry, Livewire: App\Livewire\Handler\AttendanceInquiry\Create, Alpine: Geolocation event handling --}}
<div class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-sm backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 md:p-6 lg:p-8"
     id="attendance-inquiry-create-container"
     x-data="{
        gpsStatus: 'loading',
        gpsError: ''
     }"
     @gps-success.window="gpsStatus = 'success'"
     @gps-failed.window="gpsStatus = 'failed'; gpsError = $event.detail.error"
     @gps-loading.window="gpsStatus = 'loading'">
     
    {{-- Header --}}
    <div class="flex items-center gap-4 border-b border-zinc-200 pb-4 dark:border-zinc-800">
        <a href="{{ route('attendance-inquiry.my-inquiries.index') }}" wire:navigate class="rounded-lg border border-zinc-200 p-2 text-zinc-600 hover:bg-zinc-50 dark:border-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-800">
            <x-icons.arrow-left class="h-5 w-5" />
        </a>
        <div>
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white lg:text-2xl">Buat Laporan Absensi Baru</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Silakan isi formulir di bawah ini beserta bukti pendukung untuk diverifikasi HRD.</p>
        </div>
    </div>

    {{-- Form --}}
    <form wire:submit.prevent="save" class="mt-6 space-y-6">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            {{-- Tipe Absen --}}
            <div>
                <label for="type_absen" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Tipe Absen <span class="text-red-500">*</span></label>
                <select id="type_absen" wire:model.live="type_absen"
                    class="mt-1.5 block w-full rounded-lg border-zinc-200 bg-white/50 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-white">
                    <option value="in">Masuk (Clock In)</option>
                    <option value="out">Keluar (Clock Out)</option>
                </select>
                @error('type_absen') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Status Rute --}}
            <div>
                <label for="position_status" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Status Kehadiran <span class="text-red-500">*</span></label>
                <select id="position_status" wire:model.live="position_status"
                    class="mt-1.5 block w-full rounded-lg border-zinc-200 bg-white/50 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-white">
                    <option value="1">Dalam Perjalanan (On route)</option>
                    <option value="2">Standby</option>
                    <option value="3">Onsite (Di Kantor/Lokasi Kerja)</option>
                </select>
                @error('position_status') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Tanggal dan Waktu --}}
            <div>
                <label for="waktu_absen" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Tanggal dan Waktu Absen <span class="text-red-500">*</span></label>
                <input type="datetime-local" id="waktu_absen" wire:model.live="waktu_absen"
                    class="mt-1.5 block w-full rounded-lg border-zinc-200 bg-white/50 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-white" />
                @error('waktu_absen') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Nomor VT --}}
            <div>
                <label for="no_vt" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">No. VT <span class="text-zinc-400 font-normal">(Opsional)</span></label>
                <input type="text" id="no_vt" wire:model.live="no_vt" placeholder="Contoh: VT-12345"
                    class="mt-1.5 block w-full rounded-lg border-zinc-200 bg-white/50 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-white" />
                @error('no_vt') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
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
                    <x-icons.loading-circle class="h-6 w-6 text-blue-600 dark:text-blue-400 animate-spin" />
                </template>
                <template x-if="gpsStatus === 'success'">
                    <x-icons.check-circle class="h-6 w-6 text-green-600 dark:text-green-400" />
                </template>
                <template x-if="gpsStatus === 'failed'">
                    <x-icons.exclamation-circle class="h-6 w-6 text-amber-600 dark:text-amber-400" />
                </template>
                
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-zinc-900 dark:text-white">Status Lokasi Koordinat</h4>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400" x-show="gpsStatus === 'loading'">Mencari sinyal GPS Anda...</p>
                    <p class="text-xs text-zinc-600 dark:text-zinc-300" x-show="gpsStatus === 'success'">
                        Lokasi terkunci: <strong x-text="$wire.latitude"></strong>, <strong x-text="$wire.longitude"></strong>
                    </p>
                    <p class="text-xs text-zinc-600 dark:text-zinc-300" x-show="gpsStatus === 'failed'" x-text="gpsError"></p>
                </div>
                
                <button type="button" @click="if (window.triggerGeoScan) window.triggerGeoScan()" class="text-xs font-bold text-blue-600 hover:text-blue-500 dark:text-blue-400" x-show="gpsStatus !== 'loading'">
                    Pindai Ulang
                </button>
            </div>
        </div>

        {{-- Keterangan --}}
        <div>
            <label for="keterangan" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Keterangan <span class="text-red-500">*</span></label>
            <textarea id="keterangan" wire:model.live="keterangan" rows="4" placeholder="Tulis alasan keterlambatan atau kegagalan absensi..."
                class="mt-1.5 block w-full rounded-lg border-zinc-200 bg-white/50 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-white"></textarea>
            @error('keterangan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        {{-- Bukti (Multiple File Upload) --}}
        <div>
            <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Foto Bukti (Dokumentasi Error / Bukti Kehadiran) <span class="text-red-500">*</span></label>
            
            <div class="mt-2 flex justify-center rounded-xl border border-dashed border-zinc-300 bg-zinc-50/50 px-6 py-6 dark:border-zinc-800 dark:bg-zinc-900/50">
                <div class="text-center">
                    <x-icons.cloud-upload class="mx-auto h-12 w-12 text-zinc-400" />
                    <div class="mt-4 flex text-sm text-zinc-600 dark:text-zinc-400">
                        <label for="bukti_files" class="relative cursor-pointer rounded-md font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 hover:text-blue-500 dark:text-blue-400">
                            <span>Pilih beberapa file foto</span>
                            <input id="bukti_files" type="file" class="sr-only" wire:model="bukti" multiple accept="image/*">
                        </label>
                        <p class="pl-1">atau seret ke sini</p>
                    </div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-500">Format yang diterima: JPG, JPEG, PNG hingga 3MB per file</p>
                </div>
            </div>
            
            <div wire:loading wire:target="bukti" class="text-xs text-blue-600 mt-2">
                <x-icons.loading-circle class="inline h-4 w-4 animate-spin mr-1" /> Mengunggah & memproses gambar...
            </div>
            
            @error('bukti') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            @error('bukti.*') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror

            {{-- Preview section --}}
            @if (!empty($this->bukti))
                <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-6">
                    @foreach ($this->bukti as $index => $photo)
                        <div class="group relative rounded-lg border border-zinc-200 bg-white p-1 dark:border-zinc-800 dark:bg-zinc-900">
                            @if (method_exists($photo, 'temporaryUrl'))
                                <img src="{{ $photo->temporaryUrl() }}" class="h-24 w-full rounded object-cover">
                            @endif
                        </div>
                    @endforeach
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
