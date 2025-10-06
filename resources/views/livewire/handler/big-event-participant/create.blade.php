<div class="flex w-full flex-col gap-2.5">

	<div class="flex flex-row gap-2">
		<x-button.success id="create-participant" class="w-fit" wire:click="$set('showCreateForm', true)">
			Tambah Partisipan
		</x-button.success>

		<x-button.success id="refresh-table" class="w-fit" wire:click="refreshTable">
			Refresh Tabel
		</x-button.success>
	</div>

	<div wire:key="create-participant-form"
		class="{{ $showCreateForm ? 'block' : 'hidden' }} rounded-xl p-4 dark:bg-dark-secondary">
		<form wire:submit.prevent="store" class="flex w-full flex-col gap-2">
			<div class="w-full">
				<x-input.basic id="search-user" name="search_user" wire:model.live.throttle.100ms="search" placeholder="Cari User"
					:labels="'Cari User'">
					Cari Nama Partisipan
				</x-input.basic>

				@error('user_id')
					<span class="mt-2 text-xs italic text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<fieldset>
				@forelse ($users as $user)
					<div class="mb-4 flex items-center">
						<input id="user-option-{{ $user->id }}" wire:model="user_id" type="radio" name="user_id"
							value="{{ $user->id }}"
							class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-700 dark:focus:bg-blue-600 dark:focus:ring-blue-600">
						<label for="user-option-{{ $user->id }}"
							class="ms-2 block text-sm font-medium text-gray-900 dark:text-gray-300">
							[ {{ $user->kode_pegawai ?? '' }} ] {{ $user->name }}
						</label>
					</div>
				@empty
					<p class="text-center text-sm italic"> Tidak ada data </p>
				@endforelse
			</fieldset>

			<div class="w-full">
				<x-input.basic id="redirect-to" placeholder="cth: https://xxx.com" name="redirect_to"
					wire:model.live.throttle.200ms="redirect_to">
					Redirect Ke-
				</x-input.basic>

				@error('redirect_to')
					<span class="mt-2 text-xs italic text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="flex w-full items-center justify-end gap-2">
				<x-button.danger id="cancel-create-participant" class="w-fit" wire:click="$set('showCreateForm', false)"> Batal
				</x-button.danger>
				<x-button.primary id="submit-create-participant" class="w-fit" wire:click="store"> Simpan </x-button.primary>
			</div>
		</form>

	</div>
</div>
