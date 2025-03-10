<form wire:submit.prevent="delete">
	@csrf
	@method('delete')

	<x-button.danger id="delete" type="submit">
		<x-slot name="icon">
			<x-icons.trash-bin class="h-5 w-5 text-red-500 dark:text-white" />
		</x-slot>
		Hapus
	</x-button.danger>
</form>
