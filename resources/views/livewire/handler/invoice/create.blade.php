<div class="grid gap-4 md:grid-cols-2" id="laporan-content">
	<div class="col-span-2 w-full">
		<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="nofakturpajak">
			Cari Bukti Tanda Terima Invoice
		</label>

		<form wire:submit="fetchFakturPajak" class="flex flex-col gap-2">
			<div class="relative">
				<div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
					<x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400" />
				</div>

				<x-input.basic class="ps-10" wire:model.live="fetchDataForm.nofakturpajak" id="nofakturpajak" required
					name="nofakturpajak" placeholder="No. Faktur Pajak" :labels="false" />

				<x-button.primary type="submit" class="absolute bottom-[1px] end-0 focus:outline" id="nofakturpajak_submit">
					<span wire:loading wire:target="fetchFakturPajak">Loading...</span>
					<span wire:loading.remove wire:target="fetchFakturPajak">Cek Data</span>
				</x-button.primary>
			</div>

			@error('fetchDataForm.nofakturpajak')
				<span class="error text-sm text-red-500">{{ $message }}</span>
			@enderror
		</form>

	</div>

	<form wire:submit="store" class="col-span-2 grid grid-cols-2 gap-4">
		<div class="col-span-2 grid grid-cols-2 gap-4 rounded-lg bg-gray-100 p-4 dark:bg-dark-secondary">
			<div class="w-full">
				<x-input.basic id="btt_number" readonly name="btt_number" wire:model="addForm.btt_number" placeholder="Nomor BTT">
					Nomor BTT
				</x-input.basic>

				@error('addForm.btt_number')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.basic id="btt_created_at" readonly name="btt_created_at" wire:model="addForm.btt_created_at"
					placeholder="Tanggal BTT Dibuat">
					Tanggal BTT Dibuat
				</x-input.basic>

				@error('addForm.btt_created_at')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="col-span-2 w-full">
				<x-input.basic id="company_name" readonly name="company_name" wire:model="addForm.company_name"
					placeholder="Nama Perusahaan">
					Nama PT
				</x-input.basic>

				@error('addForm.company_name')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.basic id="invoice_date" readonly name="invoice_date" wire:model="addForm.invoice_date"
					placeholder="Tanggal Invoice">
					Tanggal Invoice
				</x-input.basic>

				@error('addForm.invoice_date')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.basic id="receivable_number" readonly name="receivable_number" wire:model="addForm.receivable_number"
					placeholder="Nomor Piutang">
					Nomor Piutang
				</x-input.basic>

				@error('addForm.receivable_number')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.basic id="sale_number" name="sale_number" readonly wire:model="addForm.sale_number"
					placeholder="Nomor Penjualan">
					Nomor Penjualan
				</x-input.basic>

				@error('addForm.sale_number')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.basic id="tax_number" name="tax_number" readonly wire:model="addForm.tax_number"
					placeholder="Nomor Faktur Pajak">
					Nomor Faktur Pajak
				</x-input.basic>

				@error('addForm.tax_number')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

		</div>

		<div class="col-span-2 flex w-full flex-col">
			<p class="text-sm font-medium text-gray-900 dark:text-white">Status Saat Ini</p>
			<p class="font-semibold text-green-500">{{ $status ?? 'Sudah ready untuk diteruskan ke Piutang.' }}
			</p>
		</div>

		<div class="col-span-2 flex w-full flex-col">
			<label for="newest_status" class="block text-sm font-medium text-gray-900 dark:text-white">Status Baru</label>

			<x-input.textarea id="newest_status" name="newest_status" :labels="false" wire:model="addForm.newest_status"
				placeholder="Berikan status terbaru" />

			@error('addForm.newest_status')
				<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
			@enderror
		</div>

		<div class="w-full">
			<x-input.select id="invoice_type" name="invoice_type" :labels="true" wire:model.live="addForm.invoice_type"
				:textLabel="'Tipe Invoice'" :options="['dalkot' => 'Dalam Kota', 'lukot' => 'Luar Kota']" :defaultOption="'Pilih Tipe Invoice'" :value="$addForm->invoice_type" />

			@error('addForm.invoice_type')
				<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
			@enderror
		</div>

		<div class="w-full">
			<x-input.select id="delivery_status" name="delivery_status" :labels="true"
				wire:model.live="addForm.delivery_status" :textLabel="'Status Pengiriman'" :options="[
				    '0' => 'Belum dikirim',
				    '1' => 'Sedang Dalam Pengiriman',
				    '2' => 'Sudah diterima',
				    '3' => 'Belum Diterima',
				]" :defaultOption="'Pilih Status Pengiriman'"
				:value="$addForm->delivery_status" />

			@error('addForm.delivery_status')
				<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
			@enderror
		</div>

		@if ($addForm->delivery_status == 1 && $addForm->invoice_type == 'lukot')
			<div class="w-full">
				<x-input.select required id="invoice_destination" name="invoice_destination" :labels="true"
					wire:model.live="addForm.invoice_destination" :textLabel="'Tipe Pengiriman'" :options="['cust' => 'Customer Langsung', 'pku' => 'IDC Pekanbaru', 'jkt' => 'IDC Jakarta']" :defaultOption="'Pilih Tipe Pengiriman'"
					:value="$addForm->invoice_destination" />

				@error('addForm.invoice_destination')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.basic required id="resi_number" name="resi_number" :labels="true" wire:model.live="addForm.resi_number"
					placeholder="Nomor Resi">
					Nomor Resi
				</x-input.basic>

				@error('addForm.resi_number')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>
		@endif

		<div class="col-span-2 w-full">
			<p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Dokumentasi</p>
			<p class="mb-2 text-xs text-red-500"> *Dokumentasi dapat berupa <b>foto dokumen BTT, resi </b> atau lainnya </p>

			<div class="flex flex-col gap-2">
				<input type="file" wire:model="addForm.documentations" multiple>

				@error('addForm.documentations.*')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			{{-- <x-button.primary id="capture-button" type="button">
				<x-slot name="icon">
					<x-icons.plus class="icon h-5 w-5 text-blue-500 dark:text-white" />
				</x-slot>
				Ambil Foto
			</x-button.primary>

			<div class="relative overflow-auto">
				<div class="mt-2 flex overflow-x-auto" id="captured-images">
					<!-- Thumbnail gambar yang diambil akan muncul di sini -->
				</div>
			</div> --}}

			{{-- <div class="mt-2 hidden text-sm text-red-500" id="alert-images"></div> --}}
		</div>

		<div class="relative col-span-2 w-full">
			<x-button.primary class="float-right" id="store" type="submit">
				<x-slot name="icon">
					<x-icons.angle-right class="icon h-5 w-5" />
				</x-slot>
				Update Riwayat Invoice
			</x-button.primary>
		</div>
	</form>

	{{-- @livewire('utils.camera-stream-modal') --}}
</div>
