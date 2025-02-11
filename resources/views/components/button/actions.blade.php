<div class="inline-flex gap-x-2">
	<x-button.danger class="max-h-10" id="delete" data-id="{{ $id }}" type="button">
		<x-slot name="icon">
			<x-icons.close class="icon h-6 w-6 text-red-500 dark:text-white" />
		</x-slot>
	</x-button.danger>

	<x-button.link class="max-h-10 ring-blue-700 hover:bg-blue-300 dark:bg-blue-800 dark:hover:bg-blue-900" id="download"
		type="button" href="{{ route('backup.download', $id) }}">
		Download
	</x-button.link>
</div>
