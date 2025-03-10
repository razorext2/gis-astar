<form class="mt-4" wire:submit.prevent="save">
	@csrf
	@method('put')
	<div class="mb-4 grid gap-6 sm:mb-5 sm:gap-6">
		<div class="w-full">
			<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="role_name">
				Nama Role
			</label>
			<x-input.basic name="role_name" id="role_name" placeholder="Isi dengan nama role" wire:model="form.name" required />
			@error('form.name')
				<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
			@enderror
		</div>

		<div class="w-full">
			<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Permissions</label>

			<input
				class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-green-600 focus:ring-2 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-green-600"
				id="select-all" type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll">
			<label class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300" id="select-all-label" for="select-all">
				Select All
			</label>

			<div class="grid md:grid-cols-3">
				@foreach ($permissions as $id => $name)
					<div>
						<input
							class="permission-checkbox h-4 w-4 rounded border-gray-300 bg-gray-100 text-green-600 focus:ring-2 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-green-600"
							id="permission[{{ $id }}]" name="permission[{{ $id }}]" type="checkbox"
							value="{{ $id }}" wire:model="form.selectedPermissions">
						<label class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="permission[{{ $id }}]">
							{{ $name }}
						</label>
					</div>
				@endforeach
			</div>
			@error('form.selectedPermissions')
				<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
			@enderror
		</div>
	</div>
	<div class="flex items-center">
		<x-button.primary id="store" type="submit">
			<x-slot name="icon" wire:loading.class="animate-spin">
				<x-icons.angle-right class="h-5 w-5 text-blue-500 dark:text-white" />
			</x-slot>
			<span wire:loading.remove>Simpan</span>
			<span wire:loading>Memproses...</span>
		</x-button.primary>
	</div>
</form>
