{{-- Goal: Modal for Creating/Editing Leave Types, Livewire: Handler.LeaveRequest.ManageBalances.Index, Alpine: true --}}

<div x-data="{ open: @entangle('isModalOpen') }" x-show="open" 
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-900/60 backdrop-blur-sm"
    x-cloak>
    
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

        <form wire:submit.prevent="saveType" class="p-6 space-y-5">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="flex flex-col gap-1">
                    <x-input.basic type="text" id="typeName" name="typeName" wire:model="typeName" :labels="true" required>
                        Nama Tipe Cuti
                    </x-input.basic>
                </div>
                <div class="flex flex-col gap-1">
                    <x-input.basic type="text" id="typeCode" name="typeCode" wire:model="typeCode" :labels="true" required :placeholder="'CT-XXXX'">
                        Kode Unik
                    </x-input.basic>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <x-input.basic type="number" id="typeDefaultDays" name="typeDefaultDays" wire:model="typeDefaultDays" :labels="true">
                    Kuota Default (Hari)
                </x-input.basic>
                <p class="text-[10px] text-zinc-500 uppercase tracking-wider mt-1">Set ke 0 untuk tidak memiliki batas default (khusus).</p>
            </div>

            <div class="grid grid-cols-1 gap-4 rounded-xl border border-zinc-100 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:bg-white/5">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" wire:model="typeAnualDeduction" class="rounded border-zinc-300 text-red-600 focus:ring-red-500">
                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Potong Saldo Cuti Tahunan</span>
                </label>
                
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" wire:model="typeRequiresAttachment" class="rounded border-zinc-300 text-red-600 focus:ring-red-500">
                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Wajib Lampiran (Dokumen Pendukung)</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button type="button" @click="open = false"
                    class="rounded-xl border border-zinc-200 px-6 py-2 text-sm font-bold text-zinc-600 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-400">
                    Batal
                </button>
                <x-button.primary type="submit">
                    <x-slot name="icon"><x-icons.check class="h-4 w-4" /></x-slot>
                    {{ $editMode ? 'Simpan Perubahan' : 'Buat Tipe Cuti' }}
                </x-button.primary>
            </div>
        </form>
    </div>
</div>
