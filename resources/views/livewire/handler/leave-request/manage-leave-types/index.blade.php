{{-- Goal: Leave Types management tab content, Livewire: Handler.LeaveRequest.ManageLeaveTypes.Index, Alpine: true --}}

<div class="flex flex-col gap-6">

    <div
        class="flex flex-col gap-6 rounded-xl border border-zinc-200 bg-white/60 p-4 text-center backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">
        {{-- Action Bar --}}
        <div class="flex items-center justify-between border-b border-zinc-100 pb-4 dark:border-zinc-800">
            <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Daftar Tipe Cuti</h3>

            <x-button.primary wire:click="openModal">
                <x-slot name="icon"><x-icons.plus class="h-4 w-4" /></x-slot>
                Tambah Tipe Cuti
            </x-button.primary>
        </div>

        {{-- Leave Types Grid --}}
        @if ($leaveTypes->isEmpty())
            <div class="flex flex-col items-center justify-center p-16">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-xl bg-zinc-100 dark:bg-zinc-800">
                    <x-icons.file-excel class="h-8 w-8 text-zinc-400" />
                </div>
                <p class="font-bold text-zinc-900 dark:text-white">Belum ada tipe cuti</p>
                <p class="mt-1 text-sm text-zinc-500">Tambahkan tipe cuti baru untuk memulai.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($leaveTypes as $type)
                    <div
                        class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-white/60 p-4 backdrop-blur-xl transition-all hover:border-red-500/50 hover:shadow-lg dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">
                        <div class="flex items-start justify-between">
                            <div class="text-left">
                                <span
                                    class="text-[10px] font-black uppercase tracking-widest text-zinc-400">{{ $type->code }}</span>
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $type->name }}</h3>
                            </div>
                            <div class="flex gap-1 opacity-0 transition-opacity group-hover:opacity-100">
                                <button wire:click="openModal({{ $type->id }})"
                                    class="rounded-lg bg-zinc-100 p-1.5 text-zinc-600 hover:bg-red-500 hover:text-white dark:bg-zinc-800 dark:text-zinc-400">
                                    <x-icons.pen class="h-4 w-4" />
                                </button>
                                <button wire:confirm="Apakah Anda yakin ingin menghapus tipe cuti ini?"
                                    wire:click="deleteType({{ $type->id }})"
                                    class="rounded-lg bg-zinc-100 p-1.5 text-zinc-600 hover:bg-red-600 hover:text-white dark:bg-zinc-800 dark:text-zinc-400">
                                    <x-icons.close class="h-4 w-4" />
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <span
                                class="inline-flex items-center rounded-full bg-zinc-100 px-2.5 py-0.5 text-[10px] font-bold text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                                {{ $type->default_days ? $type->default_days . ' Hari' : 'Tanpa Batas' }}
                            </span>
                            @if ($type->is_anual_deduction)
                                <span
                                    class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-[10px] font-bold text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                    Potong Saldo
                                </span>
                            @endif
                            @if ($type->requires_attachment)
                                <span
                                    class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-[10px] font-bold text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                    Wajib Lampiran
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Modal --}}
    <div x-data="{ open: @entangle('isModalOpen') }" x-show="open"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-900/60 p-4 backdrop-blur-sm" x-cloak>

        <div @click.away="open = false"
            class="w-full max-w-xl overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-2xl dark:border-zinc-800 dark:bg-dark-primary">

            <div class="flex items-center justify-between border-b border-zinc-100 p-6 dark:border-zinc-800">
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white">
                    {{ $editMode ? 'Edit Tipe Cuti' : 'Tambah Tipe Cuti Baru' }}
                </h3>
                <button @click="open = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <x-icons.close class="h-6 w-6" />
                </button>
            </div>

            <form wire:submit.prevent="saveType" class="space-y-5 p-6">
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div class="flex flex-col gap-1">
                        <x-input.basic type="text" id="typeName" name="typeName" wire:model="typeName"
                            :labels="true" required>
                            Nama Tipe Cuti
                        </x-input.basic>
                    </div>
                    <div class="flex flex-col gap-1">
                        <x-input.basic type="text" id="typeCode" name="typeCode" wire:model="typeCode"
                            :labels="true" required :placeholder="'CT-XXXX'">
                            Kode Unik
                        </x-input.basic>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <x-input.basic type="number" id="typeDefaultDays" name="typeDefaultDays"
                        wire:model="typeDefaultDays" :labels="true">
                        Kuota Default (Hari)
                    </x-input.basic>
                    <p class="mt-1 text-[10px] uppercase tracking-wider text-zinc-500">Set ke 0 untuk tidak memiliki
                        batas default (khusus).</p>
                </div>

                <div
                    class="grid grid-cols-1 gap-4 rounded-xl border border-zinc-100 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:bg-white/5">
                    <label class="flex cursor-pointer items-center gap-3">
                        <input type="checkbox" wire:model="typeAnualDeduction"
                            class="rounded border-zinc-300 text-red-600 focus:ring-red-500">
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Potong Saldo Cuti
                            Tahunan</span>
                    </label>

                    <label class="flex cursor-pointer items-center gap-3">
                        <input type="checkbox" wire:model="typeRequiresAttachment"
                            class="rounded border-zinc-300 text-red-600 focus:ring-red-500">
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Wajib Lampiran (Dokumen
                            Pendukung)</span>
                    </label>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" @click="open = false"
                        class="rounded-xl border border-zinc-200 px-6 py-2 text-sm font-bold text-zinc-600 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-400">
                        Batal
                    </button>
                    <x-button.primary type="submit" wire:loading.attr="disabled" wire:target="saveType">
                        <x-slot name="icon">
                            <x-icons.loading wire:loading wire:target="saveType" class="h-4 w-4 animate-spin" />
                            <x-icons.angle-right wire:loading.remove wire:target="saveType" class="h-4 w-4" />
                        </x-slot>

                        <span wire:loading.remove wire:target="saveType">
                            {{ $editMode ? 'Simpan Perubahan' : 'Buat Tipe Cuti' }}
                        </span>
                        <span wire:loading wire:target="saveType">
                            {{ $editMode ? 'Menyimpan...' : 'Membuat...' }}
                        </span>
                    </x-button.primary>
                </div>
            </form>
        </div>
    </div>

</div>
