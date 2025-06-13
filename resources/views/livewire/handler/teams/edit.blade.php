<div>
	<form class="mt-4 flex w-full flex-col gap-2 lg:gap-4" wire:submit.prevent="store">
		<div>
			<x-input.basic :labels="true" readonly wire:model="team_name" id="team_name" name="team_name" placeholder="Nama Tim"
				required>
				Nama Tim :
			</x-input.basic>
			<span class="mt-2 text-xs text-red-500">*Anda tidak dapat mengubah nama tim</span>
		</div>
		<div>
			<x-input.basic :labels="true" wire:model.live="team_code" id="team_code" name="team_code" placeholder="Kode Tim"
				required>
				Kode Tim Baru:
			</x-input.basic>
			<span class="error mt-2 text-sm text-red-500">{{ $errors->first('team_code') }}</span>
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
								<input wire:model="team_leader" checked id="helper-radio-{{ $user->kode_pegawai }}"
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

		<div class="flex w-full flex-row justify-end gap-2">
			<x-button.primary type="submit">
				<span wire:loading.remove wire:target="store">Simpan</span>
				<span wire:loading wire:target="store">Memproses...</span>
			</x-button.primary>

			<x-button.danger type="button" wire:click="$set('removeTeamModal', true)">
				<span>Hapus Tim</span>
			</x-button.danger>
		</div>

	</form>

	{{-- show modal remove team --}}
	<div wire:show="removeTeamModal" wire:transition.duration.300ms
		class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
		<div
			class="relative mx-2 flex w-full flex-col gap-1 rounded-xl bg-white p-4 shadow-2xl dark:bg-dark-primary sm:mx-0 md:w-2/3 md:gap-2 lg:w-1/2 lg:p-6 xl:w-2/5">

			<div class="absolute right-0 top-0">
				<x-button.danger class="rounded-r-xl rounded-bl-xl rounded-br-none rounded-tl-none"
					wire:click="$set('removeTeamModal', false)">
					<x-icons.close class="h-5 w-5" />
				</x-button.danger>
			</div>

			<h2 class="mb-2 text-center text-xl font-semibold text-gray-900 dark:text-white lg:text-2xl">
				Hapus tim dengan kode: {{ $team_code }}
			</h2>

			<div class="mt-2 flex w-full justify-center gap-2">
				<x-button.danger wire:click="removeTeamProcess">
					<x-slot name="icon">
						<x-icons.trash-bin class="h-5 w-5" />
					</x-slot>
					Hapus
				</x-button.danger>

				<x-button.primary wire:click="$set('removeTeamModal', false)">Batal</x-button.primary>
			</div>

		</div>
	</div>
	{{-- end modal remove team --}}
</div>
