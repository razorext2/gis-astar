<div
    class="border-zinc-200 dark:border-zinc-800 mt-4 flex flex-col gap-6 rounded-xl border bg-white p-4 shadow-sm backdrop-blur-xl dark:bg-dark-primary md:p-6">
    {{-- Breadcrumbs/Header --}}
    <div class="flex items-center gap-3">
        <x-button.link wire:navigate href="{{ route('leave-request.my-requests.index') }}"
            class="group rounded-full bg-white/50 !p-2 ring-1 ring-zinc-200 dark:bg-white/5 dark:ring-white/10">
            <x-icons.chevron-left class="group-hover:text-primary h-5 w-5 text-gray-500 transition-colors" />
        </x-button.link>
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Edit Pengajuan
                #{{ $requestId }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Anda dapat mengubah detail pengajuan selama belum
                disetujui oleh HRD.</p>
        </div>
    </div>

    <form wire:submit.prevent="update" class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Left Column: Main Form --}}
        <div class="flex flex-col gap-6 lg:col-span-2">
            <div
                class="border-zinc-200 dark:border-zinc-800 flex flex-col gap-5 rounded-xl border bg-white/60 p-6 shadow-md backdrop-blur-xl dark:bg-dark-primary/60">

                <div class="mb-2 flex items-center gap-2">
                    <div class="bg-primary h-8 w-1 rounded-full"></div>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">Informasi Cuti</h2>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div class="flex flex-col">
                        <x-input.select id="leave_type_id" name="leave_type_id" wire:model="leave_type_id"
                            :options="$leaveTypes->pluck('name', 'id')->toArray()" :defaultOption="'Pilih Tipe Cuti'" :labels="true" :textLabel="'Tipe Cuti'" required />
                    </div>
                    <div class="flex flex-col">
                        <x-input.select id="backup_person_id" name="backup_person_id" wire:model="backup_person_id"
                            :options="$employees->pluck('name', 'id')->toArray()" :defaultOption="'Pilih Orang Pengganti (Backup)'" :labels="true" :textLabel="'Personel Backup'" required />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div class="flex flex-col">
                        <x-input.basic type="date" id="start_date" name="start_date" wire:model.live="start_date"
                            :labels="true" required>
                            Tanggal Mulai
                        </x-input.basic>
                    </div>
                    <div class="flex flex-col">
                        <x-input.basic type="date" id="end_date" name="end_date" wire:model.live="end_date"
                            :labels="true" required>
                            Tanggal Berakhir
                        </x-input.basic>
                    </div>
                </div>

                <div class="flex flex-col">
                    <label class="mb-1 block text-sm font-bold text-gray-700 dark:text-gray-300">Alasan /
                        Keperluan</label>
                    <textarea wire:model="reason" rows="4"
                        class="focus:ring-primary/50 border-zinc-200 dark:border-zinc-800 w-full rounded-xl border bg-white/50 p-4 text-gray-700 placeholder-gray-400 transition-all dark:bg-gray-800/50 dark:text-gray-200"
                        placeholder="Berikan alasan yang jelas untuk pengajuan cuti Anda..."></textarea>
                </div>
            </div>
        </div>

        {{-- Right Column: Summary --}}
        <div class="flex flex-col gap-6">
            <div class="bg-primary/5 dark:bg-primary/10 border-primary/20 rounded-xl border p-6 backdrop-blur-xl">
                <h3 class="text-primary mb-4 flex items-center gap-2 text-lg font-bold">
                    <x-icons.info-circle class="h-5 w-5" />
                    Ringkasan Perubahan
                </h3>
                <div class="flex flex-col gap-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Durasi Baru:</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $total_days }} Hari</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Sisa Kuota:</span>
                        <span class="font-bold text-green-600">12 Hari</span>
                    </div>
                    <div class="divider my-1 border-t border-zinc-200 dark:border-white/5"></div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Setelah Update:</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ 12 - $total_days }} Hari</span>
                    </div>
                </div>
            </div>

            <x-button.primary type="submit"
                class="shadow-primary/20 w-full !py-4 text-lg font-bold shadow-xl transition-all hover:scale-[1.02] active:scale-[0.98]">
                <x-slot name="icon">
                    <x-icons.loading wire:loading wire:target="update" class="h-6 w-6" />
                </x-slot>
                <span wire:loading.remove wire:target="update">Simpan Perubahan</span>
                <span wire:loading wire:target="update">Menyimpan...</span>
            </x-button.primary>
        </div>
    </form>
</div>
