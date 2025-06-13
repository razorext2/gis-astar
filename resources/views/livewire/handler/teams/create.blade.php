<div>
	<form class="mt-4 flex w-full flex-col gap-2 lg:gap-4" wire:submit.prevent="store">
		<div>
			<x-input.basic :labels="true" wire:model.live="team_code" id="team_code" name="team_code" placeholder="Kode Tim"
				required>
				Kode Tim Baru:
			</x-input.basic>
			<span class="error mt-2 text-sm text-red-500">{{ $errors->first('team_code') }}</span>
		</div>
		<div>
			<x-input.basic :labels="true" wire:model.live="team_name" id="team_name" name="team_name" placeholder="Nama Tim"
				required>
				Nama Tim Baru:
			</x-input.basic>
			<span class="error mt-2 text-sm text-red-500">{{ $errors->first('team_name') }}</span>
		</div>
		<div>
			<x-input.basic :labels="true" wire:model.live="search_user" id="team_leader" name="team_leader"
				placeholder="Kode Pegawai" required>
				Kode Jari Ketua Tim:
			</x-input.basic>

			@if ($search_user != '')
				<div class="mt-4">
					@forelse ($users as $user)
						<div class="my-2 flex items-center">
							<div class="flex h-5 items-center">
								<input id="helper-radio-{{ $user->kode_pegawai }}" wire:model="team_leader"
									aria-describedby="helper-radio-text-{{ $user->kode_pegawai }}" type="radio" value="{{ $user->kode_pegawai }}"
									class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
							</div>
							<div class="ms-2">
								<p id="helper-radio-text-{{ $user->kode_pegawai }}"
									class="text-xs font-normal text-gray-500 dark:text-gray-300">{{ $user->kode_pegawai }}
								</p>
								<label for="helper-radio-{{ $user->kode_pegawai }}"
									class="font-medium text-gray-900 dark:text-gray-300">{{ $user->name }}</label>
							</div>
						</div>
					@empty
						<span class="mt-2 text-red-500">Tidak ada data</span>
					@endforelse

					@if ($users->count() >= 5)
						<span class="mt-2">...</span>
					@endif
				</div>
			@endif

			<span class="error mt-2 text-sm text-red-500">{{ $errors->first('team_leader') }}</span>
		</div>

		<div>
			<x-button.primary type="submit">
				<span wire:loading.remove wire:target="store">Simpan</span>
				<span wire:loading wire:target="store">Memproses...</span>
			</x-button.primary>
		</div>

	</form>
</div>
