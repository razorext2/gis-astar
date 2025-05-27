<div class="mt-4 flex flex-col items-center gap-4">
	@if ($diffResult)
		<style>
			{!! \Jfcherng\Diff\DiffHelper::getStyleSheet() !!}
		</style>

		{!! $diffResult !!}

		<form wire:submit.prevent="update">
			<x-button.primary type="submit" wire:loading.attr="disabled" wire:target="update">
				<x-slot name="icon">
					<x-icons.angle-right wire:loading.remove class="h-5 w-5 text-blue-500 dark:text-white" />
					<x-icons.loading wire:loading />
				</x-slot>

				<span wire:loading.remove>Update Data</span>

			</x-button.primary>
		</form>
	@else
		<p class="text-center text-gray-600 dark:text-gray-400">Tidak ada perubahan data.</p>
	@endif
</div>
