<div class="w-full">
	<div class="grid gap-4 md:grid-cols-2" id="laporan-content">

		<div class="col-span-2 w-full">
			<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="no_sr">
				Cari No. SR
			</label>

			<form wire:submit="fetchSR" class="relative">
				<div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
					<x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400" />
				</div>

				<x-input.basic class="ps-10" wire:model="no_sr" id="no_sr" name="no_sr" placeholder="No. SR"
					:labels="false" />

				<x-button.primary type="submit" class="absolute bottom-[1px] end-0 focus:outline" id="no_sr_submit">
					Cek SR
				</x-button.primary>
			</form>

			@error('no_sr')
				<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
			@enderror
		</div>

		<form wire:submit="store" class="col-span-2 grid gap-4">
			<div class="w-full">
				<x-input.select id="driver_id" name="driver_id" :defaultOption="'Pilih Tujuan Perjalanan'" wire:model="pt_type" :options="[
				    'ATRBRG' => 'Antar Barang (SR)',
				]">
					<x-slot name="textLabel">Tujuan Perjalanan</x-slot>
				</x-input.select>

				@error('pt_type')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.date id="assign_date" name="assign_date" wire:model="assign_date" placeholder="Tanggal Assign">
					Tanggal Assign
				</x-input.date>

				@error('assign_date')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.basic id="name" name="name" wire:model="pt_name" placeholder="Nama Perusahaan">
					Nama PT
				</x-input.basic>

				@error('pt_name')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.basic id="address" name="address" wire:model="pt_address" placeholder="Jl. XXXX">
					Alamat PT
				</x-input.basic>

				@error('pt_address')
					<span id="pt_address" class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="relative w-full">
				<x-button.primary class="float-right" id="store" type="submit">
					<x-slot name="icon">
						<x-icons.angle-right class="icon h-5 w-5" />
					</x-slot>
					Buat Laporan
				</x-button.primary>
			</div>
		</form>
	</div>
</div>
