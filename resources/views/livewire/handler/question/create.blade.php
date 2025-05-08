<form wire:submit.prevent="store" class="grid gap-4 md:grid-cols-2">
	@csrf
	<div class="col-span-2 w-full">
		<x-input.select :labels="true" wire:model="for" :textLabel="'Peruntukan'" id="for" name="for" :defaultOption="'Pilih Peruntukan'"
			:options="[
			    'sales' => 'Sales',
			    'technician' => 'Teknisi',
			    'collector' => 'Kolektor',
			]" />
		@error('for')
			<div class="mt-2 hidden text-sm text-red-500" id="alert-for">{{ $message }}</div>
		@enderror
	</div>

	<div class="col-span-2 w-full">
		<x-input.select :labels="true" wire:model="is_active" :textLabel="'Status'" id="is_active" name="is_active"
			:defaultOption="'Pilih Status'" :options="[
			    '1' => 'Aktif',
			    '0' => 'Tidak Aktif',
			]" />
		@error('is_active')
			<div class="mt-2 hidden text-sm text-red-500" id="alert-is_active">{{ $message }}</div>
		@enderror
	</div>

	<div class="col-span-2 w-full">
		<x-input.basic wire:model="question" id="question" name="question" placeholder="Pertanyaan" required>
			Pertanyaan
		</x-input.basic>
		@error('question')
			<div class="mt-2 hidden text-sm text-red-500" id="alert-question">{{ $message }}</div>
		@enderror
	</div>

	<div class="col-span-2 w-full">

		<x-button.primary wire:click="addOption" class="mb-2 text-sm" type="button"> Tambah Opsi </x-button.primary>

		<label for="options" class="block text-sm font-medium text-gray-900 dark:text-white"> Opsi Jawaban </label>

		@foreach ($options as $i => $option)
			<div class="flex items-center gap-2">
				<div class="grow">
					<x-input.basic wire:model="options.{{ $i }}" id="option" class="mb-2" name="option"
						placeholder="Jawaban {{ $i + 1 }}" required />
				</div>
				<x-button.danger wire:click="removeOption({{ $i }})" class="h-fit w-fit text-sm" type="button">
					Hapus
				</x-button.danger>
			</div>
		@endforeach
		@error('option.*')
			<div class="mt-2 hidden text-sm text-red-500" id="alert-option">{{ $message }}</div>
		@enderror
	</div>

	<div class="relative col-span-2 w-full">
		<x-button.primary class="float-right" type="submit" id="store">
			<x-slot name="icon">
				<x-icons.angle-right class="icon h-5 w-5" />
			</x-slot>
			Simpan
		</x-button.primary>
	</div>

</form>
