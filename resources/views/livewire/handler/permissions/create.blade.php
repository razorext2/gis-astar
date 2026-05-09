<form class="mt-4" wire:submit.prevent="save">
    @csrf
    <div class="mb-2 grid gap-6">
        <div class="w-full">
            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="role_name">
                Nama Perizinan
            </label>
            <div class="flex flex-col">
                @foreach ($form->name as $index => $permission)
                    <div class="mb-2 flex flex-row items-center">
                        <x-input.basic id="name.{{ $index }}" name="name[]"
                            placeholder="Isi dengan nama perizinan" wire:model.blur="form.name.{{ $index }}" />

                        <x-button.danger class="ms-2 h-fit w-fit" wire:click="removeField({{ $index }})"
                            wire:loading.attr="disabled" wire:target="removeField({{ $index }})">
                            <x-slot name="icon">
                                <x-icons.trash-bin wire:loading.remove wire:target="removeField({{ $index }})"
                                    class="icon h-5 w-5" />
                                <x-icons.loading wire:loading wire:target="removeField({{ $index }})"
                                    class="h-4 w-4 animate-spin" />
                            </x-slot>
                        </x-button.danger>
                    </div>
                    @error('form.name.' . $index)
                        <span class="error mb-2 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                @endforeach
            </div>

        </div>
    </div>

    <div class="flex items-center gap-x-2.5">
        <x-button.primary wire:click="addField" wire:loading.attr="disabled" wire:target="addField">
            <x-slot name="icon">
                <x-icons.plus wire:loading.remove wire:target="addField" class="icon h-5 w-5" />
                <x-icons.loading wire:loading wire:target="addField" class="h-4 w-4 animate-spin" />
            </x-slot>

            <span wire:loading.remove wire:target="addField">Tambah lainnya</span>
            <span wire:loading wire:target="addField">Memproses...</span>
        </x-button.primary>

        <x-button.primary id="store" type="submit" wire:loading.attr="disabled" wire:target="save">
            <x-slot name="icon">
                <x-icons.angle-right wire:loading.remove wire:target="save" class="icon h-5 w-5" />
                <x-icons.loading wire:loading wire:target="save" class="h-4 w-4 animate-spin" />
            </x-slot>

            <span wire:loading.remove wire:target="save">Submit</span>
            <span wire:loading wire:target="save"> Memproses... </span>
        </x-button.primary>
    </div>
</form>
