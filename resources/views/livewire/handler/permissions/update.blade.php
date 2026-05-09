<form class="mt-4" wire:submit.prevent="save">
    @csrf
    @method('put')
    <div class="grid gap-y-2.5">
        <div class="flex w-full flex-col">
            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="name">
                Guard Name
            </label>
            <x-input.basic class="cursor-not-allowed" id="guard_name" wire:model="guard_name" name="guard_name" readonly />
        </div>
        <div class="flex w-full flex-col">
            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="name">
                Nama Perizinan
            </label>
            <x-input.basic id="name" wire:model.blur="name" name="name" placeholder="Isi dengan nama perizinan"
                required="" />
            @error('name')
                <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="mt-4 items-center">
        <x-button.primary id="store" type="submit" wire:loading.attr="disabled" wire:target="save">
            <x-slot name="icon">
                <x-icons.angle-right wire:loading.remove wire:target="save" class="icon h-5 w-5" />
                <x-icons.loading wire:loading wire:target="save" class="h-4 w-4 animate-spin" />
            </x-slot>

            <span wire:loading.remove wire:target="save">Simpan</span>
            <span wire:loading wire:target="save">Menyimpan...</span>
        </x-button.primary>
    </div>
</form>
