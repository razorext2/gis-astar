<form wire:submit.prevent="create">
    @csrf
    @method('post')
    <x-button.success class="max-h-10" id="new-backup" type="submit">
        <x-slot name="icon">
            <x-icons.plus class="h-5 w-5" />
        </x-slot>
        Buat cadangan
    </x-button.success>
</form>
