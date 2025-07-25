<div class="mt-4 grid gap-2 lg:gap-4">
	@forelse ($teams as $row)
		<div wire:key="{{ $row->team_code }}"
			class="rounded-lg bg-gray-50 p-2 ring-1 ring-gray-200 transition-all duration-300 dark:bg-gray-700 dark:ring-0 lg:p-4">
			<div class="flex w-full flex-row items-center justify-between gap-2">
				<div class="grow cursor-pointer" wire:click="showDetail('{{ $row->team_code }}')">
					<div class="mb-1 flex flex-col gap-0.5 text-gray-800 dark:text-gray-50 lg:flex-row lg:items-center lg:gap-2">
						<span class="text-2xl font-semibold">{{ $row->team_code }}</span>
						<span> - {{ $row->team_name }}</span>

						@can('team-edit')
							<x-button.link wire:navigate href="{{ route('teams.edit', $row->team_code) }}" class="w-fit !gap-0">
								<x-slot name="icon">
									<x-icons.pen class="h-4 w-4" />
								</x-slot>
							</x-button.link>
						@endcan
					</div>
					<p class="text-sm text-gray-600 dark:text-gray-300">
						Dikepalai oleh, <span class="font-semibold text-gray-600 dark:text-gray-200">{{ $row->leader->name }}</span>
					</p>
				</div>
				@can('team-member-add')
					<div class="grow-0">
						<x-button.primary wire:click="addMemberDialog('{{ $row->team_code }}')">
							<x-slot name="icon">
								<x-icons.plus class="h-5 w-5" />
							</x-slot>
							Anggota
						</x-button.primary>
					</div>
				@endcan
			</div>

			{{-- detail member --}}
			@if ($showMember === $row->team_code)
				<div wire:transition.duration.300ms>
					<livewire:team-member-table :teamCode="$row->team_code" :key="$row->team_code" />
				</div>
			@endif
			{{-- end detail member --}}
		</div>
	@empty
		<p class="text-center text-gray-600 dark:text-gray-300">Tidak ada data</p>
	@endforelse

	@can('team-member-add')
		{{-- modal add member --}}
		<div wire:show="showModal" wire:transition.duration.300ms
			class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
			@if ($showModal)
				<div
					class="relative mx-2 flex w-full flex-col gap-1 rounded-xl bg-white p-4 shadow-2xl dark:bg-dark-primary sm:mx-0 md:w-2/3 md:gap-2 lg:w-1/2 lg:p-6 xl:w-2/5">

					<div class="absolute right-0 top-0">
						<x-button.danger class="rounded-r-xl rounded-bl-xl rounded-br-none rounded-tl-none"
							wire:click="$set('showModal', false)">
							<x-icons.close class="h-5 w-5" />
						</x-button.danger>
					</div>

					<h2 class="mb-2 text-center text-xl font-semibold text-gray-900 dark:text-white lg:text-2xl">Tambah Anggota
						({{ $team_code }})</h2>

					<form class="flex flex-col gap-2" wire:submit.prevent="addMemberProcess">

						<div class="flex w-full flex-col">
							<x-input.basic required readonly class="cursor-default" id="teamCode" placeholder="Kode Tim..." name="teamCode"
								wire:model="team_code" :labels="true">
								Kode Tim
							</x-input.basic>
						</div>

						<div class="flex w-full flex-col">
							<x-input.basic id="kodePegawai" required placeholder="Kode Pegawai..." name="kodePegawai"
								wire:model.live.debounce.250ms="kode_pegawai" :labels="true">
								Pegawai
							</x-input.basic>

							@if ($kode_pegawai)
								<div class="mt-2">
									@forelse ($technicians as $technician)
										<div class="flex items-center py-1" wire:key="{{ $technician->kode_pegawai }}">
											<input id="member-{{ $technician->kode_pegawai }}" wire:model="newMember" type="checkbox"
												value="{{ $technician->kode_pegawai }}"
												class="h-4 w-4 rounded-sm border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
											<label for="member-{{ $technician->kode_pegawai }}"
												class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
												{{ $technician->kode_pegawai }} - {{ $technician->name }}
											</label>
										</div>
									@empty
										<p class="text-gray-600 dark:text-gray-300">Teknisi tidak ditemukan atau sudah menjadi bagian tim lain.</p>
									@endforelse
								</div>
							@endif
						</div>

						<div class="flex w-full flex-col">
							<x-input.select id="role" name="role" :defaultOption="'Pilih Role'" :options="[
							    // 'leader' => 'Leader',
							    'anggota' => 'Anggota',
							]" :labels="true"
								wire:model="role" :textLabel="'Role'" required />
						</div>

						<div class="mt-2 flex w-full justify-end">
							<x-button.primary type="submit">
								<x-slot name="icon">
									<x-icons.loading class="h-5 w-5" wire:loading wire:target="addMemberProcess" />
								</x-slot>

								<span wire:loading.remove wire:target="addMemberProcess"> Simpan </span>
							</x-button.primary>
						</div>

					</form>
				</div>
				{{-- @endif --}}
			@endif
		</div>
		{{-- end modal add member --}}
	@endcan

	@can('team-member-remove')
		{{-- modal remove member --}}
		<div wire:show="showRemoveMemberModal" wire:transition.duration.300ms
			class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
			@if ($showRemoveMemberModal)
				<div
					class="relative mx-2 flex w-full flex-col gap-1 rounded-xl bg-white p-4 shadow-2xl dark:bg-dark-primary sm:mx-0 md:w-2/3 md:gap-2 lg:w-1/2 lg:p-6 xl:w-2/5">

					<div class="absolute right-0 top-0">
						<x-button.danger class="rounded-r-xl rounded-bl-xl rounded-br-none rounded-tl-none"
							wire:click="$set('showRemoveMemberModal', false)">
							<x-icons.close class="h-5 w-5" />
						</x-button.danger>
					</div>

					<h2 class="mb-2 text-center text-xl font-semibold text-gray-900 dark:text-white lg:text-2xl">
						Hapus anggota tim {{ $team_code }} dengan kode {{ $kode_pegawai }}
					</h2>

					<div class="mt-2 flex w-full justify-center gap-2">
						<x-button.danger wire:click="removeMemberProcess('{{ $kode_pegawai }}', '{{ $team_code }}')">
							<x-slot name="icon">
								<x-icons.trash-bin class="h-5 w-5" />
							</x-slot>
							Hapus
						</x-button.danger>

						<x-button.primary wire:click="$set('showRemoveMemberModal', false)">Batal</x-button.primary>
					</div>

				</div>
			@endif
		</div>
		{{-- end modal remove member --}}
	@endcan
</div>
