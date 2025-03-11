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
						<x-input.basic id="name.{{ $index }}" name="name[]" placeholder="Isi dengan nama perizinan"
							wire:model.blur="form.name.{{ $index }}" />

						<x-button.danger class="ms-2 h-fit w-fit" wire:click="removeField({{ $index }})">
							<x-icons.trash-bin class="h-4 w-4" />
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
		<x-button.primary wire:click="addField">
			<x-slot name="icon">
				<x-icons.plus class="h-5 w-5" />
			</x-slot>
			<span>Tambah lainnya</span>
		</x-button.primary>

		<x-button.primary id="store" type="submit">
			<x-slot name="icon">
				<x-icons.angle-right class="h-5 w-5 text-blue-500 dark:text-white" />
			</x-slot>
			<span wire:loading.remove wire:target="save">Submit</span>
			<span wire:loading wire:target="save"> Memproses... </span>
		</x-button.primary>
	</div>
</form>
