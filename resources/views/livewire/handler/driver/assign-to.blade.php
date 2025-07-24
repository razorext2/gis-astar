<div class="w-full">
	<form wire:submit="assign" class="grid gap-4 md:grid-cols-2" id="laporan-content">

		<div class="w-full">
			<x-input.basic id="no_sr" name="no_sr" value="{{ $data->no_sr }}" readonly placeholder="No. SR">
				No. SR
			</x-input.basic>
		</div>

		<div class="w-full">
			<x-input.basic id="pt_name" name="pt_name" value="{{ $data->title }}" readonly placeholder="Nama Perusahaan">
				Nama PT.
			</x-input.basic>
		</div>

		<div class="col-span-2 w-full">
			<x-input.basic id="assign_date" name="assign_date"
				value="{{ Carbon\Carbon::parse($data->assign_date)->locale('id')->isoFormat('D MMMM YYYY') }}" readonly
				placeholder="Nama Perusahaan">
				Tanggal Pengantaran
			</x-input.basic>
		</div>

		<div class="col-span-2 w-full">
			<label for="driver" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Pilih Driver</label>
			<select id="driver" wire:model="kode_pegawai"
				class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
				<option selected>Pilih Driver</option>
				@foreach ($drivers as $row)
					<option value="{{ $row->kode_pegawai }}">{{ $row->name }}</option>
				@endforeach
			</select>

			@error('kode_pegawai')
				<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
			@enderror
		</div>

		<div class="relative col-span-2 w-full">
			<x-button.primary class="float-right" id="store" type="submit">
				<x-slot name="icon">
					<x-icons.angle-right class="icon h-5 w-5" />
				</x-slot>
				Assign Laporan
			</x-button.primary>
		</div>
	</form>
</div>
