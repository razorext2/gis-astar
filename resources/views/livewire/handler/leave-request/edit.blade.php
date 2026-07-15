<div
    class="mt-4 flex flex-col gap-6 rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary md:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
    {{-- Breadcrumbs/Header --}}
    <div class="flex items-center gap-3">
        <x-button.danger wire:navigate href="{{ route('leave-request.my-requests.index') }}" class="max-h-10 max-w-fit">
            <x-icons.angle-left class="h-5 w-5" />
        </x-button.danger>

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Edit Pengajuan #{{ $requestId }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Anda dapat mengubah detail pengajuan selama belum disetujui oleh HRD.
            </p>
        </div>
    </div>

    <form wire:submit.prevent="update" class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Left Column: Main Form --}}
        <div class="flex flex-col gap-6 lg:col-span-2">
            <div
                class="flex flex-col gap-5 rounded-xl border border-zinc-200 p-6 shadow-md dark:border-zinc-800"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

                <div class="mb-2 flex items-center gap-2">
                    <div class="h-8 w-1 rounded-full bg-primary"></div>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">Informasi Cuti</h2>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div class="flex flex-col">
                        <x-input.select id="leave_type_id" name="leave_type_id" wire:model.live="leave_type_id"
                            :options="$leaveTypes->pluck('name', 'id')->toArray()" :defaultOption="'Pilih Tipe Cuti'" :labels="true" :textLabel="'Tipe Cuti'" required />
                        @error('leave_type_id')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label class="mb-1 block text-sm font-bold text-gray-700 dark:text-gray-300">
                            Personel Backup
                        </label>
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            {{-- Search Input / Trigger --}}
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.300ms="search_backup"
                                    @focus="open = true" placeholder="Cari Nama atau Kode Pegawai..."
                                    class="w-full rounded-xl border border-zinc-200 py-3 pl-4 pr-10 text-sm transition-all focus:ring-red-500/50 dark:border-zinc-800 dark:bg-gray-800/50 dark:text-gray-200"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <x-icons.search class="h-4 w-4 text-gray-400" />
                                </div>
                            </div>

                            {{-- Dropdown Results --}}
                            <div x-show="open && $wire.search_backup.length > 0"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="absolute z-50 mt-2 max-h-60 w-full overflow-y-auto rounded-xl border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-dark-primary"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

                                @forelse ($employees as $emp)
                                    <button type="button"
                                        wire:click="selectBackupPerson({{ $emp->id }}, '{{ $emp->name }}')"
                                        @click="open = false"
                                        class="{{ $backup_person_id == $emp->id ? 'bg-red-50 dark:bg-red-900/20' : '' }} flex w-full items-center justify-between px-4 py-3 text-left transition-colors hover:bg-zinc-50 dark:hover:bg-white/5">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-bold text-zinc-900 dark:text-white">{{ $emp->name }}</span>
                                            <span class="text-[10px] text-gray-500">{{ $emp->kode_pegawai }}</span>
                                        </div>
                                        @if ($backup_person_id == $emp->id)
                                            <x-icons.check-circle class="h-4 w-4 text-red-500" />
                                        @endif
                                    </button>
                                @empty
                                    <div class="px-4 py-3 text-center text-xs text-gray-500">
                                        Tidak ada data ditemukan
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        @error('backup_person_id')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div class="flex flex-col">
                        <x-input.basic type="date" id="start_date" name="start_date" wire:model.live="start_date"
                            min="{{ \Carbon\Carbon::today()->addDays(config('app.leave_min_advance_days', 7))->toDateString() }}"
                            :labels="true" required>
                            Tanggal Mulai
                        </x-input.basic>
                        @error('start_date')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <x-input.basic type="date" id="end_date" name="end_date" wire:model.live="end_date"
                            min="{{ $start_date ?? \Carbon\Carbon::today()->addDays(config('app.leave_min_advance_days', 7))->toDateString() }}"
                            :labels="true" required>
                            Tanggal Berakhir
                        </x-input.basic>
                        @error('end_date')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @if ($dateOverlapError)
                    <div
                        class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50/70 p-3 dark:border-red-900/30 dark:bg-red-900/10">
                        <x-icons.info-circle class="mt-0.5 h-4 w-4 flex-shrink-0 text-red-600 dark:text-red-400" />
                        <p class="text-sm font-medium text-red-700 dark:text-red-400">{{ $dateOverlapError }}</p>
                    </div>
                @endif

                <div class="flex flex-col">
                    <label class="mb-1 block text-sm font-bold text-gray-700 dark:text-gray-300">Alasan /
                        Keperluan</label>
                    <textarea wire:model="reason" rows="4"
                        class="w-full rounded-xl border border-zinc-200 p-4 text-gray-700 placeholder-gray-400 transition-all focus:ring-primary/50 dark:border-zinc-800 dark:bg-gray-800/50 dark:text-gray-200"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'"
                        placeholder="Berikan alasan yang jelas untuk pengajuan cuti Anda..."></textarea>
                    @error('reason')
                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Attachment Section --}}
                <div class="mt-4 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300">Lampiran Dokumen (Opsional)</h3>
                        <span class="text-[10px] font-normal text-gray-400">Max: 3MB (PNG, JPG, PDF)</span>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        {{-- Upload Box --}}
                        <div class="relative">
                            <label
                                class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 bg-zinc-50/50 py-8 transition-all hover:border-primary/50 hover:bg-primary/5 dark:border-zinc-800"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                                <x-icons.cloud-upload class="mb-2 h-8 w-8 text-gray-400" />
                                <span class="text-xs font-medium text-gray-500">Klik untuk unggah file baru</span>
                                <input type="file" wire:model="attachments" multiple class="hidden">
                            </label>
                            <div wire:loading wire:target="attachments"
                                class="absolute inset-0 z-10 flex items-center justify-center rounded-xl"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                                <x-icons.loading-circle class="h-8 w-8 text-primary" />
                            </div>
                        </div>

                        {{-- Existing & New Files List --}}
                        <div class="flex flex-col gap-3">
                            {{-- Existing Files --}}
                            @foreach ($existingAttachments as $index => $path)
                                <div
                                    class="flex items-center justify-between rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-zinc-900">
                                    <div class="flex min-w-0 items-center gap-2">
                                        <x-icons.paper-clip class="h-4 w-4 shrink-0 text-gray-400" />
                                        <span class="truncate text-xs text-zinc-600 dark:text-zinc-300">File Lama:
                                            {{ basename($path) }}</span>
                                    </div>
                                    <button type="button" wire:click="removeAttachment({{ $index }}, true)"
                                        class="text-red-500 hover:text-red-700">
                                        <x-icons.close class="h-4 w-4" />
                                    </button>
                                </div>
                            @endforeach

                            {{-- New Files --}}
                            @foreach ($attachments as $index => $file)
                                <div
                                    class="flex items-center justify-between rounded-xl border border-blue-200 bg-blue-50 p-3 dark:border-blue-900/20 dark:bg-blue-900/10">
                                    <div class="flex min-w-0 items-center gap-2">
                                        <x-icons.check-circle class="h-4 w-4 shrink-0 text-blue-500" />
                                        <span
                                            class="truncate text-[10px] text-blue-700 dark:text-blue-300">{{ $file->getClientOriginalName() }}</span>
                                    </div>
                                    <button type="button" wire:click="removeAttachment({{ $index }}, false)"
                                        class="text-red-500 hover:text-red-700">
                                        <x-icons.close class="h-4 w-4" />
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @error('attachments.*')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Right Column: Summary --}}
        <div class="flex flex-col gap-6">
            <div class="rounded-xl border border-primary/20 bg-primary/5 p-6 dark:bg-primary/10"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                <h3 class="mb-4 flex items-center gap-2 text-lg font-bold text-primary">
                    <x-icons.info-circle class="h-5 w-5" />
                    Detail Kalkulasi
                </h3>
                <div class="flex flex-col gap-4">
                    {{-- Return Work Estimation --}}
                    <div class="flex flex-col gap-1 rounded-lg p-3 dark:bg-black/20"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500">Estimasi Kembali
                            Bekerja:</span>
                        <div class="flex items-center gap-2">
                            <x-icons.calendar class="h-4 w-4 text-emerald-500" />
                            <span class="text-sm font-black text-gray-800 dark:text-white">
                                {{ $return_date ? \Carbon\Carbon::parse($return_date)->locale('id')->isoFormat('dddd, DD MMM YYYY') : '-' }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Total Durasi:</span>
                            <span class="font-black text-gray-900 dark:text-white">{{ $total_days }} Hari</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Sisa Kuota:</span>
                            <span class="font-bold text-zinc-600 dark:text-zinc-400">{{ $remaining_quota }}
                                Hari</span>
                        </div>

                        <div class="divider border-t border-zinc-200 dark:border-white/5"></div>

                        {{-- Holidays Info --}}
                        <div class="flex flex-col gap-2">
                            <span class="text-[10px] font-bold uppercase text-gray-400">Informasi Hari Libur:</span>
                            <div class="flex flex-col gap-1.5">
                                @if (count($intersected_sundays) > 0)
                                    <div class="flex items-center gap-2">
                                        <div class="h-1.5 w-1.5 rounded-full bg-red-500"></div>
                                        <span class="text-[11px] text-gray-600 dark:text-gray-400">Termasuk hari
                                            Minggu</span>
                                    </div>
                                @endif

                                @forelse($intersectedHolidays as $holiday)
                                    <div class="flex items-center gap-2">
                                        <div class="h-1.5 w-1.5 rounded-full bg-amber-500"></div>
                                        <span class="text-[11px] text-gray-600 dark:text-gray-400">Libur:
                                            {{ $holiday->name }}</span>
                                    </div>
                                @empty
                                    @if (count($intersected_sundays) === 0)
                                        <span class="text-[11px] italic text-gray-400">Tidak ada hari libur</span>
                                    @endif
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-button.primary type="submit" class="w-full !py-4 disabled:cursor-not-allowed disabled:opacity-50"
                :disabled="(bool) $dateOverlapError" wire:loading.attr="disabled" wire:target="update">
                <x-slot name="icon">
                    <x-icons.loading wire:loading wire:target="update" class="h-6 w-6" />
                    <x-icons.angle-right wire:loading.remove wire:target="update" class="h-6 w-6" />
                </x-slot>

                <span wire:loading.remove wire:target="update">Simpan Perubahan</span>
                <span wire:loading wire:target="update">Menyimpan...</span>
            </x-button.primary>
        </div>
    </form>
</div>
