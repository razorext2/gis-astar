{{-- Goal: Render form to create a new leave request, Livewire: Handler.LeaveRequest.Create, Alpine: dropdown select/UI state --}}
<div
    class="mt-4 flex flex-col gap-6 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-sm backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">

    {{-- Breadcrumbs/Header --}}
    <div class="flex items-center gap-3">
        <x-button.danger wire:navigate href="{{ route('leave-request.my-requests.index') }}" class="max-h-10 max-w-fit">
            <x-icons.angle-left class="h-5 w-5" />
        </x-button.danger>

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Buat Pengajuan Cuti</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Silakan lengkapi formulir di bawah ini untuk mengajukan
                ketidakhadiran.</p>
        </div>
    </div>

    @if (!$hasAnnualBalance)
        <div
            class="rounded-xl border border-blue-200 bg-blue-50 p-4 shadow-sm dark:border-blue-900/30 dark:bg-blue-900/10">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-start gap-4">
                    <div class="rounded-full bg-blue-100 p-2 dark:bg-blue-900/30">
                        <x-icons.info-circle class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-sm font-bold text-blue-900 dark:text-blue-300">Informasi Cuti Tahunan</h3>
                        <p class="mt-1 text-sm text-blue-700 dark:text-blue-400">
                            Saldo Cuti Tahunan Anda saat ini kosong. Untuk keperluan cuti di luar tipe khusus,
                            silakan gunakan fitur Pinjam Cuti.
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0 self-end md:self-auto">
                    <x-button.primary wire:navigate href="{{ route('leave-request.borrow.index') }}">
                        <x-slot name="icon">
                            <x-icons.arrow-right class="h-4 w-4" />
                        </x-slot>
                        Pergi ke Pinjam Cuti
                    </x-button.primary>
                </div>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="save" class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        @if ($activeRequest)
            <div class="col-span-1 lg:col-span-3">
                <div
                    class="flex flex-col gap-4 rounded-xl border border-amber-200 bg-amber-50 p-6 shadow-sm dark:border-amber-900/30 dark:bg-amber-900/10">
                    <div class="flex items-start gap-4">
                        <div class="rounded-full bg-amber-100 p-2 dark:bg-amber-900/30">
                            <x-icons.info-circle class="h-6 w-6 text-amber-600 dark:text-amber-400" />
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-sm font-bold text-amber-900 dark:text-amber-300">Pengajuan Masih Berjalan
                            </h3>
                            <p class="mt-1 text-sm text-amber-700 dark:text-amber-400">
                                Anda memiliki satu pengajuan cuti yang sedang dalam proses persetujuan
                                (#{{ $activeRequest->id }}).
                                Sesuai kebijakan perusahaan, Anda tidak diperkenankan membuat pengajuan baru hingga
                                pengajuan tersebut disetujui, ditolak, atau dibatalkan.
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <x-button.link wire:navigate
                            href="{{ route('leave-request.my-requests.show', $activeRequest->id) }}"
                            class="text-sm font-bold text-amber-700 hover:text-amber-900 dark:text-amber-400 dark:hover:text-amber-200">
                            Lihat Detail Pengajuan &rarr;
                        </x-button.link>
                    </div>
                </div>
            </div>
        @endif
        {{-- Left Column: Main Form --}}
        <div class="flex flex-col gap-6 lg:col-span-2">
            {{-- <div class="flex flex-col gap-5 rounded-xl border border-zinc-200 p-6 dark:border-zinc-800"> --}}

            <div class="mb-2 flex items-center gap-2">
                <div class="h-8 w-1 rounded-full bg-primary"></div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                    Informasi Cuti
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="flex flex-col">
                    <x-input.select id="leave_type_id" name="leave_type_id" wire:model.live="leave_type_id"
                        :options="$leaveTypes->pluck('name', 'id')->toArray()" :defaultOption="'Pilih Tipe Cuti'" :labels="true" :textLabel="'Tipe Cuti*'" required />
                </div>
                <div class="flex flex-col">
                    <label class="mb-1 block text-sm font-bold text-gray-700 dark:text-gray-300">
                        Personel Backup (Opsional)
                    </label>
                    <div class="relative" x-data="{ open: false, selectedName: '' }" @click.away="open = false">
                        {{-- Search Input / Trigger --}}
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="search_backup" @focus="open = true"
                                placeholder="Cari Nama atau Kode Pegawai..."
                                class="w-full rounded-xl border border-zinc-200 bg-white/50 py-3 pl-4 pr-10 text-sm transition-all focus:ring-red-500/50 dark:border-zinc-800 dark:bg-gray-800/50 dark:text-gray-200">
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <x-icons.search class="h-4 w-4 text-gray-400" />
                            </div>
                        </div>

                        {{-- Dropdown Results --}}
                        <div x-show="open && $wire.search_backup.length > 0"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            class="absolute z-50 mt-2 max-h-60 w-full overflow-y-auto rounded-xl border border-zinc-200 bg-white shadow-xl backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary">

                            @forelse ($employees as $emp)
                                @php
                                    $isOnLeave = $emp->currentLeave !== null;
                                @endphp
                                <button type="button"
                                    @if ($isOnLeave) wire:click="showOnLeaveError('{{ addslashes($emp->name) }}')"
                                    @else
                                        wire:click="selectBackupPerson({{ $emp->id }}, '{{ addslashes($emp->name) }}')"
                                        @click="open = false" @endif
                                    class="{{ $backup_person_id == $emp->id ? 'bg-red-50 dark:bg-red-900/20' : '' }} {{ $isOnLeave ? 'opacity-70' : '' }} flex w-full items-center justify-between px-4 py-3 text-left transition-colors hover:bg-zinc-50 dark:hover:bg-white/5">
                                    <div class="flex flex-col gap-0.5">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="text-sm font-bold text-zinc-900 dark:text-white">{{ $emp->name }}</span>
                                            @if ($isOnLeave)
                                                <span
                                                    class="rounded-md bg-red-100 px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-wider text-red-600 dark:bg-red-900/30 dark:text-red-400">Sedang
                                                    Cuti</span>
                                            @endif
                                        </div>
                                        <span
                                            class="text-[10px] uppercase tracking-wider text-zinc-500">{{ $emp->kode_pegawai }}</span>
                                    </div>
                                    @if ($backup_person_id == $emp->id)
                                        <x-icons.check class="h-4 w-4 text-red-600" />
                                    @endif
                                </button>
                            @empty
                                <div class="px-4 py-6 text-center text-sm text-zinc-500">
                                    Tidak ada karyawan ditemukan.
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
                        Tanggal Mulai*
                    </x-input.basic>
                    @error('start_date')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <x-input.basic type="date" id="end_date" name="end_date" wire:model.live="end_date"
                        min="{{ $start_date ?? \Carbon\Carbon::today()->addDays(config('app.leave_min_advance_days', 7))->toDateString() }}"
                        :labels="true" required>
                        Tanggal Berakhir*
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

            @if ($return_date)
                <div class="flex flex-col gap-3">
                    <div
                        class="flex items-center gap-3 rounded-xl border border-blue-200 bg-blue-50/50 p-4 dark:border-blue-900/30 dark:bg-blue-900/10">
                        <x-icons.info-circle class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                        <div class="flex flex-col">
                            <span
                                class="text-xs font-bold uppercase tracking-wider text-blue-700 dark:text-blue-300">Estimasi
                                Kembali Bekerja</span>
                            <span class="text-sm font-bold text-zinc-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($return_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}
                            </span>
                        </div>
                    </div>

                    @if (count($intersected_holidays) > 0 || count($intersected_sundays) > 0)
                        <div
                            class="flex flex-col gap-2 rounded-xl border border-red-200 bg-red-50/30 p-4 dark:border-red-900/20 dark:bg-red-900/5">
                            <div
                                class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-red-600 dark:text-red-400">
                                <x-icons.calendar class="h-4 w-4" />
                                Hari Libur & Akhir Pekan
                            </div>
                            <div class="flex flex-wrap gap-2 text-[11px]">
                                {{-- National Holidays --}}
                                @foreach ($intersected_holidays as $holiday)
                                    <div
                                        class="flex items-center gap-1.5 rounded-full bg-white px-2.5 py-1 text-zinc-700 shadow-sm ring-1 ring-red-200 dark:bg-zinc-800 dark:text-zinc-300 dark:ring-red-900/50">
                                        <span
                                            class="font-bold text-red-600">{{ \Carbon\Carbon::parse($holiday->date)->format('d/m') }}</span>
                                        <span>{{ $holiday->name }}</span>
                                    </div>
                                @endforeach

                                {{-- Sundays --}}
                                @foreach ($intersected_sundays as $sunday)
                                    <div
                                        class="flex items-center gap-1.5 rounded-full bg-white px-2.5 py-1 text-zinc-700 shadow-sm ring-1 ring-red-200 dark:bg-zinc-800 dark:text-zinc-300 dark:ring-red-900/50">
                                        <span
                                            class="font-bold text-red-600">{{ \Carbon\Carbon::parse($sunday)->format('d/m') }}</span>
                                        <span>Hari Minggu</span>
                                    </div>
                                @endforeach
                            </div>
                            <p class="mt-1 text-[10px] italic text-zinc-500">Tanggal di atas tidak dihitung dalam
                                durasi cuti.</p>
                        </div>
                    @endif
                </div>
            @endif

            <div class="flex flex-col">
                <label class="mb-1 block text-sm font-bold text-gray-700 dark:text-gray-300">
                    Alasan / Keperluan*
                </label>
                <textarea wire:model="reason" rows="4"
                    class="w-full rounded-xl border border-zinc-200 bg-white/50 p-4 text-gray-700 placeholder-gray-400 transition-all focus:ring-primary/50 dark:border-zinc-800 dark:bg-gray-800/50 dark:text-gray-200"
                    placeholder="Berikan alasan yang jelas untuk pengajuan cuti Anda..."></textarea>

                @error('reason')
                    <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- </div> --}}
        </div>

        {{-- Right Column: Summary & Attachments --}}
        <div class="flex flex-col gap-6">
            {{-- Summary Card --}}
            @if ($leave_type_id)
                <div
                    class="rounded-xl border border-zinc-200 bg-primary/5 p-6 backdrop-blur-xl dark:border-zinc-800 dark:bg-primary/10">
                    <h3 class="mb-4 flex items-center gap-2 text-lg font-bold text-primary">
                        <x-icons.info-circle class="h-5 w-5" />
                        Ringkasan Pengajuan
                    </h3>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Durasi Cuti:</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $total_days }} Hari</span>
                        </div>
                        @if ($return_date)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Kembali Bekerja:</span>
                                <span class="text-right font-bold text-blue-600">
                                    {{ \Carbon\Carbon::parse($return_date)->locale('id')->isoFormat('DD MMM YYYY') }}
                                </span>
                            </div>
                        @endif
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Sisa Kuota:</span>
                            <span class="{{ $remaining_quota <= 0 ? 'text-red-600' : 'text-green-600' }} font-bold">
                                {{ $remaining_quota }} Hari
                            </span>
                        </div>
                        <div class="divider my-1 border-t border-zinc-200 dark:border-white/5"></div>
                        <div class="flex flex-col gap-1">
                            <span class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-400">Alur
                                Persetujuan:</span>
                            <div class="mt-1 flex flex-col gap-2">
                                <div class="flex items-center gap-2 text-[11px]">
                                    <div class="h-1.5 w-1.5 rounded-full bg-zinc-300 dark:bg-zinc-600"></div>
                                    <span class="italic text-gray-600 dark:text-gray-400">Atasan:</span>
                                    <span
                                        class="font-bold text-gray-700 dark:text-gray-200">{{ auth()->user()->pegawai->jabatanRelasi?->supervisors->pluck('name')->implode(', ') ?: 'Belum Diatur' }}</span>
                                </div>
                                <div class="flex items-start gap-2 text-[11px]">
                                    <div class="mt-1 h-1.5 w-1.5 rounded-full bg-zinc-300 dark:bg-zinc-600"></div>
                                    <span class="italic text-gray-600 dark:text-gray-400">HRD:</span>
                                    <span class="flex-1 font-bold leading-relaxed text-gray-700 dark:text-gray-200">
                                        {{ implode(', ', $hrd_approvers) ?: 'HRD Department' }}
                                    </span>
                                </div>
                                <div class="flex items-start gap-2 text-[11px]">
                                    <div class="mt-1 h-1.5 w-1.5 rounded-full bg-zinc-300 dark:bg-zinc-600"></div>
                                    <span class="italic text-gray-600 dark:text-gray-400">Management:</span>
                                    <span class="flex-1 font-bold leading-relaxed text-gray-700 dark:text-gray-200">
                                        {{ implode(', ', $management_approvers) ?: 'Direksi/Management' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Attachment Card --}}
            <div
                class="flex flex-col gap-4 rounded-xl border border-zinc-200 bg-white/60 p-6 shadow-md backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60">
                <h3 class="flex items-center gap-2 text-lg font-bold text-gray-800 dark:text-gray-100">
                    <x-icons.paper-clip class="h-5 w-5" />
                    Lampiran {{ $selected_leave_type?->requires_attachment ? '*' : '(Opsional)' }}
                </h3>
                <div class="flex flex-col gap-3">
                    <div
                        class="relative flex flex-col items-center rounded-xl border-2 border-dashed border-zinc-200 p-6 text-center transition-all hover:border-primary/50 dark:border-zinc-800">
                        <x-icons.cloud-upload class="mb-2 h-10 w-10 text-gray-300 dark:text-gray-600" />
                        <p class="text-xs text-gray-500">
                            {{ $selected_leave_type?->requires_attachment ? 'Wajib upload dokumen pendukung.' : 'Drop file atau klik untuk upload dokumen pendukung.' }}
                        </p>
                        <p class="mt-1 text-[10px] text-zinc-400">PDF, JPG, PNG (Maks 3MB)</p>
                        <input type="file" wire:model="attachments" multiple accept=".pdf,.jpg,.jpeg,.png"
                            class="absolute inset-0 cursor-pointer opacity-0" />
                    </div>

                    {{-- Loading State --}}
                    <div wire:loading wire:target="attachments" class="text-center text-xs font-bold text-primary">
                        Sedang mengunggah...
                    </div>

                    {{-- Error Display --}}
                    @error('attachments')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror
                    @error('attachments.*')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                    @enderror

                    {{-- Files List --}}
                    @if ($attachments)
                        <div class="flex flex-col gap-2">
                            @foreach ($attachments as $index => $file)
                                <div
                                    class="flex items-center justify-between rounded-lg bg-zinc-50 p-2 text-xs dark:bg-white/5">
                                    <div class="flex items-center gap-2 truncate">
                                        <x-icons.check-circle class="h-4 w-4 text-green-500" />
                                        <span
                                            class="truncate text-zinc-600 dark:text-zinc-300">{{ $file->getClientOriginalName() }}</span>
                                    </div>
                                    <button type="button" wire:click="removeAttachment({{ $index }})"
                                        class="text-red-500 hover:text-red-700">
                                        <x-icons.close class="h-4 w-4" />
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Submit Button --}}
            <x-button.primary type="submit" class="w-full !py-4 disabled:cursor-not-allowed disabled:opacity-50"
                :disabled="(bool) $activeRequest || (bool) $dateOverlapError" wire:loading.attr="disabled" wire:target="save">
                <x-slot name="icon">
                    <x-icons.loading wire:loading wire:target="save" class="h-4 w-4 animate-spin" />
                    <x-icons.angle-right wire:loading.remove wire:target="save" class="h-4 w-4" />
                </x-slot>

                <span wire:loading.remove wire:target="save">Kirim Pengajuan</span>
                <span wire:loading wire:target="save">Memproses...</span>
            </x-button.primary>
        </div>
    </form>
</div>
