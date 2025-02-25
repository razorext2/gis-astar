<div class="inline-flex gap-x-2">
	<x-button.danger class="!gap-0 !px-2 py-1.5" id="delete" data-id="{{ $id }}" type="button">
		<x-slot name="icon">
			<x-icons.trash-bin class="icon h-5 w-5 text-red-500 dark:text-white" />
		</x-slot>
	</x-button.danger>

	<x-button.link class="ring-blue-700 hover:bg-blue-300 dark:bg-blue-800 dark:hover:bg-blue-900" id="download"
		type="button" href="{{ route('backup.download', $id) }}">
		Download
	</x-button.link>
</div>
