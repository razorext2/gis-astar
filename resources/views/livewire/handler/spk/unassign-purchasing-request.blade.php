<div class="flex w-full flex-col gap-2 lg:flex-row lg:items-center">
    <p class="text-gray-800 dark:text-white">
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
