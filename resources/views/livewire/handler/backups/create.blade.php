<form wire:submit.prevent="create">
	@csrf
	@method('post')
	<x-button.success class="max-h-10" id="new-backup" type="submit">
		<x-slot name="icon">
			<x-icons.plus class="icon h-6 w-6 text-red-500 dark:text-white" />
		</x-slot>
		Buat cadangan
	</x-button.success>
</form>
