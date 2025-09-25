<div class="grid gap-4 md:grid-cols-2" id="laporan-content">
	<div class="col-span-2 w-full">
		<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="btt">
			Cari Bukti Tanda Terima Invoice
		</label>

		<form wire:submit="fetchBTT" class="relative">
			<div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
				<x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400" />
			</div>

			<x-input.basic class="ps-10" wire:model="btt" id="btt" name="btt" placeholder="No. BTT"
				:labels="false" />

			<x-button.primary type="submit" class="absolute bottom-[1px] end-0 focus:outline" id="btt_submit">
				<span wire:loading wire:target="fetchBTT">Loading...</span>
				<span wire:loading.remove wire:target="fetchBTT">Cek BTT</span>
			</x-button.primary>
		</form>

		@error('btt')
			<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
		@enderror
	</div>

	<form wire:submit="store" class="col-span-2 flex flex-col gap-4">
		<div class="grid grid-cols-2 gap-4 rounded-lg bg-gray-100 p-4 dark:bg-dark-secondary">
			<div class="w-full">
				<x-input.basic id="btt_number" name="btt_number" wire:model="addForm.btt_number" placeholder="Nomor BTT">
					Nomor BTT
				</x-input.basic>

				@error('addForm.btt_number')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.basic id="btt_created_at" name="btt_created_at" wire:model="addForm.btt_created_at"
					placeholder="Tanggal BTT Dibuat">
					Tanggal BTT Dibuat
				</x-input.basic>

				@error('addForm.btt_created_at')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="col-span-2 w-full">
				<x-input.basic id="company_name" name="company_name" wire:model="addForm.company_name"
					placeholder="Nama Perusahaan">
					Nama PT
				</x-input.basic>

				@error('addForm.company_name')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.basic id="invoice_date" name="invoice_date" wire:model="addForm.invoice_date"
					placeholder="Tanggal Invoice">
					Tanggal Invoice
				</x-input.basic>

				@error('addForm.invoice_date')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.basic id="receivable_number" name="receivable_number" wire:model="addForm.receivable_number"
					placeholder="Nomor Piutang">
					Nomor Piutang
				</x-input.basic>

				@error('addForm.receivable_number')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.basic id="sale_number" name="sale_number" wire:model="addForm.sale_number" placeholder="Nomor Penjualan">
					Nomor Penjualan
				</x-input.basic>

				@error('addForm.sale_number')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

			<div class="w-full">
				<x-input.basic id="tax_number" name="tax_number" wire:model="addForm.tax_number" placeholder="Nomor Faktur Pajak">
					Nomor Faktur Pajak
				</x-input.basic>

				@error('addForm.tax_number')
					<span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
				@enderror
			</div>

		</div>

		<div class="flex w-full flex-col gap-2">
			<p class="text-sm font-medium text-gray-900 dark:text-white">Status Saat Ini</p>
			<p class="font-semibold text-green-500">Sudah ready untuk diteruskan ke Piutang.</p>
		</div>

		<div class="flex w-full flex-col gap-2">
			<label for="newest_status" class="block text-sm font-medium text-gray-900 dark:text-white">Status Baru</label>

			<x-input.textarea id="newest_status" name="newest_status" :labels="false" wire:model="newest_status"
				placeholder="Catatan" />
		</div>

		<div class="relative w-full">
			<x-button.primary class="float-right" id="store" type="submit">
				<x-slot name="icon">
					<x-icons.angle-right class="icon h-5 w-5" />
				</x-slot>
				Update Riwayat Invoice
			</x-button.primary>
		</div>
	</form>
</div>
