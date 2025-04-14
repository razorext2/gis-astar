<span class="text-md text-gray-600 dark:text-gray-300">
	<div id="bio-container" class="flex items-center gap-x-2">
		<p>{{ auth()->user()->pegawai->bio ?? 'Not set' }}</p>

		<button id="bioEdit" type="button" data-popover-target="bioPopover">
			<x-icons.pen class="h-4 w-4" />
		</button>

		<div data-popover id="bioPopover" role="tooltip"
			class="shadow-xs invisible absolute z-10 inline-block w-64 rounded-lg border border-gray-200 bg-white text-sm text-gray-500 opacity-0 transition-opacity duration-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400">
			<div class="px-3 py-2">
				<p>Edit bio/status anda. Max 20 karakter</p>
			</div>
			<div data-popper-arrow></div>
		</div>
	</div>

	<div id="bio-edit-container" class="mb-2 hidden items-center">
		<x-input.basic id="bio" maxlength="20" name="bio" wire:model.blur="bio" placeholder="Max 20 karakter." />
	</div>
</span>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		document.getElementById('bioEdit').addEventListener('click', () => {
			document.getElementById('bio-container').classList.add('hidden');
			document.getElementById('bio-edit-container').classList.remove('hidden').add('flex');
		});
	});
</script>
