{{-- Goal: UI for unassign PR and linking to Edit PR page, Livewire: UnassignPurchasingRequest, Alpine: - --}}
<div class="flex w-full flex-col gap-4">

    {{-- Action Buttons Row --}}
    <div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-center lg:gap-6">
        {{-- Edit PR --}}
        <div class="space-y-2">
            <p class="text-zinc-800 dark:text-zinc-300">
                Edit data Purchasing Request SPK ini
            </p>

            <x-button.primary id="edit-pr-button" class="w-fit" href="{{ route('purchasing-request.edit-pr', $id) }}" wire:navigate>
                <x-slot name="icon">
                    <x-icons.file-pen class="icon h-5 w-5" />
                </x-slot>
                Edit PR
            </x-button.primary>
        </div>

        {{-- Unassign PR --}}
        <div class="space-y-2">
            <p class="text-zinc-800 dark:text-zinc-300">
                Nomor Purchasing Request salah atau bermasalah?
            </p>

            <x-button.danger id="unassign-button" class="w-fit" type="button" wire:click="unassign"
                wire:confirm.prompt="Anda yakin ingin unassign PR untuk SPK ini? PR yang sudah di unassign akan terhapus didatabase.\n\nJika yakin, ketik UNASSIGN untuk mengkonfirmasi.|UNASSIGN"
                wire:loading.attr="disabled" wire:target="unassign">
                <x-slot name="icon">
                    <x-icons.loading wire:loading wire:target="unassign" class="h-4 w-4 animate-spin" />
                    <x-icons.trash wire:loading.remove wire:target="unassign" class="icon h-5 w-5" />
                </x-slot>

                <span wire:loading.remove wire:target="unassign">Unassign PR</span>
                <span wire:loading wire:target="unassign">Menghapus...</span>
            </x-button.danger>
        </div>
    </div>
</div>
