@if (data_get($setUp, 'header.softDeletes'))
	<div class="mr-0 mt-2 sm:mt-0" x-data="{ open: false }" @click.outside="open = false">
		<button
			class="focus:ring-primary-600 focus-within:focus:ring-primary-600 focus-within:ring-primary-600 dark:focus-within:ring-primary-600 flex w-auto rounded-md rounded-md border-0 bg-transparent bg-white px-3 py-2 text-gray-600 ring-0 ring-1 ring-gray-300 transition placeholder:text-gray-400 focus-within:ring-2 focus:outline-none dark:bg-pg-primary-800 dark:text-pg-primary-300 dark:placeholder-pg-primary-400 dark:ring-pg-primary-600 sm:text-sm sm:leading-6"
			@click.prevent="open = ! open">
			<div class="flex">
				<x-livewire-powergrid::icons.trash class="text-pg-primary-500 dark:text-pg-primary-300" />
			</div>
		</button>

		<div class="absolute z-10 mt-2 w-48 bg-white py-2 shadow-xl dark:bg-pg-primary-700" x-show="open" x-cloak
			x-transition:enter="transform duration-200" x-transition:enter-start="opacity-0 scale-90"
			x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transform duration-200"
			x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">

			<div
				class="hover:text-black-200 block flex cursor-pointer justify-start px-4 py-2 text-pg-primary-800 hover:bg-pg-primary-50 dark:text-pg-primary-200 dark:hover:bg-gray-900 dark:hover:bg-pg-primary-700"
				x-on:click="$wire.dispatch('pg:softDeletes-{{ $tableName }}', {softDeletes: ''}); open = false">
				@lang('livewire-powergrid::datatable.soft_deletes.without_trashed')
			</div>
			<div
				class="hover:text-black-200 block flex cursor-pointer justify-start px-4 py-2 text-pg-primary-800 hover:bg-pg-primary-50 dark:text-pg-primary-200 dark:hover:bg-gray-900 dark:hover:bg-pg-primary-700"
				x-on:click="$wire.dispatch('pg:softDeletes-{{ $tableName }}', {softDeletes: 'withTrashed'}); open = false">
				@lang('livewire-powergrid::datatable.soft_deletes.with_trashed')
			</div>
			<div
				class="hover:text-black-200 block flex cursor-pointer justify-start px-4 py-2 text-pg-primary-800 hover:bg-pg-primary-50 dark:text-pg-primary-200 dark:hover:bg-gray-900 dark:hover:bg-pg-primary-700"
				x-on:click="$wire.dispatch('pg:softDeletes-{{ $tableName }}', {softDeletes: 'onlyTrashed'}); open = false">
				@lang('livewire-powergrid::datatable.soft_deletes.only_trashed')
			</div>

		</div>
	</div>
@endif
