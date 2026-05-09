<div class="mt-4 flex flex-col gap-2">
    @if ($diffResult)
        <style>
            {!! \Jfcherng\Diff\DiffHelper::getStyleSheet() !!}
        </style>

        {!! $diffResult !!}

        <form wire:submit.prevent="update" class="mt-2 flex justify-center">
            <x-button.primary type="submit" wire:loading.attr="disabled" wire:target="update">
                <x-slot name="icon">
                    <x-icons.angle-right wire:loading.remove wire:target="update" class="icon h-5 w-5" />
                    <x-icons.loading wire:loading wire:target="update" class="h-4 w-4 animate-spin" />
                </x-slot>

                <span wire:loading.remove wire:target="update">Update Data</span>
                <span wire:loading wire:target="update">Memperbarui...</span>
            </x-button.primary>
        </form>
    @else
        <p class="text-center text-gray-600 dark:text-gray-400">Tidak ada perubahan data.</p>
    @endif
</div>
